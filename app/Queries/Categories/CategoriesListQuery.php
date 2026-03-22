<?php

namespace App\Queries\Categories;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoriesListQuery
{
    public function handle(): Collection
    {
        return Category::where('is_goal', false)
            ->orderBy('sort_order')
            ->get();
    }
}
