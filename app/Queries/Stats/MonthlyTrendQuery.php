<?php

namespace App\Queries\Stats;

use App\Models\Transaction;
use Carbon\Carbon;

// Returns income and expenses totals for the last N months (default 6), ordered oldest → newest.
// Used to render the trend line/bar chart on the stats page.
// Labels are translated month abbreviations (e.g. 'Gen', 'Feb') based on the active locale.
class MonthlyTrendQuery
{
    public function __construct(private int $months = 6) {}

    public function handle(): array
    {
        $result = [];

        for ($i = $this->months - 1; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $result[] = [
                'label'    => $date->translatedFormat('M'),
                'income'   => (float) Transaction::where('type', 'income')
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->sum('amount'),
                'expenses' => (float) Transaction::where('type', 'expense')
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->sum('amount'),
            ];
        }

        return $result;
    }
}
