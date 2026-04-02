@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4 pb-8">

    {{-- Header --}}
    <div class="pt-4 pb-6 flex items-center gap-4">
        <a href="{{ route('budget.index', ['year' => $year, 'month' => $month]) }}"
           class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold">{{ __('budget.guide_title') }}</h1>
            <p class="text-white/70 text-sm capitalize">{{ $monthName }}</p>
        </div>
    </div>

    {{-- Income --}}
    <div class="bg-white rounded-3xl p-5 mb-4 flex items-center justify-between">
        <span class="text-sm text-gray-500 font-medium">{{ __('home.income') }}</span>
        @if($income > 0)
            <span class="text-xl font-extrabold text-green-500">{{ number_format($income, 2, ',', '.') }} {{ $currency }}</span>
        @else
            <span class="text-sm text-gray-400">{{ __('budget.guide_no_income') }}</span>
        @endif
    </div>

    {{-- Rule cards --}}
    <div class="space-y-3 mb-4">

        {{-- 50% --}}
        <div class="bg-white rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🏠</span>
                    <div>
                        <div class="font-bold text-gray-800">{{ __('budget.guide_needs') }} <span class="text-blue-500">50%</span></div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ __('budget.guide_needs_desc') }}</div>
                    </div>
                </div>
                @if($income > 0)
                    <div class="text-lg font-extrabold text-blue-500">{{ number_format($needs, 0, ',', '.') }} {{ $currency }}</div>
                @endif
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-400 rounded-full" style="width: 50%"></div>
            </div>
        </div>

        {{-- 30% --}}
        <div class="bg-white rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎉</span>
                    <div>
                        <div class="font-bold text-gray-800">{{ __('budget.guide_wants') }} <span class="text-purple-500">30%</span></div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ __('budget.guide_wants_desc') }}</div>
                    </div>
                </div>
                @if($income > 0)
                    <div class="text-lg font-extrabold text-purple-500">{{ number_format($wants, 0, ',', '.') }} {{ $currency }}</div>
                @endif
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-purple-400 rounded-full" style="width: 30%"></div>
            </div>
        </div>

        {{-- 20% --}}
        <div class="bg-white rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">💰</span>
                    <div>
                        <div class="font-bold text-gray-800">{{ __('budget.guide_savings') }} <span class="text-green-500">20%</span></div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ __('budget.guide_savings_desc') }}</div>
                    </div>
                </div>
                @if($income > 0)
                    <div class="text-lg font-extrabold text-green-500">{{ number_format($savings, 0, ',', '.') }} {{ $currency }}</div>
                @endif
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-400 rounded-full" style="width: 20%"></div>
            </div>
        </div>

    </div>

    {{-- Assigned progress --}}
    @if($income > 0)
    <div class="bg-white rounded-3xl p-5 mb-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-500 font-medium">{{ __('budget.guide_assigned_so_far') }}</span>
            <span class="text-sm font-bold {{ $totalAssigned > $income ? 'text-red-500' : 'text-gray-800' }}">
                {{ number_format($totalAssigned, 0, ',', '.') }} / {{ number_format($income, 0, ',', '.') }} {{ $currency }}
            </span>
        </div>
        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full {{ $totalAssigned > $income ? 'bg-red-400' : 'bg-[#667eea]' }}"
                 style="width: {{ min(100, round($totalAssigned / $income * 100)) }}%"></div>
        </div>
        <p class="text-xs text-gray-400 mt-2">
            {{ __('budget.guide_unassigned') }}: <span class="font-semibold">{{ number_format(max(0, $income - $totalAssigned), 2, ',', '.') }} {{ $currency }}</span>
        </p>
    </div>
    @endif

    {{-- Tip --}}
    <div class="bg-[#667eea]/10 rounded-3xl p-5">
        <p class="text-sm text-[#667eea] font-medium">
            💡 {{ __('budget.guide_tip') }}
        </p>
    </div>

</div>
@endsection
