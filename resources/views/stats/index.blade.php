@extends('layouts.app')

@section('content')

<div class="max-w-5xl">

{{-- Header --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ __('nav.nav_stats') }}</h1>
        <div class="flex items-center gap-2 mt-1">
            <a href="{{ $prevUrl }}" class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 capitalize">{{ $monthName }}</span>
            @if(!$isCurrentMonth)
                <a href="{{ $nextUrl }}" class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="w-7 h-7"></span>
            @endif
        </div>
    </div>
</div>

@if(count($spendingByCategory) > 0)

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">

        {{-- Donut: spese per categoria --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('stats.stats_by_category') }}</h3>
            </div>
            <div class="p-6">
                <div id="donutChart"
                     data-spending='@json($spendingByCategory)'
                     data-currency="{{ $currency }}"
                     data-height="280"
                     data-colors='@json($chartColors)'
                ></div>
            </div>
        </div>

        {{-- Breakdown lista --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('stats.stats_breakdown') }}</h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach($spendingByCategory as $item)
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $item['emoji'] }} {{ $item['name'] }}</span>
                            <span class="text-sm font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($item['amount'], 2, ',', '.') }} {{ $currency }}
                                <span class="text-xs text-gray-400 font-normal ml-1">{{ $item['pct'] }}%</span>
                            </span>
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-1.5 rounded-full bg-brand-500" style="width: {{ $item['pct'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@else
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] py-16 text-center mb-6">
        <div class="text-5xl mb-3">📊</div>
        <div class="font-bold text-gray-800 dark:text-white/90">{{ __('stats.no_stats') }}</div>
        <div class="text-gray-400 dark:text-gray-500 text-sm mt-1">{{ __('stats.no_stats_subtitle') }}</div>
    </div>
@endif

{{-- Trend 6 mesi --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('stats.stats_trend') }}</h3>
    </div>
    <div class="p-6">
        <div id="trendChart"
             data-trend='@json($monthlyTrend)'
             data-currency="{{ $currency }}"
             data-height="280"
             data-income-label="{{ __('home.income') }}"
             data-expenses-label="{{ __('home.expenses') }}"
        ></div>
    </div>
</div>

</div>{{-- /max-w-5xl --}}

@endsection
