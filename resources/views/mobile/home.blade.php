@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-12 pb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ __('ui.home') }}</h1>
            <a href="{{ route('settings.index') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/>
                </svg>
            </a>
        </div>
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

    {{-- Ready to Assign Card --}}
    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 mb-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-white/70 text-sm font-medium">{{ __('ui.ready_to_assign') }}</span>
            @if($readyToAssign > 0)
                <span class="px-3 py-1 bg-lime-400/20 text-lime-300 text-xs font-bold rounded-full">{{ __('ui.available') }}</span>
            @elseif($readyToAssign < 0)
                <span class="px-3 py-1 bg-red-400/20 text-red-300 text-xs font-bold rounded-full">{{ __('ui.overspent') }}</span>
            @else
                <span class="px-3 py-1 bg-white/10 text-white/50 text-xs font-bold rounded-full">{{ __('ui.assigned') }}</span>
            @endif
        </div>
        <div class="text-4xl font-extrabold tracking-tight {{ $readyToAssign < 0 ? 'text-red-300' : 'text-white' }}">
            {{ number_format($readyToAssign, 2, ',', '.') }} {{ $currency }}
        </div>
        <div class="mt-4 flex gap-3">
            <a href="{{ route('budget.index', ['year' => $year, 'month' => $month]) }}"
               class="flex-1 bg-white/20 hover:bg-white/30 text-white text-center py-2.5 rounded-xl text-sm font-semibold transition">
                {{ __('ui.assign') }}
            </a>
            <a href="{{ route('income.create') }}"
               class="flex-1 bg-white text-[#667eea] text-center py-2.5 rounded-xl text-sm font-bold transition hover:bg-white/90">
                {{ __('ui.add_income') }}
            </a>
        </div>
    </div>

    {{-- Monthly Summary --}}
    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-5 mb-4">
        <h2 class="text-sm font-semibold text-white/70 mb-3">{{ __('ui.this_month') }}</h2>
        <div class="grid grid-cols-3 gap-3 text-center">
            <div>
                <div class="text-lg font-bold text-lime-300">{{ number_format($monthIncome, 2, ',', '.') }} {{ $currency }}</div>
                <div class="text-[10px] text-white/50 font-medium mt-0.5">{{ __('ui.income') }}</div>
            </div>
            <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month]) }}" class="block">
                <div class="text-lg font-bold text-red-300">{{ number_format($monthExpenses, 2, ',', '.') }} {{ $currency }}</div>
                <div class="text-[10px] text-white/50 font-medium mt-0.5">{{ __('ui.expenses') }} →</div>
            </a>
            <div>
                <div class="text-lg font-bold">{{ number_format($monthIncome - $monthExpenses, 2, ',', '.') }} {{ $currency }}</div>
                <div class="text-[10px] text-white/50 font-medium mt-0.5">{{ __('ui.balance') }}</div>
            </div>
        </div>
    </div>

    {{-- Top Priorities --}}
    <div class="mb-6">
        <h2 class="text-sm font-semibold text-white/70 mb-3 px-1">{{ __('ui.top_priorities') }}</h2>
        <div class="space-y-2">
            @foreach($categories->take(5) as $category)
                <div class="bg-white rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $category->emoji }}</span>
                        <div>
                            <div class="text-gray-800 font-semibold text-sm">{{ $category->name }}</div>
                            <div class="text-gray-400 text-xs">
                                @if($category->assigned > 0)
                                    {{ number_format($category->spent, 2, ',', '.') }} / {{ number_format($category->assigned, 2, ',', '.') }} {{ $currency }}
                                @else
                                    {{ __('ui.not_assigned') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $category->available < 0 ? 'bg-red-100 text-red-600' : ($category->available > 0 ? 'bg-lime-100 text-lime-700' : 'bg-gray-100 text-gray-400') }}">
                        {{ number_format($category->available, 2, ',', '.') }} {{ $currency }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
