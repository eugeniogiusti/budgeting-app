<?php

namespace App\Queries\Budget;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CategoriesWithMonthDataQuery
{
    public function __construct(
        private int $year,
        private int $month,
    ) {}

    public function handle(): Collection
    {
        return Category::where('is_goal', false)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($category) {
                $assigned = (float) ($category->budgets()
                    ->where('year', $this->year)
                    ->where('month', $this->month)
                    ->value('amount') ?? 0);

                $spent = (float) $category->transactions()
                    ->where('type', 'expense')
                    ->whereYear('date', $this->year)
                    ->whereMonth('date', $this->month)
                    ->sum('amount');

                $prevAssigned = (float) $category->budgets()
                    ->where(function ($q) {
                        $q->where('year', '<', $this->year)
                          ->orWhere(function ($q2) {
                              $q2->where('year', $this->year)->where('month', '<', $this->month);
                          });
                    })
                    ->sum('amount');

                $prevSpent = (float) $category->transactions()
                    ->where('type', 'expense')
                    ->where('date', '<', Carbon::createFromDate($this->year, $this->month, 1)->format('Y-m-d'))
                    ->sum('amount');

                $rollover = $prevAssigned - $prevSpent;

                $category->assigned  = $assigned;
                $category->spent     = $spent;
                $category->rollover  = $rollover;
                $category->available = $assigned + $rollover - $spent;

                return $category;
            });
    }
}
