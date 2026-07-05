<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Seamless on-site chat bridged to the owner's WhatsApp via Meta Cloud API.
 *
 * Flow:
 *  1. Visitor types in the on-page widget  -> POST /chat/send
 *     We store it and relay it to the owner's WhatsApp. The Cloud API message
 *     id we get back is stored on the visitor row so replies can be threaded.
 *  2. Owner swipe-replies in WhatsApp      -> Meta POSTs /whatsapp/webhook
 *     context.id = the id of our relayed message -> we resolve the session and
 *     store the reply as an "agent" message.
 *  3. Widget polls /chat/poll             -> new agent replies appear inline.
 */
class WhatsAppChatController extends Controller
{
    /** Meta webhook verification (GET). */
    public function verify(Request $request)
    {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode === 'subscribe' && $token && $token === config('whatsapp.verify_token')) {
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        return response('Forbidden', 403);
    }

    /** Inbound messages from Meta (POST). */
    public function webhook(Request $request)
    {
        $ownerNumber = preg_replace('/\D/', '', (string) config('whatsapp.owner_number'));

        foreach ($request->input('entry', []) as $entry) {
            foreach ($entry['changes'] ?? [] as $change) {
                $value = $change['value'] ?? [];

                foreach ($value['messages'] ?? [] as $msg) {
                    // Only text replies are bridged
                    if (($msg['type'] ?? null) !== 'text') {
                        continue;
                    }

                    $from = preg_replace('/\D/', '', $msg['from'] ?? '');
                    // Only accept replies from the owner's number
                    if ($ownerNumber && $from !== $ownerNumber) {
                        continue;
                    }

                    $body = trim($msg['text']['body'] ?? '');
                    if ($body === '') {
                        continue;
                    }

                    $contextId = $msg['context']['id'] ?? null;
                    $session = $this->resolveSession($contextId);

                    if (!$session) {
                        // No thread match — attach to the most recently active visitor
                        $session = optional(
                            ChatMessage::where('direction', 'visitor')->latest()->first()
                        )->session_id;
                    }

                    if (!$session) {
                        continue; // nothing to attach the reply to
                    }

                    ChatMessage::create([
                        'session_id'    => $session,
                        'direction'     => 'agent',
                        'body'          => $body,
                        'wa_message_id' => $msg['id'] ?? null,
                    ]);
                }
            }
        }

        // Always 200 so Meta stops retrying
        return response()->json(['received' => true]);
    }

    /** Visitor sends a message from the widget (POST). */
    public function send(Request $request)
    {
        $data = $request->validate([
            'session_id' => 'required|string|max:100',
            'message'    => 'required|string|max:2000',
            'name'       => 'nullable|string|max:100',
        ]);

        $visitor = ChatMessage::create([
            'session_id'   => $data['session_id'],
            'direction'    => 'visitor',
            'body'         => $data['message'],
            'visitor_name' => $data['name'] ?? null,
        ]);

        if (!config('whatsapp.enabled')) {
            // Bridge not configured — tell the widget to use the wa.me fallback
            return response()->json(['success' => true, 'bridged' => false]);
        }

        $name = $data['name'] ?: 'Website visitor';
        $relay = "🌐 Web chat — {$name}\n\n{$data['message']}\n\n↩️ Reply to THIS message to answer.";

        $waId = $this->sendToOwner($relay);

        if ($waId) {
            $visitor->update(['wa_message_id' => $waId]);
        }

        return response()->json(['success' => true, 'bridged' => (bool) $waId]);
    }

    /** Widget polls for new agent replies (GET). */
    public function poll(Request $request)
    {
        $data = $request->validate([
            'session_id' => 'required|string|max:100',
            'after'      => 'nullable|integer',
        ]);

        $messages = ChatMessage::where('session_id', $data['session_id'])
            ->where('direction', 'agent')
            ->when(!empty($data['after']), fn ($q) => $q->where('id', '>', $data['after']))
            ->orderBy('id')
            ->get(['id', 'body', 'created_at']);

        return response()->json([
            'success'  => true,
            'messages' => $messages,
        ]);
    }

    /** Resolve which visitor session a quoted (replied-to) message belongs to. */
    private function resolveSession(?string $contextId): ?string
    {
        if (!$contextId) {
            return null;
        }

        return optional(
            ChatMessage::where('wa_message_id', $contextId)->first()
        )->session_id;
    }

    /** Send a text message to the owner via Cloud API; returns the message id. */
    private function sendToOwner(string $text): ?string
    {
        $phoneId = config('whatsapp.phone_number_id');
        $token   = config('whatsapp.token');
        $to      = preg_replace('/\D/', '', (string) config('whatsapp.owner_number'));
        $version = config('whatsapp.api_version', 'v21.0');

        if (!$phoneId || !$token || !$to) {
            return null;
        }

        try {
            $response = Http::withToken($token)
                ->post("https://graph.facebook.com/{$version}/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to'                => $to,
                    'type'              => 'text',
                    'text'              => ['body' => $text],
                ]);

            if ($response->successful()) {
                return $response->json('messages.0.id');
            }

            Log::warning('WhatsApp relay failed', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Throwable $e) {
            Log::error('WhatsApp relay exception: ' . $e->getMessage());
        }

        return null;
    }
}
