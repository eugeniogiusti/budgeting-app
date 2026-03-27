@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-4 pb-6">
        <h1 class="text-2xl font-bold">{{ __('nav.nav_stats') }}</h1>
        <div class="flex items-center gap-2 mt-1">
            <a href="{{ $prevUrl }}" class="w-7 h-7 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="text-white/70 text-sm font-medium">{{ $monthName }}</span>
            @if($isCurrentMonth)
                <span class="w-7 h-7"></span>
            @else
                <a href="{{ $nextUrl }}" class="w-7 h-7 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>
    </div>

    @if(count($spendingByCategory) > 0)

        {{-- Donut chart --}}
        <div class="bg-white rounded-3xl p-6 mb-4">
            <h2 class="text-gray-700 font-bold mb-4">{{ __('stats.stats_by_category') }}</h2>
            <div id="donutChart"
             data-spending='@json($spendingByCategory)'
             data-currency="{{ $currency }}"
             data-height="240"
             data-colors='@json($chartColors)'
        ></div>
        </div>

        {{-- Category breakdown list --}}
        <div class="bg-white rounded-3xl p-5 mb-4">
            <h2 class="text-gray-700 font-bold mb-4">{{ __('stats.stats_breakdown') }}</h2>
            <div class="space-y-3">
                @foreach($spendingByCategory as $item)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm text-gray-700">{{ $item['emoji'] }} {{ $item['name'] }}</span>
                            <span class="text-sm font-bold text-gray-800">{{ number_format($item['amount'], 2, ',', '.') }} {{ $currency }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full bg-gradient-to-r from-[#667eea] to-[#4ecdc4]"
                                 style="width: {{ $item['pct'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @else
        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-10 text-center mb-4">
            <div class="text-5xl mb-3">📊</div>
            <div class="text-white font-bold">{{ __('stats.no_stats') }}</div>
            <div class="text-white/60 text-sm mt-1">{{ __('stats.no_stats_subtitle') }}</div>
        </div>
    @endif

    {{-- Bar chart: trend 6 mesi --}}
    <div class="bg-white rounded-3xl p-6 mb-6">
        <h2 class="text-gray-700 font-bold mb-4">{{ __('stats.stats_trend') }}</h2>
        <div id="trendChart"
             data-trend='@json($monthlyTrend)'
             data-currency="{{ $currency }}"
             data-height="200"
             data-income-label="{{ __('home.income') }}"
             data-expenses-label="{{ __('home.expenses') }}"
        ></div>
    </div>

</div>
@endsection
