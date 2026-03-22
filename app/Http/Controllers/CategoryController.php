<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Queries\Categories\CategoriesListQuery;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index(): View
    {
        return view('categories.index', [
            'categories' => (new CategoriesListQuery)->handle(),
        ]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data               = $request->validated();
        $data['sort_order'] = Category::where('is_goal', false)->max('sort_order') + 1;
        $data['is_goal']    = false;

        Category::create($data);

        session()->flash('success', __('ui.toast_saved'));

        return redirect()->route('categories.index');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update(array_merge($request->validated(), ['translation_key' => null]));

        session()->flash('success', __('ui.toast_saved'));

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $deleted = $this->categoryService->delete($category);

        if (! $deleted) {
            return redirect()->route('categories.index')
                ->with('error', __('ui.category_has_data'));
        }

        session()->flash('success', __('ui.toast_deleted'));

        return redirect()->route('categories.index')
            ->with('success', __('ui.toast_deleted'));
    }
}
