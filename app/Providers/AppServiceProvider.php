<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Nuclear fix: globally disable SSL certificate verification at the PHP level.
        // This is required because Hostinger's SMTP server has a certificate that
        // fails verification, and Symfony Mailer ignores Laravel's config-level
        // stream settings. This sets the DEFAULT context for ALL PHP streams.
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        // Also keep the Laravel config-level setting as a belt-and-suspenders approach
        config([
            'mail.mailers.smtp.stream' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ],
            'mail.mailers.smtp.verify_peer' => false,
            'mail.mailers.smtp.verify_peer_name' => false,
        ]);
    }
}
