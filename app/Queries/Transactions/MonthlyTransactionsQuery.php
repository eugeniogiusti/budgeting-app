<?php

namespace App\Queries\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Collection;

// Returns all transactions for a given month, optionally filtered by type ('income'/'expense')
// and/or category. Results are sorted newest first (date DESC, id DESC).
// Used on the transactions index page with the active filter params.
class MonthlyTransactionsQuery
{
    public function __construct(
        private int $year,
        private int $month,
        private ?string $type = null,
        private ?int $categoryId = null,
    ) {}

    public function handle(): Collection
    {
        $query = Transaction::with('category')
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month);

        if ($this->type !== null) {
            $query->where('type', $this->type);
        }

        if ($this->categoryId !== null) {
            $query->where('category_id', $this->categoryId);
        }

        return $query->orderByDesc('date')->orderByDesc('id')->get();
    }
}
