<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

// Reads the locale saved in the settings table (e.g. 'it', 'en') and sets it as the
// application locale for every request, so all __() translations use the right language.
// The try/catch handles the case where the settings table does not exist yet (e.g. before migrations).
// Supported locales: 'it' (default), 'en' — defined in config/budget.php → locales.
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $locale = Setting::get('locale', 'it');
        } catch (\Throwable) {
            $locale = 'it';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
