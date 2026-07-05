<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAsset extends Model
{
    protected $fillable = [
        'client_id',
        'label',
        'website_url',
        'admin_url',
        'admin_username',
        'admin_password',
        'hosting_provider',
        'cpanel_url',
        'cpanel_username',
        'cpanel_password',
        'ftp_host',
        'ftp_username',
        'ftp_password',
        'ssh_host',
        'db_name',
        'domain_registrar',
        'ssl_expiry',
        'hosting_renewal',
        'hosting_amount',
        'domain_renewal',
        'notes',
        'created_by',
    ];

    /**
     * Secrets are encrypted at rest (AES-256-CBC via APP_KEY). Never plaintext.
     */
    protected $casts = [
        'admin_password'  => 'encrypted',
        'cpanel_password' => 'encrypted',
        'ftp_password'    => 'encrypted',
        'ssl_expiry'      => 'date',
        'hosting_renewal' => 'date',
        'hosting_amount'  => 'decimal:2',
        'domain_renewal'  => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /** Date columns that represent a renewal / expiry deadline. */
    public static function renewalFields(): array
    {
        return [
            'ssl_expiry'      => 'SSL Certificate',
            'hosting_renewal' => 'Hosting',
            'domain_renewal'  => 'Domain',
        ];
    }

    /**
     * Assets for a creator that have any renewal due on/before now()+$days
     * (includes already-overdue items so they keep surfacing until renewed).
     */
    public static function expiring($createdBy, int $days = 30)
    {
        $limit = now()->startOfDay()->addDays($days)->toDateString();

        return static::where('created_by', $createdBy)
            ->where(function ($q) use ($limit) {
                foreach (array_keys(self::renewalFields()) as $col) {
                    $q->orWhere(function ($qq) use ($col, $limit) {
                        $qq->whereNotNull($col)->whereDate($col, '<=', $limit);
                    });
                }
            })
            ->get();
    }

    /**
     * Renewal items on this asset due within $days (or overdue).
     * Returns rows: ['label','type','date','days_left','overdue'].
     */
    public function dueRenewals(int $days = 30): array
    {
        $today = now()->startOfDay();
        $limit = $today->copy()->addDays($days);
        $out   = [];

        foreach (self::renewalFields() as $col => $label) {
            $date = $this->{$col};
            if (empty($date)) {
                continue;
            }
            if ($date->lte($limit)) {
                $daysLeft = $today->diffInDays($date, false);
                $out[]    = [
                    'label'     => $label,
                    'type'      => $col,
                    'date'      => $date->format('Y-m-d'),
                    'days_left' => (int) $daysLeft,
                    'overdue'   => $daysLeft < 0,
                    'amount'    => $col === 'hosting_renewal' ? $this->hosting_amount : null,
                ];
            }
        }

        return $out;
    }
}
