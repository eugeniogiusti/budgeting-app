<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

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
