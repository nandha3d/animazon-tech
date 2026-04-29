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
        
        $answersHtml = '';
        foreach($estimate->answers as $ans) {
            $questionText = $ans->question->question ?? 'Question';
            if ($ans->answer_id) {
                $answerText = $ans->answerDef->answer ?? 'Selected';
            } else {
                $answerText = $ans->answer_value;
            }
            $answersHtml .= "- **{$questionText}**: {$answerText}\n";
        }

        return (new MailMessage)
            ->subject('Your Animazon Project Estimate - ' . ($projectType->name ?? 'Project'))
            ->greeting('Hello ' . $estimate->visitor_name . ',')
            ->line('Thank you for requesting an estimate with Animazon! Here is a summary of your project details:')
            ->line('**Project Type:** ' . ($projectType->name ?? 'N/A'))
            ->line('**Estimated Cost:** $' . number_format($estimate->grand_total, 2) . ' USD')
            ->line('**Estimated Timeline:** ' . $estimate->timeline_weeks . ' weeks')
            ->line('**Team Size Needed:** ' . $estimate->team_size . ' members')
            ->line('---')
            ->line('**Your Requirements:**')
            ->line($answersHtml)
            ->line('---')
            ->line('Our team will review these details and get back to you shortly with next steps and a formal proposal.')
            ->action('View Full Estimate Document', url('/cost-estimate/' . $estimate->id))
            ->line('We look forward to working with you!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
