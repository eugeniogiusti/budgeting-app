<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoalRequest;
use App\Models\Category;
use App\Queries\Goals\GoalsProgressQuery;
use App\Services\GoalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GoalController extends Controller
{
    public function __construct(private GoalService $goalService) {}

    public function index(): View
    {
        return $this->mobileView('goals.index', [
            'goals' => (new GoalsProgressQuery)->handle(),
        ]);
    }

    public function create(): View
    {
        return $this->mobileView('goals.create');
    }

    public function store(StoreGoalRequest $request): RedirectResponse
    {
        $this->goalService->create($request->validated());

        session()->flash('success', __('ui.toast_saved'));

        return redirect()->route('goals.index');
    }

    public function edit(Category $goal): View
    {
        return $this->mobileView('goals.edit', ['goal' => $goal]);
    }

    public function update(StoreGoalRequest $request, Category $goal): RedirectResponse
    {
        $this->goalService->update($goal, $request->validated());

        session()->flash('success', __('ui.toast_saved'));

        return redirect()->route('goals.index');
    }

    public function destroy(Category $goal): RedirectResponse
    {
        $this->goalService->delete($goal);

        session()->flash('success', __('ui.toast_deleted'));

        return redirect()->route('goals.index');
    }
}
