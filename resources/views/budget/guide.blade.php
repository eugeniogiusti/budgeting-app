
@extends('layouts.app')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <x-common.page-breadcrumb :pageTitle="__('budget.guide_title')" />
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 capitalize">{{ $monthName }}</p>
    </div>
    <a href="{{ route('budget.index', ['year' => $year, 'month' => $month]) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
        {{ __('budget.go_to_budget') }}
    </a>
</div>

<div class="max-w-2xl space-y-6">

    {{-- Income card --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] px-6 py-5">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('home.income') }} {{ $monthName }}</span>
            @if($income > 0)
                <span class="text-2xl font-extrabold text-green-500">
                    {{ number_format($income, 2, ',', '.') }} {{ $currency }}
                </span>
            @else
                <span class="text-sm text-gray-400 dark:text-gray-500">{{ __('budget.guide_no_income') }}</span>
            @endif
        </div>
    </div>

    {{-- Rule explanation --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('budget.guide_rule_title') }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('budget.guide_rule_subtitle') }}</p>
        </div>

        {{-- 50% Needs --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-xl flex-shrink-0">🏠</div>
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white/90">{{ __('budget.guide_needs') }} <span class="text-blue-500 font-bold">50%</span></div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ __('budget.guide_needs_desc') }}</div>
                    </div>
                </div>
                @if($income > 0)
                    <div class="text-right flex-shrink-0">
                        <div class="text-xl font-bold text-blue-500">{{ number_format($needs, 2, ',', '.') }} {{ $currency }}</div>
                    </div>
                @endif
            </div>
            <div class="mt-3 h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full bg-blue-400 rounded-full" style="width: 50%"></div>
            </div>
        </div>

        {{-- 30% Wants --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-xl flex-shrink-0">🎉</div>
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white/90">{{ __('budget.guide_wants') }} <span class="text-purple-500 font-bold">30%</span></div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ __('budget.guide_wants_desc') }}</div>
                    </div>
                </div>
                @if($income > 0)
                    <div class="text-right flex-shrink-0">
                        <div class="text-xl font-bold text-purple-500">{{ number_format($wants, 2, ',', '.') }} {{ $currency }}</div>
                    </div>
                @endif
            </div>
            <div class="mt-3 h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full bg-purple-400 rounded-full" style="width: 30%"></div>
            </div>
        </div>

        {{-- 20% Savings --}}
        <div class="px-6 py-5">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-xl flex-shrink-0">💰</div>
                    <div>
                        <div class="font-semibold text-gray-800 dark:text-white/90">{{ __('budget.guide_savings') }} <span class="text-green-500 font-bold">20%</span></div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ __('budget.guide_savings_desc') }}</div>
                    </div>
                </div>
                @if($income > 0)
                    <div class="text-right flex-shrink-0">
                        <div class="text-xl font-bold text-green-500">{{ number_format($savings, 2, ',', '.') }} {{ $currency }}</div>
                    </div>
                @endif
            </div>
            <div class="mt-3 h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full bg-green-400 rounded-full" style="width: 20%"></div>
            </div>
        </div>
    </div>

    {{-- Assigned so far --}}
    @if($income > 0)
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] px-6 py-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('budget.guide_assigned_so_far') }}</span>
            <span class="font-bold {{ $totalAssigned > $income ? 'text-red-500' : 'text-gray-800 dark:text-white/90' }}">
                {{ number_format($totalAssigned, 2, ',', '.') }} / {{ number_format($income, 2, ',', '.') }} {{ $currency }}
            </span>
        </div>
        <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
            <div class="h-full rounded-full {{ $totalAssigned > $income ? 'bg-red-500' : 'bg-brand-500' }}"
                 style="width: {{ min(100, round($totalAssigned / $income * 100)) }}%"></div>
        </div>
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ __('budget.guide_unassigned') }}: {{ number_format(max(0, $income - $totalAssigned), 2, ',', '.') }} {{ $currency }}</p>
    </div>
    @endif

    {{-- Tip --}}
    <div class="rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 px-6 py-4">
        <p class="text-sm text-amber-700 dark:text-amber-300">
            💡 {{ __('budget.guide_tip') }}
        </p>
    </div>

</div>

@endsection
