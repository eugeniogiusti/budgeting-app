<?php

namespace App\Services;

use App\Models\Category;

class GoalService
{
    public function create(array $data): Category
    {
        return Category::create([
            'name'          => $data['name'],
            'emoji'         => $data['emoji'],
            'color'         => $data['color'] ?? config('budget.default_goal_color'),
            'is_goal'       => true,
            'target_amount' => $data['target_amount'],
            'target_date'   => $data['target_date'] ?? null,
            'sort_order'    => (Category::max('sort_order') ?? 0) + 1,
        ]);
    }

    public function update(Category $goal, array $data): void
    {
        $goal->update([
            'name'          => $data['name'],
            'emoji'         => $data['emoji'],
            'target_amount' => $data['target_amount'],
            'target_date'   => $data['target_date'] ?? null,
        ]);
    }

    public function delete(Category $goal): void
    {
        $goal->delete();
    }
}
