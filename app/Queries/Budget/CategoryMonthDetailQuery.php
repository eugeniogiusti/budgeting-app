<?php

namespace App\Queries\Budget;

use App\Models\Category;

class CategoryMonthDetailQuery
{
    public function __construct(
        private Category $category,
        private int $year,
        private int $month,
    ) {}

    public function handle(): array
    {
        $assigned = (float) ($this->category->budgets()
            ->where('year', $this->year)
            ->where('month', $this->month)
            ->value('amount') ?? 0);

        $spent = (float) $this->category->transactions()
            ->where('type', 'expense')
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->sum('amount');

        return [
            'assigned' => $assigned,
            'spent'    => $spent,
        ];
    }
}
