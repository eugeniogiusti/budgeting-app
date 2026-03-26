<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Services\BudgetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IncomeController extends Controller
{
    public function __construct(private BudgetService $budgetService) {}

    // Show the form to record a new income entry.
    public function create(): View
    {
        return $this->mobileView('income.create');
    }

    // Persist a new income transaction and redirect to home.
    public function store(StoreIncomeRequest $request): RedirectResponse
    {
        $this->budgetService->storeIncome($request->validated());

        return redirect()->route('home');
    }
}
