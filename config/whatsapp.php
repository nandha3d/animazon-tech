<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Cloud API (Meta) — seamless on-site chat bridge
    |--------------------------------------------------------------------------
    | Visitor chats on the website widget. Each message is relayed to the
    | owner's WhatsApp via the Cloud API. The owner swipe-replies in WhatsApp;
    | the webhook matches the quoted message id back to the visitor's session
    | and the reply appears inline on the site (no redirect for the visitor).
    |
    | Leave WHATSAPP_TOKEN empty to disable the bridge — the widget then falls
    | back to the classic wa.me handoff automatically.
    */

    // Permanent/System-user access token from Meta
    'token' => env('WHATSAPP_TOKEN', ''),

    // Phone Number ID of the number registered to the Cloud API (NOT the display number)
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID', ''),

    // The owner's WhatsApp number that receives web leads (intl format, digits only, e.g. 918089405950)
    'owner_number' => env('WHATSAPP_OWNER_NUMBER', ''),

    // Any random string you choose; must match what you enter in Meta's webhook setup
    'verify_token' => env('WHATSAPP_VERIFY_TOKEN', ''),

    // Graph API version
    'api_version' => env('WHATSAPP_API_VERSION', 'v21.0'),

    'enabled' => (bool) env('WHATSAPP_TOKEN', ''),
];
