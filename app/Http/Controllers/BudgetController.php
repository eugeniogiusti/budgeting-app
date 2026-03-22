<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesMonth;
use App\Http\Requests\StoreBudgetRequest;
use App\Models\Category;
use App\Queries\Budget\CategoriesWithMonthDataQuery;
use App\Queries\Budget\CategoryMonthDetailQuery;
use App\Queries\Budget\ReadyToAssignQuery;
use App\Services\BudgetService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BudgetController extends Controller
{
    use ResolvesMonth;

    public function __construct(private BudgetService $budgetService) {}

    public function index(): View
    {
        $date = $this->getSelectedMonth();

        return view('budget.index', [
            'categories'     => (new CategoriesWithMonthDataQuery($date->year, $date->month))->handle(),
            'readyToAssign'  => (new ReadyToAssignQuery)->handle(),
            'monthName'      => $date->translatedFormat('F Y'),
            'year'           => $date->year,
            'month'          => $date->month,
            'prevUrl'        => route('budget.index', $this->monthParams($date, -1)),
            'nextUrl'        => route('budget.index', $this->monthParams($date, +1)),
            'isCurrentMonth' => $date->isSameMonth(Carbon::now()),
        ]);
    }

    public function edit(Category $category): View
    {
        $date   = $this->getSelectedMonth();
        $detail = (new CategoryMonthDetailQuery($category, $date->year, $date->month))->handle();

        return view('budget.edit', [
            'category'      => $category,
            'assigned'      => $detail['assigned'],
            'spent'         => $detail['spent'],
            'readyToAssign' => (new ReadyToAssignQuery)->handle(),
            'year'          => $date->year,
            'month'         => $date->month,
        ]);
    }

    public function update(StoreBudgetRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $this->budgetService->assignBudget(
            $category->id,
            $data['year'],
            $data['month'],
            $data['amount']
        );

        session()->flash('success', __('ui.toast_saved'));

        return redirect()->route('budget.index', ['year' => $data['year'], 'month' => $data['month']]);
    }

}
