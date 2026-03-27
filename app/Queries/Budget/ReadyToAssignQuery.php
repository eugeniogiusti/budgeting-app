<?php

namespace App\Queries\Budget;

use App\Models\Budget;
use App\Models\Transaction;

// Returns how much money is still unassigned to any budget category.
// Formula: total income (all time) - total assigned across all budgets.
// Used on the budget page to show how much the user can still allocate.
class ReadyToAssignQuery
{
    public function handle(): float
    {
        $totalIncome   = (float) Transaction::where('type', 'income')->sum('amount');
        $totalAssigned = (float) Budget::sum('amount');

        return $totalIncome - $totalAssigned;
    }
}
