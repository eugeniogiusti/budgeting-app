@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ __('nav.nav_budget') }}</h1>
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

    <div class="flex gap-3">
        <form action="{{ route('budget.copy', ['year' => $year, 'month' => $month]) }}" method="POST">
            @csrf
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="month" value="{{ $month }}">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                {{ __('budget.copy_previous_month') }}
            </button>
        </form>
        <a href="{{ route('categories.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
            {{ __('categories.manage_categories') }}
        </a>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Da assegnare --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] px-6 py-4 flex items-center justify-between">
    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('home.ready_to_assign') }}</span>
    <span class="text-2xl font-extrabold {{ $readyToAssign < 0 ? 'text-red-500' : 'text-green-500' }}">
        {{ number_format($readyToAssign, 2, ',', '.') }} {{ $currency }}
    </span>
</div>

{{-- Tabella categorie --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('transactions.category') }}</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('home.assigned') }}</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('budget.spent') }}</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('home.available') }}</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-36">%</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($categories as $category)
                @php
                    $totalBudget = $category->assigned + $category->rollover;
                    $pct = $totalBudget > 0 ? min(100, round($category->spent / $totalBudget * 100)) : 0;
                    $barColor = $category->available < 0 ? 'bg-red-500' : ($pct >= 80 ? 'bg-yellow-500' : 'bg-green-500');
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">{{ $category->emoji }}</span>
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white/90">{{ $category->name }}</div>
                                @if($category->rollover != 0)
                                    <div class="text-xs {{ $category->rollover > 0 ? 'text-green-500' : 'text-red-400' }}">
                                        {{ $category->rollover > 0 ? '+' : '' }}{{ number_format($category->rollover, 2, ',', '.') }} {{ __('budget.rollover') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right text-gray-600 dark:text-gray-400">
                        {{ number_format($category->assigned, 2, ',', '.') }} {{ $currency }}
                    </td>
                    <td class="px-6 py-4 text-right text-gray-600 dark:text-gray-400">
                        {{ number_format($category->spent, 2, ',', '.') }} {{ $currency }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            {{ $category->available < 0 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($totalBudget > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400') }}">
                            {{ number_format($category->available, 2, ',', '.') }} {{ $currency }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($totalBudget > 0)
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-xs text-gray-400 w-8 text-right">{{ $pct }}%</span>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">{{ __('home.not_assigned') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('budget.edit', ['category' => $category, 'year' => $year, 'month' => $month]) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-900/20 dark:text-brand-400 transition">
                            {{ __('home.assign') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 dark:text-gray-600">
                        {{ __('categories.no_categories') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
