<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientMaintenancePlan extends Model
{
    protected $fillable = [
        'client_id',
        'service_type',
        'title',
        'amount',
        'billing_cycle',
        'start_date',
        'next_due_date',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'start_date'    => 'date',
        'next_due_date' => 'date',
        'amount'        => 'decimal:2',
    ];

    /** Cycle key => [label, months to add on renewal]. 'one_time' never auto-advances. */
    public static function cycles(): array
    {
        return [
            'monthly'     => ['label' => 'Monthly', 'months' => 1],
            'quarterly'   => ['label' => 'Quarterly', 'months' => 3],
            'half_yearly' => ['label' => 'Half-Yearly', 'months' => 6],
            'yearly'      => ['label' => 'Yearly', 'months' => 12],
            'one_time'    => ['label' => 'One-time', 'months' => 0],
        ];
    }

    /** Common service-type suggestions; field itself stays free text. */
    public static function serviceTypeSuggestions(): array
    {
        return [
            'Website Maintenance',
            'Software / App Maintenance',
            'Hosting & Server Support',
            '3D Animation Retainer',
            'Design Retainer',
            'SEO / Marketing Retainer',
        ];
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function cycleLabel(): string
    {
        return self::cycles()[$this->billing_cycle]['label'] ?? ucfirst($this->billing_cycle);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'active' && $this->next_due_date && $this->next_due_date->lt(now()->startOfDay());
    }

    public function daysUntilDue(): ?int
    {
        if (!$this->next_due_date) {
            return null;
        }

        return (int) now()->startOfDay()->diffInDays($this->next_due_date, false);
    }

    /**
     * Advance next_due_date by one billing cycle from itself (or from today if
     * overdue, so we don't pile up back-dates). One-time plans are marked
     * cancelled instead of advancing, since there's nothing left to renew.
     */
    public function advanceCycle(): void
    {
        $months = self::cycles()[$this->billing_cycle]['months'] ?? 0;

        if ($months <= 0) {
            $this->status = 'cancelled';
            $this->save();

            return;
        }

        $base = $this->next_due_date && $this->next_due_date->gte(now()->startOfDay())
            ? $this->next_due_date
            : now()->startOfDay();

        $this->next_due_date = $base->copy()->addMonths($months);
        $this->save();
    }

    /** Active plans for a creator whose next_due_date is due within $days (or overdue). */
    public static function dueSoon($createdBy, int $days = 30)
    {
        $limit = now()->startOfDay()->addDays($days)->toDateString();

        return static::where('created_by', $createdBy)
            ->where('status', 'active')
            ->whereNotNull('next_due_date')
            ->whereDate('next_due_date', '<=', $limit)
            ->orderBy('next_due_date')
            ->get();
    }
}
