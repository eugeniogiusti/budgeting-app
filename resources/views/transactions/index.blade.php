@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ __('transactions.transactions') }}</h1>
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
            {{ __('transactions.new_income') }}
        </a>
        <a href="{{ route('transactions.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
            {{ __('transactions.new_expense') }}
        </a>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Filtri --}}
<div class="mb-4 flex flex-wrap gap-2">
    <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month]) }}"
       class="px-4 py-1.5 rounded-full text-sm font-semibold border transition
              {{ !$activeType && !$activeCategoryId ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-gray-600 border-gray-200 hover:border-brand-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700' }}">
        {{ __('transactions.filter_all') }}
    </a>
    <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month, 'type' => 'income']) }}"
       class="px-4 py-1.5 rounded-full text-sm font-semibold border transition
              {{ $activeType === 'income' ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-600 border-gray-200 hover:border-green-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700' }}">
        {{ __('home.income') }}
    </a>
    <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month, 'type' => 'expense']) }}"
       class="px-4 py-1.5 rounded-full text-sm font-semibold border transition
              {{ $activeType === 'expense' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-gray-600 border-gray-200 hover:border-red-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700' }}">
        {{ __('home.expenses') }}
    </a>
    @foreach($categories as $cat)
        <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month, 'category_id' => $cat->id]) }}"
           class="px-3 py-1.5 rounded-full text-sm border transition
                  {{ $activeCategoryId == $cat->id ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-gray-600 border-gray-200 hover:border-brand-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700' }}"
           title="{{ $cat->name }}">
            {{ $cat->emoji }} {{ $cat->name }}
        </a>
    @endforeach
</div>

{{-- Tabella --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    @forelse($transactions as $transaction)
        <div class="flex items-center gap-4 px-6 py-4 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">

            {{-- Icona --}}
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0
                        {{ $transaction->type === 'income' ? 'bg-green-50 dark:bg-green-900/20' : 'bg-gray-100 dark:bg-gray-800' }}">
                {{ $transaction->type === 'income' ? '💰' : ($transaction->category->emoji ?? '❓') }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-sm text-gray-800 dark:text-white/90 truncate">
                    @if($transaction->type === 'income')
                        {{ $transaction->note ?: __('home.income') }}
                    @else
                        {{ $transaction->category->name ?? __('transactions.unknown_category') }}
                    @endif
                </div>
                <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                    @if($transaction->type === 'expense' && $transaction->note)
                        {{ $transaction->note }} ·
                    @endif
                    {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                </div>
            </div>

            {{-- Importo --}}
            <div class="font-bold text-sm flex-shrink-0 {{ $transaction->type === 'income' ? 'text-green-500' : 'text-red-500' }}">
                {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2, ',', '.') }} {{ $currency }}
            </div>

            {{-- Azioni --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('transactions.edit', $transaction) }}"
                   class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-900/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                      onsubmit="return confirm('{{ $transaction->type === 'income' ? __('transactions.confirm_delete_income') : __('transactions.confirm_delete') }}')">
                    @csrf
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <button type="submit"
                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>

        </div>
    @empty
        <div class="px-6 py-16 text-center">
            <div class="text-4xl mb-3">🎉</div>
            <div class="text-gray-400 dark:text-gray-600 font-medium">{{ __('transactions.no_transactions') }}</div>
        </div>
    @endforelse
</div>

@endsection
