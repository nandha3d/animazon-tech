<?php

namespace App\Notifications;

use App\Models\CostEstimate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstimateAcceptedNotification extends Notification
{
    use Queueable;

    protected CostEstimate $estimate;
    protected string $paymentId;
    protected float $amount;

    public function __construct(CostEstimate $estimate, string $paymentId, float $amount)
    {
        $this->estimate = $estimate;
        $this->paymentId = $paymentId;
        $this->amount = $amount;
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
            ->subject('Estimate Accepted & Advance Paid - ' . ($projectType->name ?? 'Project'))
            ->greeting('Great News! A client has accepted an estimate.')
            ->line('**Client:** ' . $estimate->visitor_name)
            ->line('**Email:** ' . $estimate->visitor_email)
            ->line('**Phone:** ' . ($estimate->visitor_phone ?: 'Not provided'))
            ->line('**Project Type:** ' . ($projectType->name ?? 'N/A'))
            ->line('**Grand Total:** ' . $estimate->currency_code . ' ' . number_format($estimate->grand_total, 2))
            ->line('---')
            ->line('**💰 Payment Details:**')
            ->line('**Amount Paid:** ₹' . number_format($this->amount, 2))
            ->line('**Razorpay Payment ID:** ' . $this->paymentId)
            ->line('**Paid At:** ' . now()->format('M d, Y h:i A'))
            ->line('---')
            ->action('View Estimate Document', url('/cost-estimate/' . $estimate->id))
            ->line('Please begin project onboarding for this client.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
