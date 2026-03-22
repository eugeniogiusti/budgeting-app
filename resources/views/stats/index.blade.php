@extends('layouts.app')

@section('content')

<div class="max-w-5xl">

{{-- Header --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ __('ui.nav_stats') }}</h1>
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
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('ui.stats_by_category') }}</h3>
            </div>
            <div class="p-6">
                <div id="donutChart"></div>
            </div>
        </div>

        {{-- Breakdown lista --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('ui.stats_breakdown') }}</h3>
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
        <div class="font-bold text-gray-800 dark:text-white/90">{{ __('ui.no_stats') }}</div>
        <div class="text-gray-400 dark:text-gray-500 text-sm mt-1">{{ __('ui.no_stats_subtitle') }}</div>
    </div>
@endif

{{-- Trend 6 mesi --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('ui.stats_trend') }}</h3>
    </div>
    <div class="p-6">
        <div id="trendChart"></div>
    </div>
</div>

</div>{{-- /max-w-5xl --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const spendingData = @json($spendingByCategory);
    const trendData = @json($monthlyTrend);
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#9ca3af' : '#6b7280';
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

    const colors = ['#465fff','#4ecdc4','#f093fb','#f5a623','#43e97b','#fa709a','#4facfe','#f7971e','#a18cd1','#fda085'];

    // Donut chart
    const donutEl = document.querySelector('#donutChart');
    if (donutEl && spendingData.length > 0) {
        new ApexCharts(donutEl, {
            series: spendingData.map(c => parseFloat(c.amount)),
            labels: spendingData.map(c => c.emoji + ' ' + c.name),
            colors: colors.slice(0, spendingData.length),
            chart: {
                type: 'donut',
                height: 280,
                fontFamily: 'Outfit, sans-serif',
                toolbar: { show: false },
            },
            plotOptions: {
                pie: { donut: { size: '65%' } }
            },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                fontFamily: 'Outfit, sans-serif',
                labels: { colors: textColor },
            },
            tooltip: {
                y: { formatter: val => val.toFixed(2) + ' {{ $currency }}' }
            },
        }).render();
    }

    // Trend bar chart
    const trendEl = document.querySelector('#trendChart');
    if (trendEl) {
        new ApexCharts(trendEl, {
            series: [
                { name: '{{ __("ui.income") }}', data: trendData.map(m => parseFloat(m.income)) },
                { name: '{{ __("ui.expenses") }}', data: trendData.map(m => parseFloat(m.expenses)) },
            ],
            colors: ['#43e97b', '#fa709a'],
            chart: {
                type: 'bar',
                height: 280,
                fontFamily: 'Outfit, sans-serif',
                toolbar: { show: false },
            },
            plotOptions: {
                bar: { horizontal: false, columnWidth: '45%', borderRadius: 4, borderRadiusApplication: 'end' }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: trendData.map(m => m.label),
                labels: { style: { colors: textColor } },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: { style: { colors: textColor } }
            },
            legend: {
                position: 'top',
                fontFamily: 'Outfit, sans-serif',
                labels: { colors: textColor },
            },
            grid: { borderColor: gridColor },
            tooltip: {
                y: { formatter: val => val.toFixed(2) + ' {{ $currency }}' }
            },
        }).render();
    }
});
</script>
@endpush
