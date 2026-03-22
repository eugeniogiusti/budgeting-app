@extends('layouts.app')

@section('content')

{{-- Header con navigazione mese --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ __('ui.home') }}</h1>
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
        <a href="{{ route('income.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
            {{ __('ui.add_income') }}
        </a>
        <a href="{{ route('transactions.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
            {{ __('ui.new_expense') }}
        </a>
    </div>
</div>

{{-- Flash message --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Metric Cards --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">

    {{-- Entrate --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.income') }}</span>
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-green-50 dark:bg-green-900/20">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m-7 7l7-7 7 7"/></svg>
            </span>
        </div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ number_format($monthIncome, 2, ',', '.') }} {{ $currency }}
        </div>
    </div>

    {{-- Uscite --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.expenses') }}</span>
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-50 dark:bg-red-900/20">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7l-7 7-7-7"/></svg>
            </span>
        </div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ number_format($monthExpenses, 2, ',', '.') }} {{ $currency }}
        </div>
    </div>

    {{-- Saldo --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.balance') }}</span>
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-50 dark:bg-blue-900/20">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l9-4 9 4v6c0 5.25-4.05 9.74-9 11-4.95-1.26-9-5.75-9-11V6z"/></svg>
            </span>
        </div>
        @php $balance = $monthIncome - $monthExpenses; @endphp
        <div class="text-2xl font-bold {{ $balance >= 0 ? 'text-gray-800 dark:text-white/90' : 'text-red-500' }}">
            {{ number_format($balance, 2, ',', '.') }} {{ $currency }}
        </div>
    </div>

    {{-- Da assegnare --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('ui.ready_to_assign') }}</span>
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-purple-50 dark:bg-purple-900/20">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <div class="text-2xl font-bold {{ $readyToAssign < 0 ? 'text-red-500' : 'text-gray-800 dark:text-white/90' }}">
            {{ number_format($readyToAssign, 2, ',', '.') }} {{ $currency }}
        </div>
        <a href="{{ route('budget.index', ['year' => $year, 'month' => $month]) }}"
           class="mt-2 inline-block text-xs text-brand-500 hover:underline font-medium">
            {{ __('ui.assign') }} →
        </a>
    </div>

</div>

{{-- Tabella categorie --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-6 py-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('ui.top_priorities') }}</h3>
        <a href="{{ route('budget.index', ['year' => $year, 'month' => $month]) }}"
           class="text-sm text-brand-500 hover:underline font-medium">
            {{ __('ui.nav_budget') }} →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.category') }}</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.assigned') }}</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.expenses') }}</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.available') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-36">%</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">{{ $category->emoji }}</span>
                                <span class="font-medium text-gray-800 dark:text-white/90">{{ $category->name }}</span>
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
                                {{ $category->available < 0 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($category->available > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400') }}">
                                {{ number_format($category->available, 2, ',', '.') }} {{ $currency }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($category->assigned > 0)
                                @php $pct = min(100, round(($category->spent / $category->assigned) * 100)); @endphp
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $pct >= 100 ? 'bg-red-500' : ($pct >= 80 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                             style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-400 w-8 text-right">{{ $pct }}%</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">{{ __('ui.not_assigned') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 dark:text-gray-600">
                            {{ __('ui.no_categories') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
