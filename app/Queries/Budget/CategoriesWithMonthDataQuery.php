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

                $available   = $assigned + $rollover - $spent;
                $totalBudget = $assigned + $rollover;
                $pct         = $totalBudget > 0 ? min(100, round($spent / $totalBudget * 100)) : 0;

                $category->assigned         = $assigned;
                $category->spent            = $spent;
                $category->rollover         = $rollover;
                $category->available        = $available;
                $category->total_budget     = $totalBudget;
                $category->pct              = $pct;
                // bar_color variants for desktop (500) and mobile (400/amber/lime) Tailwind classes
                $category->bar_color        = $available < 0 ? 'bg-red-500' : ($pct >= 80 ? 'bg-yellow-500' : 'bg-green-500');
                $category->bar_color_mobile = $available < 0 ? 'bg-red-400' : ($pct >= 80 ? 'bg-amber-400' : 'bg-lime-400');

                return $category;
            });
    }
}
