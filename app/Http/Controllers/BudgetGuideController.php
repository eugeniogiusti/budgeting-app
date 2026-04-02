<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesMonth;
use App\Queries\Budget\CategoriesWithMonthDataQuery;
use App\Queries\Budget\MonthlySummaryQuery;
use Carbon\Carbon;
use Illuminate\View\View;

// Shows the 50/30/20 budget guide with suggested amounts based on the current month's income.
class BudgetGuideController extends Controller
{
    use ResolvesMonth;

    public function __invoke(): View
    {
        $date    = $this->getSelectedMonth();
        $summary = (new MonthlySummaryQuery($date->year, $date->month))->handle();
        $income  = $summary['income'];

        $categories = (new CategoriesWithMonthDataQuery($date->year, $date->month))->handle();
        $totalAssigned = $categories->sum('assigned');

        return $this->mobileView('budget.guide', [
            'income'        => $income,
            'needs'         => round($income * 0.50, 2),
            'wants'         => round($income * 0.30, 2),
            'savings'       => round($income * 0.20, 2),
            'totalAssigned' => $totalAssigned,
            'year'          => $date->year,
            'month'         => $date->month,
            'monthName'     => $date->translatedFormat('F Y'),
        ]);
    }
}
