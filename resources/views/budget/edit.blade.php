@extends('layouts.app')

@section('content')

<div class="mb-6">
    <x-common.page-breadcrumb :pageTitle="$category->emoji . ' ' . $category->name" />
</div>

<div class="max-w-2xl">

    {{-- To assign --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] px-6 py-4 flex items-center justify-between">
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('home.ready_to_assign') }}</span>
        <span class="text-2xl font-extrabold {{ $readyToAssign < 0 ? 'text-red-500' : 'text-green-500' }}">
            {{ number_format($readyToAssign, 2, ',', '.') }} {{ $currency }}
        </span>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 text-center">
            <div class="text-2xl font-bold text-red-500">{{ number_format($spent, 2, ',', '.') }} {{ $currency }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('budget.spent') }}</div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 text-center">
            <div class="text-2xl font-bold {{ $available < 0 ? 'text-red-500' : 'text-green-500' }}">
                {{ number_format($available, 2, ',', '.') }} {{ $currency }}
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('home.available') }}</div>
        </div>
    </div>

    {{-- Form --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('budget.assign_amount') }}</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('budget.update', $category) }}" method="POST">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('transactions.amount') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">{{ $currency }}</span>
                        <input type="number" name="amount" step="0.01" min="0"
                               value="{{ number_format($assigned, 2, '.', '') }}"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 text-lg font-semibold">
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('budget.index', ['year' => $year, 'month' => $month]) }}"
                       class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        {{ __('transactions.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
                        {{ __('budget.save_budget') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
