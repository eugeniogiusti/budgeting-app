<?php

namespace App\Queries\Budget;

use App\Models\Transaction;

// Returns total income and total expenses for a given month.
// Used on the home dashboard and budget page to show the month summary bar.
class MonthlySummaryQuery
{
    public function __construct(
        private int $year,
        private int $month,
    ) {}

    public function handle(): array
    {
        return [
            'income' => (float) Transaction::where('type', 'income')
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->sum('amount'),

            'expenses' => (float) Transaction::where('type', 'expense')
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->sum('amount'),
        ];
    }
}
