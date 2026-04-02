@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-4 pb-6 flex items-center gap-4">
        <a href="{{ route('transactions.index', ['year' => \Carbon\Carbon::parse($transaction->date)->year, 'month' => \Carbon\Carbon::parse($transaction->date)->month]) }}"
           class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold">
            {{ $transaction->type === 'income' ? __('transactions.edit_income') : __('transactions.edit_expense') }}
        </h1>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl p-6">
        <form action="{{ route('transactions.update', $transaction) }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.amount') }}</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl font-bold">{{ $currency }}</span>
                    <input type="number" name="amount" step="0.01" min="0.01" required
                           value="{{ $transaction->amount }}"
                           class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-2xl text-gray-800 text-2xl font-bold placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                </div>
            </div>

            @if($transaction->type === 'expense')
            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.category') }}</label>
                <select name="category_id" required
                        class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50 appearance-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->emoji }} {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.note') }}</label>
                <input type="text" name="note"
                       placeholder="{{ $transaction->type === 'income' ? __('transactions.note_placeholder') : __('transactions.expense_note_placeholder') }}"
                       value="{{ $transaction->note }}"
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <div class="mb-8">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.date') }}</label>
                <input type="date" name="date" value="{{ $transaction->date->format('Y-m-d') }}" required
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold rounded-2xl text-lg transition hover:opacity-90">
                {{ __('transactions.save') }}
            </button>
        </form>
    </div>

</div>
@endsection
