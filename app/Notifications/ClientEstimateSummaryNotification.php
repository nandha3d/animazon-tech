<?php

namespace App\Notifications;

use App\Models\CostEstimate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientEstimateSummaryNotification extends Notification
{
    use Queueable;

    protected CostEstimate $estimate;

    public function __construct(CostEstimate $estimate)
    {
        $this->estimate = $estimate;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $estimate = $this->estimate;
        $projectType = $estimate->projectType;
        $settings = \App\Models\Utility::settings();
        $companyName = $settings['company_name'] ?? 'Animazon';

        return (new MailMessage)
            ->subject('Your ' . $companyName . ' Project Estimate - ' . ($projectType->name ?? 'Project'))
            ->greeting('Hello ' . $estimate->visitor_name . ',')
            ->line('Thank you for requesting an estimate with ' . $companyName . '! Here is a summary of your project details:')
            ->line('**Project Type:** ' . ($projectType->name ?? 'N/A'))
            ->line('**Estimated Cost:** ' . $estimate->currency_code . ' ' . number_format($estimate->grand_total, 2))
            ->line('**Estimated Timeline:** ' . $estimate->timeline_weeks . ' weeks')
            ->line('**Team Size Needed:** ' . $estimate->team_size . ' members')
            ->line('---')
            ->line('Our team will review these details and get back to you shortly with next steps and a formal proposal.')
            ->action('View Estimate & Pay Advance', url('/cost-estimate/' . $estimate->id))
            ->line('We look forward to working with you!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
