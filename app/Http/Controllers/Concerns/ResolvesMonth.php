<?php

namespace App\Http\Controllers\Concerns;

use Carbon\Carbon;

trait ResolvesMonth
{
    // Resolve the month to display from the request's year/month params, defaulting to the current month.
    protected function getSelectedMonth(): Carbon
    {
        $year  = request()->integer('year',  Carbon::now()->year);
        $month = request()->integer('month', Carbon::now()->month);

        return Carbon::createFromDate($year, $month, 1);
    }

    // Build the year/month query params for navigating to a month relative to the given date (e.g. -1 = previous, +1 = next).
    protected function monthParams(Carbon $date, int $offset): array
    {
        $d = $date->copy()->addMonths($offset);

        return ['year' => $d->year, 'month' => $d->month];
    }
}
