<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Deletes a category if it has no transactions and no budgets with real money assigned.
     * Returns true on success, false if blocked.
     */
    public function delete(Category $category): bool
    {
        if ($category->transactions()->exists()) {
            return false;
        }

        $category->budgets()->where('amount', '<=', 0)->delete();

        if ($category->budgets()->exists()) {
            return false;
        }

        $category->delete();

        return true;
    }
}
