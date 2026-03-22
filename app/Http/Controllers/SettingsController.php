<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $localeLabels = ['it' => 'Italiano', 'en' => 'English'];
        $currencyLabels = ['EUR' => 'EUR (€)', 'USD' => 'USD ($)', 'GBP' => 'GBP (£)', 'CHF' => 'CHF'];

        $locales = [];
        foreach (config('budget.locales') as $code) {
            $locales[$code] = $localeLabels[$code] ?? $code;
        }

        $currencies = [];
        foreach (config('budget.currencies') as $code) {
            $currencies[$code] = $currencyLabels[$code] ?? $code;
        }

        return view('settings.index', [
            'locale'       => Setting::get('locale',    config('budget.default_locale')),
            'currencyCode' => Setting::get('currency', config('budget.default_currency')),
            'locales'      => $locales,
            'currencies'   => $currencies,
        ]);
    }

    public function update(StoreSettingsRequest $request): RedirectResponse
    {
        Setting::set('locale',   $request->validated('locale'));
        Setting::set('currency', $request->validated('currency'));

        session()->flash('success', __('ui.toast_settings_saved'));

        return redirect()->route('settings.index');
    }
}
