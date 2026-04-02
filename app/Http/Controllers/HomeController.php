<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesMonth;
use App\Queries\Budget\CategoriesWithMonthDataQuery;
use App\Queries\Budget\MonthlySummaryQuery;
use App\Queries\Budget\ReadyToAssignQuery;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    use ResolvesMonth;

    // Render the home dashboard with income, expenses, budget categories and navigation for the selected month.
    public function index(): View
    {
        $date    = $this->getSelectedMonth();
        $summary = (new MonthlySummaryQuery($date->year, $date->month))->handle();

        return $this->mobileView('home', [
            'readyToAssign'  => (new ReadyToAssignQuery)->handle(),
            'categories'     => (new CategoriesWithMonthDataQuery($date->year, $date->month))->handle(),
            'monthIncome'    => $summary['income'],
            'monthExpenses'  => $summary['expenses'],
            'balance'        => $summary['income'] - $summary['expenses'],
            'monthName'      => $date->translatedFormat('F Y'),
            'year'           => $date->year,
            'month'          => $date->month,
            'prevUrl'        => route('home', $this->monthParams($date, -1)),
            'nextUrl'        => route('home', $this->monthParams($date, +1)),
            'isCurrentMonth' => $date->isSameMonth(Carbon::now()),
        ]);
    }
}
