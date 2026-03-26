<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesMonth;
use App\Services\BudgetService;
use Illuminate\Http\RedirectResponse;

class BudgetCopyController extends Controller
{
    use ResolvesMonth;

    public function __construct(private BudgetService $budgetService) {}

    // Copy budget assignments from the previous month into the selected month.
    public function store(): RedirectResponse
    {
        $date = $this->getSelectedMonth();

        $this->budgetService->copyBudgetFromPreviousMonth($date->year, $date->month);

        session()->flash('success', __('ui.toast_copied'));

        return redirect()->route('budget.index', ['year' => $date->year, 'month' => $date->month]);
    }
}
