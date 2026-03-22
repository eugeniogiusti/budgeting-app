<?php

namespace App\Queries\Budget;

use App\Models\Budget;
use App\Models\Transaction;

class ReadyToAssignQuery
{
    public function handle(): float
    {
        $totalIncome   = (float) Transaction::where('type', 'income')->sum('amount');
        $totalAssigned = (float) Budget::sum('amount');

        return $totalIncome - $totalAssigned;
    }
}
