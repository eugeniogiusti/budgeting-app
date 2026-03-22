<?php

namespace App\Http\Controllers\Concerns;

use Carbon\Carbon;

trait ResolvesMonth
{
    protected function getSelectedMonth(): Carbon
    {
        $year  = request()->integer('year',  Carbon::now()->year);
        $month = request()->integer('month', Carbon::now()->month);

        return Carbon::createFromDate($year, $month, 1);
    }

    protected function monthParams(Carbon $date, int $offset): array
    {
        $d = $date->copy()->addMonths($offset);

        return ['year' => $d->year, 'month' => $d->month];
    }
}
