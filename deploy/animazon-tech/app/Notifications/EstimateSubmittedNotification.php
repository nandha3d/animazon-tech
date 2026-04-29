<?php

namespace App\Notifications;

use App\Models\CostEstimate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstimateSubmittedNotification extends Notification
{
    use Queueable;

    protected CostEstimate $estimate;

    public function __construct(CostEstimate $estimate)
    {
        $this->estimate = $estimate;
    }

    public function via($notifiable): array
    {
        // On-demand notifications (e.g. Notification::route('mail', ...)) don't have a database record
        if ($notifiable instanceof \Illuminate\Notifications\AnonymousNotifiable) {
            return ['mail'];
        }

        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $estimate = $this->estimate;
        $projectType = $estimate->projectType;

        return (new MailMessage)
            ->subject('🚀 New Project Estimate Request - ' . ($projectType->name ?? 'Unknown'))
            ->greeting('New Lead from Project Calculator!')
            ->line('**Visitor:** ' . $estimate->visitor_name)
            ->line('**Email:** ' . $estimate->visitor_email)
            ->line('**Phone:** ' . ($estimate->visitor_phone ?: 'Not provided'))
            ->line('**Project Type:** ' . ($projectType->name ?? 'N/A'))
            ->line('**Estimated Cost:** $' . number_format($estimate->grand_total, 2) . ' USD')
            ->line('**Timeline:** ' . $estimate->timeline_weeks . ' weeks')
            ->line('**Team Size:** ' . $estimate->team_size . ' members')
            ->line('**Notes:** ' . ($estimate->notes ?: 'None'))
            ->action('View Full Estimate Document', url('/cost-estimate/' . $estimate->id))
            ->line('Follow up promptly to convert this lead!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'estimate_submitted',
            'estimate_id' => $this->estimate->id,
            'visitor_name' => $this->estimate->visitor_name,
            'visitor_email' => $this->estimate->visitor_email,
            'project_type' => $this->estimate->projectType->name ?? 'N/A',
            'grand_total' => $this->estimate->grand_total,
        ];
    }
}
