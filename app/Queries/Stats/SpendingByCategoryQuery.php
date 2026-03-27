<?php

namespace App\Queries\Stats;

use App\Models\Category;

// Returns spending breakdown by category for a given month, sorted by highest spend.
// Categories with zero spending are excluded.
// Each entry includes name, emoji, amount and pct (percentage of total monthly spending).
class SpendingByCategoryQuery
{
    public function __construct(
        private int $year,
        private int $month,
    ) {}

    public function handle(): array
    {
        $categories = Category::where('is_goal', false)
            ->with(['transactions' => function ($q) {
                $q->where('type', 'expense')
                  ->whereYear('date', $this->year)
                  ->whereMonth('date', $this->month);
            }])
            ->get()
            ->map(fn($cat) => [
                'name'   => $cat->name,
                'emoji'  => $cat->emoji,
                'amount' => (float) $cat->transactions->sum('amount'),
            ])
            ->filter(fn($c) => $c['amount'] > 0)
            ->sortByDesc('amount')
            ->values()
            ->toArray();

        $total = array_sum(array_column($categories, 'amount'));

        return array_map(function ($c) use ($total) {
            $c['pct'] = $total > 0 ? round(($c['amount'] / $total) * 100) : 0;
            return $c;
        }, $categories);
    }
}
