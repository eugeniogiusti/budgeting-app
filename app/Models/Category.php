<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name', 'emoji', 'color', 'budget_amount',
        'is_goal', 'target_amount', 'target_date', 'sort_order',
        'translation_key',
    ];

    /**
     * Return the translated name for default categories,
     * or the stored name for user-created ones.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->translation_key
                ? __('categories.' . $this->translation_key)
                : $value,
        );
    }

    protected function casts(): array
    {
        return [
            'budget_amount' => 'decimal:2',
            'target_amount' => 'decimal:2',
            'target_date' => 'date',
            'is_goal' => 'boolean',
        ];
    }

    // All transactions that belong to this category.
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // All monthly budget allocations for this category.
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }
}
