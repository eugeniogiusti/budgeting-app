@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-4 pb-4">
        <h1 class="text-2xl font-bold">{{ __('nav.nav_budget') }}</h1>
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

    {{-- Ready to Assign banner --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 mb-5 flex items-center justify-between">
        <span class="text-sm text-white/70 font-medium">{{ __('home.ready_to_assign') }}</span>
        <span class="text-xl font-extrabold {{ $readyToAssign < 0 ? 'text-red-300' : 'text-lime-300' }}">
            {{ number_format($readyToAssign, 2, ',', '.') }} {{ $currency }}
        </span>
    </div>

    {{-- Actions row --}}
    <div class="flex items-center justify-between mb-3">
        <form action="{{ route('budget.copy', ['year' => $year, 'month' => $month]) }}" method="POST">
            @csrf
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="month" value="{{ $month }}">
            <button type="submit" class="flex items-center gap-1.5 text-white/60 text-xs font-medium hover:text-white/90 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                {{ __('budget.copy_previous_month') }}
            </button>
        </form>
        <a href="{{ route('categories.index') }}" class="flex items-center gap-1.5 text-white/60 text-xs font-medium hover:text-white/90 transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/>
            </svg>
            {{ __('categories.manage_categories') }}
        </a>
    </div>

    {{-- Category list --}}
    <div class="space-y-2 mb-6">
        @foreach($categories as $category)
            <a href="{{ route('budget.edit', ['category' => $category, 'year' => $year, 'month' => $month]) }}"
               class="bg-white rounded-2xl p-4 block active:scale-[0.98] transition-transform">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $category->emoji }}</span>
                        <div>
                            <div class="text-gray-800 font-semibold text-sm">{{ $category->name }}</div>
                            <div class="text-gray-400 text-xs">
                                @if($category->spent > 0)
                                    {{ __('budget.spent') }}: {{ number_format($category->spent, 2, ',', '.') }} {{ $currency }}
                                @else
                                    {{ __('budget.no_expenses') }}
                                @endif
                                @if($category->rollover != 0)
                                    &middot;
                                    <span class="{{ $category->rollover > 0 ? 'text-lime-500' : 'text-red-400' }}">
                                        {{ $category->rollover > 0 ? '+' : '' }}{{ number_format($category->rollover, 2, ',', '.') }} {{ __('budget.rollover') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-sm {{ $category->available < 0 ? 'text-red-500' : ($category->total_budget > 0 ? 'text-lime-600' : 'text-gray-300') }}">
                            {{ number_format($category->available, 2, ',', '.') }} {{ $currency }}
                        </div>
                        <div class="text-[10px] text-gray-400">
                            @if($category->assigned > 0)
                                {{ __('budget.of') }} {{ number_format($category->assigned, 2, ',', '.') }} {{ $currency }}
                            @else
                                {{ __('home.not_assigned') }}
                            @endif
                        </div>
                    </div>
                </div>
                @if($category->total_budget > 0)
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="{{ $category->bar_color_mobile }} h-1.5 rounded-full transition-all duration-300" style="width: {{ $category->pct }}%"></div>
                    </div>
                @endif
            </a>
        @endforeach
    </div>

</div>
@endsection
