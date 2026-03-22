<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Transaction;
use Carbon\Carbon;

class BudgetService
{
    public function storeExpense(array $data): Transaction
    {
        return Transaction::create([
            'type'        => 'expense',
            'amount'      => $data['amount'],
            'category_id' => $data['category_id'],
            'date'        => $data['date'],
            'note'        => $data['note'] ?? null,
        ]);
    }

    public function storeIncome(array $data): Transaction
    {
        return Transaction::create([
            'type'   => 'income',
            'amount' => $data['amount'],
            'date'   => $data['date'],
            'note'   => $data['note'] ?? null,
        ]);
    }

    public function assignBudget(int $categoryId, int $year, int $month, float $amount): void
    {
        Budget::updateOrCreate(
            ['category_id' => $categoryId, 'year' => $year, 'month' => $month],
            ['amount' => $amount]
        );
    }

    public function copyBudgetFromPreviousMonth(int $year, int $month): int
    {
        $prev = Carbon::createFromDate($year, $month, 1)->subMonth();

        $prevBudgets = Budget::where('year', $prev->year)
            ->where('month', $prev->month)
            ->where('amount', '>', 0)
            ->get();

        $copied = 0;
        foreach ($prevBudgets as $budget) {
            $created = Budget::firstOrCreate(
                ['category_id' => $budget->category_id, 'year' => $year, 'month' => $month],
                ['amount' => $budget->amount]
            );
            if ($created->wasRecentlyCreated) {
                $copied++;
            }
        }

        return $copied;
    }
}
