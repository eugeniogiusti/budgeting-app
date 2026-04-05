<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['type', 'amount', 'category_id', 'date', 'note', 'receipt_path'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'date',
        ];
    }

    // The category this transaction is assigned to (null for income).
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
