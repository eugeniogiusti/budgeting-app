@extends('layouts.app')

@section('content')

<div class="mb-6">
    <x-common.page-breadcrumb :pageTitle="__('ui.new_income')" />
</div>

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('ui.new_income') }}</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('income.store') }}" method="POST">
                @csrf

                {{-- Importo --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('ui.amount') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="amount" step="0.01" min="0.01" required
                           value="{{ old('amount') }}"
                           placeholder="0.00"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                    @error('amount')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Data --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('ui.date') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" required
                           value="{{ old('date', date('Y-m-d')) }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                    @error('date')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Note --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('ui.note') }}
                    </label>
                    <input type="text" name="note"
                           value="{{ old('note') }}"
                           placeholder="{{ __('ui.note_placeholder') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('home') }}"
                       class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        {{ __('ui.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
                        {{ __('ui.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
