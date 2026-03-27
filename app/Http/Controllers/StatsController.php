<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesMonth;
use App\Queries\Stats\MonthlyTrendQuery;
use App\Queries\Stats\SpendingByCategoryQuery;
use Carbon\Carbon;
use Illuminate\View\View;

class StatsController extends Controller
{
    use ResolvesMonth;

    // Display spending statistics for the selected month: per-category breakdown and a 6-month trend chart.
    public function index(): View
    {
        $date = $this->getSelectedMonth();

        return $this->mobileView('stats.index', [
            'monthName'          => $date->translatedFormat('F Y'),
            'spendingByCategory' => (new SpendingByCategoryQuery($date->year, $date->month))->handle(),
            'monthlyTrend'       => (new MonthlyTrendQuery(6))->handle(),
            'chartColors'        => config('budget.chart_colors'),
            'prevUrl'            => route('stats.index', $this->monthParams($date, -1)),
            'nextUrl'            => route('stats.index', $this->monthParams($date, +1)),
            'isCurrentMonth'     => $date->isSameMonth(Carbon::now()),
        ]);
    }

}
