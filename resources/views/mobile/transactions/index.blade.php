@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-4 pb-4 flex items-center gap-4">
        <a href="{{ route('home', ['year' => $year, 'month' => $month]) }}"
           class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold">{{ __('transactions.transactions') }}</h1>
            <div class="flex items-center gap-2 mt-0.5">
                <a href="{{ $prevUrl }}" class="w-6 h-6 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="text-white/70 text-sm font-medium">{{ $monthName }}</span>
                @if($isCurrentMonth)
                    <span class="w-6 h-6"></span>
                @else
                    <a href="{{ $nextUrl }}" class="w-6 h-6 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Filter Pills --}}
    <div class="flex gap-2 overflow-x-auto pb-4" style="-webkit-overflow-scrolling:touch;scrollbar-width:none;">
        <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month]) }}"
           class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-bold border transition
                  {{ !$activeType && !$activeCategoryId ? 'bg-white text-[#667eea] border-white' : 'bg-white/10 text-white border-white/40' }}">
            {{ __('transactions.filter_all') }}
        </a>
        <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month, 'type' => 'income']) }}"
           class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-bold border transition
                  {{ $activeType === 'income' ? 'bg-emerald-400 text-white border-emerald-400' : 'bg-white/10 text-white border-white/40' }}">
            {{ __('home.income') }}
        </a>
        <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month, 'type' => 'expense']) }}"
           class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-bold border transition
                  {{ $activeType === 'expense' ? 'bg-red-400 text-white border-red-400' : 'bg-white/10 text-white border-white/40' }}">
            {{ __('home.expenses') }}
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('transactions.index', ['year' => $year, 'month' => $month, 'category_id' => $cat->id]) }}"
               class="flex-shrink-0 px-3 py-2 rounded-full text-sm border transition
                      {{ $activeCategoryId == $cat->id ? 'bg-white text-[#667eea] border-white' : 'bg-white/10 text-white border-white/40' }}"
               title="{{ $cat->name }}">
                {{ $cat->emoji }}
            </a>
        @endforeach
    </div>

    {{-- Summary --}}
    @php $balance = $totalIncome - $totalExpenses; @endphp
    <div class="grid grid-cols-3 gap-2 mb-4">
        <div class="bg-white/10 rounded-2xl px-3 py-2.5 text-center">
            <div class="text-white/60 text-xs mb-0.5">{{ __('home.income') }}</div>
            <div class="text-emerald-300 font-bold text-sm">+{{ number_format($totalIncome, 2, ',', '.') }}</div>
        </div>
        <div class="bg-white/10 rounded-2xl px-3 py-2.5 text-center">
            <div class="text-white/60 text-xs mb-0.5">{{ __('home.expenses') }}</div>
            <div class="text-red-300 font-bold text-sm">-{{ number_format($totalExpenses, 2, ',', '.') }}</div>
        </div>
        <div class="bg-white/10 rounded-2xl px-3 py-2.5 text-center">
            <div class="text-white/60 text-xs mb-0.5">{{ __('home.balance') }}</div>
            <div class="font-bold text-sm {{ $balance >= 0 ? 'text-white' : 'text-red-300' }}">
                {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- List --}}
    <div class="bg-white rounded-3xl overflow-hidden mb-6">
        @forelse($transactions as $transaction)
            <div class="flex items-center gap-3 px-5 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <a href="{{ route('transactions.edit', $transaction) }}" class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0
                                {{ $transaction->type === 'income' ? 'bg-emerald-50' : 'bg-gray-100' }}">
                        {{ $transaction->type === 'income' ? '💰' : ($transaction->category->emoji ?? '❓') }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-gray-800 font-semibold text-sm truncate">
                            @if($transaction->type === 'income')
                                {{ $transaction->note ?: __('home.income') }}
                            @else
                                {{ $transaction->category->name ?? __('transactions.unknown_category') }}
                            @endif
                        </div>
                        <div class="text-gray-400 text-xs">
                            @if($transaction->type === 'expense' && $transaction->note)
                                <span class="truncate">{{ $transaction->note }}</span>
                            @else
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m') }}
                            @endif
                        </div>
                    </div>
                    <div class="font-bold text-sm flex-shrink-0 {{ $transaction->type === 'income' ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2, ',', '.') }} {{ $currency }}
                    </div>
                </a>
                @if($transaction->receipt_path)
                    <a href="{{ route('transactions.receipt', $transaction) }}" target="_blank"
                       class="w-8 h-8 flex items-center justify-center text-green-400 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <a href="{{ route('transactions.receipt.download', $transaction) }}"
                       class="w-8 h-8 flex items-center justify-center text-green-400 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                @endif
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                      x-data x-on:submit.prevent="if(confirm('{{ $transaction->type === 'income' ? __('transactions.confirm_delete_income') : __('transactions.confirm_delete') }}')) $el.submit()">
                    @csrf
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <button type="submit"
                            class="w-8 h-8 flex items-center justify-center text-gray-300 active:text-red-400 transition rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        @empty
            <div class="px-5 py-12 text-center text-gray-400">
                <div class="text-4xl mb-3">🎉</div>
                <div class="font-medium">{{ __('transactions.no_transactions') }}</div>
            </div>
        @endforelse
    </div>

</div>
@endsection
