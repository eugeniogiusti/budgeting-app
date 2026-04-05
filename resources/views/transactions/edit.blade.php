@extends('layouts.app')

@section('content')

<div class="mb-6">
    <x-common.page-breadcrumb :pageTitle="$transaction->type === 'income' ? __('transactions.edit_income') : __('transactions.edit_expense')" />
</div>

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                {{ $transaction->type === 'income' ? __('transactions.edit_income') : __('transactions.edit_expense') }}
            </h3>
        </div>
        <div class="p-6">
            <form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Importo --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('transactions.amount') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">{{ $currency }}</span>
                        <input type="number" name="amount" step="0.01" min="0.01" required
                               value="{{ old('amount', $transaction->amount) }}"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 text-lg font-semibold">
                    </div>
                    @error('amount')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Categoria (solo spese) --}}
                @if($transaction->type === 'expense')
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('transactions.category') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->emoji }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                @endif

                {{-- Nota --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('transactions.note') }}
                    </label>
                    <input type="text" name="note"
                           value="{{ old('note', $transaction->note) }}"
                           placeholder="{{ $transaction->type === 'income' ? __('transactions.note_placeholder') : __('transactions.expense_note_placeholder') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                </div>

                {{-- Ricevuta --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('transactions.receipt') }}
                    </label>

                    @if($transaction->receipt_path)
                        <div class="flex items-center gap-3 mb-2 p-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <div class="flex-1 flex items-center gap-3">
                                <a href="{{ route('transactions.receipt', $transaction) }}" target="_blank"
                                   class="text-sm text-brand-600 dark:text-brand-400 hover:underline">
                                    {{ __('transactions.receipt_view') }}
                                </a>
                                <a href="{{ route('transactions.receipt.download', $transaction) }}"
                                   class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                                    {{ __('transactions.receipt_download') }}
                                </a>
                            </div>
                            <label class="flex items-center gap-1.5 text-xs text-red-500 cursor-pointer">
                                <input type="checkbox" name="remove_receipt" value="1" class="rounded border-gray-300 text-red-500">
                                {{ __('transactions.receipt_remove') }}
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mb-1.5">{{ __('transactions.receipt_change') }}</p>
                    @endif

                    <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500
                                  file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 dark:file:bg-brand-900/30 dark:file:text-brand-400 hover:file:bg-brand-100">
                    <p class="mt-1 text-xs text-gray-400">{{ __('transactions.receipt_hint') }}</p>
                    @error('receipt')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Data --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('transactions.date') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date"
                           value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                    @error('date')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('transactions.index', ['year' => \Carbon\Carbon::parse($transaction->date)->year, 'month' => \Carbon\Carbon::parse($transaction->date)->month]) }}"
                       class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        {{ __('transactions.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
                        {{ $transaction->type === 'income' ? __('transactions.save_expense') : __('transactions.save_expense') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
