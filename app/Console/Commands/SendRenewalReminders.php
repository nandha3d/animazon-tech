<?php

namespace App\Console\Commands;

use App\Models\ClientAsset;
use App\Models\ClientMaintenancePlan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRenewalReminders extends Command
{
    /**
     * Window (days) is configurable; defaults to 30.
     */
    protected $signature = 'assets:renewal-reminders {--days=30}';

    protected $description = 'Email each company the client website renewals (SSL/hosting/domain) and maintenance/retainer plans due soon or overdue';

    public function handle()
    {
        $days = (int) $this->option('days');
        if ($days < 1) {
            $days = 30;
        }

        // each company (created_by owner) gets its own digest of due renewals
        $companies = User::whereIn('type', ['company', 'super admin'])->get();

        $total = 0;
        foreach ($companies as $company) {
            // build a flat list of due website renewals across this company's assets
            $items = [];
            foreach (ClientAsset::expiring($company->id, $days) as $asset) {
                foreach ($asset->dueRenewals($days) as $due) {
                    $items[] = array_merge($due, [
                        'client' => optional($asset->client)->name,
                        'label'  => $asset->label,
                        'kind'   => $due['label'],
                    ]);
                }
            }
            usort($items, fn ($a, $b) => $a['days_left'] <=> $b['days_left']);

            // build a flat list of due maintenance/retainer plans
            $maintenanceItems = [];
            foreach (ClientMaintenancePlan::dueSoon($company->id, $days) as $plan) {
                $maintenanceItems[] = [
                    'client'    => optional($plan->client)->name,
                    'service'   => $plan->service_type,
                    'title'     => $plan->title,
                    'amount'    => $plan->amount,
                    'date'      => $plan->next_due_date->format('Y-m-d'),
                    'days_left' => $plan->daysUntilDue(),
                    'overdue'   => $plan->isOverdue(),
                ];
            }
            usort($maintenanceItems, fn ($a, $b) => $a['days_left'] <=> $b['days_left']);

            if (empty($items) && empty($maintenanceItems)) {
                continue;
            }

            $total += count($items) + count($maintenanceItems);

            Log::info('assets.renewal_reminder', [
                'company_id'         => $company->id,
                'email'              => $company->email,
                'renewal_count'      => count($items),
                'maintenance_count'  => count($maintenanceItems),
            ]);

            $this->line("• {$company->name} <{$company->email}>: " . count($items) . ' renewal(s), ' . count($maintenanceItems) . ' maintenance due');

            if (empty($company->email)) {
                continue;
            }

            try {
                Mail::send('emails.renewal-reminders', [
                    'company'          => $company,
                    'items'            => $items,
                    'maintenanceItems' => $maintenanceItems,
                    'days'             => $days,
                ], function ($m) use ($company) {
                    $m->to($company->email, $company->name)
                        ->subject(__('Upcoming renewals & maintenance billing'));
                });
            } catch (\Throwable $e) {
                $this->warn("  mail failed for {$company->email}: " . $e->getMessage());
                Log::warning('assets.renewal_reminder.mail_failed', [
                    'company_id' => $company->id,
                    'error'      => $e->getMessage(),
                ]);
            }
        }

        $this->info("Renewal reminders processed. Total due items: {$total}.");

        return self::SUCCESS;
    }
}
