<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share the currency symbol globally with all views (e.g. $currency → '€' or '$').
        // try/catch handles the case where the settings table does not exist yet (before migrations).
        // GBP and CHF intentionally map to '€' default — their formatting is handled at the view level.
        try {
            $code = Setting::get('currency', 'EUR');
        } catch (\Throwable) {
            $code = 'EUR';
        }

        View::share('currency', match ($code) {
            'USD'   => '$',
            default => '€',
        });

        // Provide sidebar menu data via View Composer so the sidebar partial
        // doesn't need @php blocks to call MenuHelper directly.
        View::composer('layouts.sidebar', function ($view) {
            $view->with('menuGroups', MenuHelper::getMenuGroups())
                 ->with('currentPath', request()->path());
        });
    }
}
