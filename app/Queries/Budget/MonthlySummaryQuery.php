<?php

namespace App\Queries\Budget;

use App\Models\Transaction;

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
