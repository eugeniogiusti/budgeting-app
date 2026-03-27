<?php

namespace App\Services;

use App\Models\Category;

// Handles CRUD for goals. Goals are stored as Category records with is_goal=true.
// Savings toward a goal are stored as Budget entries linked to the goal category.
class GoalService
{
    // Creates a new goal category. sort_order is appended after the current max.
    // color defaults to config('budget.default_goal_color') if not provided.
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

    // Updates editable goal fields. color and sort_order are intentionally not updatable here.
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
