<?php

namespace App\Queries\Goals;

use App\Models\Category;
use Illuminate\Support\Collection;

class GoalsProgressQuery
{
    public function handle(): Collection
    {
        return Category::where('is_goal', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($goal) {
                $saved              = (float) $goal->budgets()->sum('amount');
                $goal->saved        = $saved;
                $goal->progress_pct = $goal->target_amount > 0
                    ? min(100, round(($saved / $goal->target_amount) * 100))
                    : 0;

                return $goal;
            });
    }
}
