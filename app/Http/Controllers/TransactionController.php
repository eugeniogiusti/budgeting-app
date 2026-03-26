<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesMonth;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Queries\Transactions\BudgetExceededQuery;
use App\Queries\Transactions\MonthlyTransactionsQuery;
use App\Services\BudgetService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    use ResolvesMonth;

    public function __construct(private BudgetService $budgetService) {}

    // List transactions for the selected month, optionally filtered by type and/or category.
    public function index(): View
    {
        $date       = $this->getSelectedMonth();
        $type       = request()->string('type', '')->value() ?: null;
        $categoryId = request()->integer('category_id') ?: null;

        $filterParams = array_filter([
            'type'        => $type,
            'category_id' => $categoryId,
        ]);

        return $this->mobileView('transactions.index', [
            'transactions'     => (new MonthlyTransactionsQuery($date->year, $date->month, $type, $categoryId))->handle(),
            'categories'       => Category::where('is_goal', false)->orderBy('sort_order')->get(),
            'activeType'       => $type,
            'activeCategoryId' => $categoryId,
            'monthName'        => $date->translatedFormat('F Y'),
            'year'             => $date->year,
            'month'            => $date->month,
            'prevUrl'          => route('transactions.index', array_merge($this->monthParams($date, -1), $filterParams)),
            'nextUrl'          => route('transactions.index', array_merge($this->monthParams($date, +1), $filterParams)),
            'isCurrentMonth'   => $date->isSameMonth(Carbon::now()),
        ]);
    }

    // Show the form to record a new expense transaction.
    public function create(): View
    {
        return $this->mobileView('transactions.create', [
            'categories' => Category::where('is_goal', false)->orderBy('sort_order')->get(),
            'today'      => Carbon::today()->format('Y-m-d'),
        ]);
    }

    // Persist a new expense; flashes a budget-exceeded warning if the category limit is breached.
    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $transaction = $this->budgetService->storeExpense($request->validated());

        $exceeded = (new BudgetExceededQuery($transaction))->handle();
        if ($exceeded) {
            session()->flash('budget_exceeded', $exceeded);
        }

        return redirect()->route('home');
    }

    // Show the edit form for an existing transaction (expense or income).
    public function edit(Transaction $transaction): View
    {
        return $this->mobileView('transactions.edit', [
            'transaction' => $transaction,
            'categories'  => Category::where('is_goal', false)->orderBy('sort_order')->get(),
        ]);
    }

    // Update a transaction; category_id is only applied for expenses, not for income.
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $rules = [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note'   => ['nullable', 'string', 'max:255'],
            'date'   => ['required', 'date'],
        ];

        if ($transaction->type === 'expense') {
            $rules['category_id'] = ['required', 'exists:categories,id'];
        } else {
            $rules['category_id'] = ['nullable'];
        }

        $validated = $request->validate($rules);

        if ($transaction->type === 'income') {
            unset($validated['category_id']);
        }

        $transaction->update($validated);

        session()->flash('success', __('ui.toast_saved'));

        $date = Carbon::parse($validated['date']);

        return redirect()->route('transactions.index', ['year' => $date->year, 'month' => $date->month]);
    }

    // Delete a transaction and redirect back to the same month view.
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $year  = request()->integer('year',  Carbon::now()->year);
        $month = request()->integer('month', Carbon::now()->month);

        $transaction->delete();

        session()->flash('success', __('ui.toast_deleted'));

        return redirect()->route('transactions.index', ['year' => $year, 'month' => $month]);
    }

}
