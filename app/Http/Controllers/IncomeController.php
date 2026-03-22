<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Services\BudgetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IncomeController extends Controller
{
    public function __construct(private BudgetService $budgetService) {}

    public function create(): View
    {
        return $this->mobileView('income.create');
    }

    public function store(StoreIncomeRequest $request): RedirectResponse
    {
        $this->budgetService->storeIncome($request->validated());

        return redirect()->route('home');
    }
}
