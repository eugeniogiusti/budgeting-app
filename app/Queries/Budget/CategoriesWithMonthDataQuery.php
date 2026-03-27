<?php

namespace App\Queries\Budget;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Collection;

// Returns all non-goal categories enriched with budget data for the given month.
// Each category gets four computed properties:
//   - assigned:  budget amount set for this month
//   - spent:     total expenses in this month
//   - rollover:  leftover from all previous months (prev assigned - prev spent), can be negative
//   - available: assigned + rollover - spent (what remains to spend)
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
