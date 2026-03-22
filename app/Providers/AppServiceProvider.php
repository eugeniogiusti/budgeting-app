<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        try {
            $code = Setting::get('currency', 'EUR');
        } catch (\Throwable) {
            $code = 'EUR';
        }

        View::share('currency', match ($code) {
            'USD'   => '$',
            default => '€',
        });
    }
}
