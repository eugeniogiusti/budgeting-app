<?php

namespace App\Queries\Transactions;

use App\Models\Transaction;
use Carbon\Carbon;

// Checks whether the given transaction pushed its category over the monthly budget limit.
// Returns null if: the transaction has no category, no budget was set, or the limit was not exceeded.
// Returns an array with category name, emoji and the over-budget amount (formatted) if exceeded.
// Called after storing a new expense to flash a warning to the user.
class BudgetExceededQuery
{
    public function __construct(private Transaction $transaction) {}

    public function handle(): ?array
    {
        if (! $this->transaction->category_id) {
            return null;
        }

        $date     = Carbon::parse($this->transaction->date);
        $category = $this->transaction->category;

        $assigned = (float) ($category->budgets()
            ->where('year', $date->year)
            ->where('month', $date->month)
            ->value('amount') ?? 0);

        if ($assigned <= 0) {
            return null;
        }

        $spent = (float) $category->transactions()
            ->where('type', 'expense')
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->sum('amount');

        if ($spent <= $assigned) {
            return null;
        }

        return [
            'name'  => $category->name,
            'emoji' => $category->emoji,
            'over'  => number_format($spent - $assigned, 2, ',', '.'),
        ];
    }
}
