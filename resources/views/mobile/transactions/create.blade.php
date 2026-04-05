@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-4 pb-6 flex items-center gap-4">
        <a href="{{ route('home') }}" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold">{{ __('transactions.new_expense') }}</h1>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl p-6">
        <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.amount') }}</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl font-bold">{{ $currency }}</span>
                    <input type="number" name="amount" step="0.01" min="0.01" required
                           placeholder="0.00"
                           class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-2xl text-gray-800 text-2xl font-bold placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.category') }}</label>
                <select name="category_id" required
                        class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50 appearance-none">
                    <option value="" disabled selected>{{ __('transactions.select_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->emoji }} {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.note') }}</label>
                <input type="text" name="note" placeholder="{{ __('transactions.expense_note_placeholder') }}"
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.date') }}</label>
                <input type="date" name="date" value="{{ $today }}" required
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <div class="mb-8">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('transactions.receipt') }}</label>
                <label class="flex items-center gap-3 px-4 py-3.5 bg-gray-100 rounded-2xl cursor-pointer">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <span class="text-gray-400 text-sm" x-data x-ref="label">{{ __('transactions.receipt_hint') }}</span>
                    <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                           x-data x-on:change="$refs.label.textContent = $el.files[0]?.name ?? '{{ __('transactions.receipt_hint') }}'">
                </label>
                @error('receipt')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold rounded-2xl text-lg transition hover:opacity-90">
                {{ __('transactions.submit_expense') }}
            </button>
        </form>
    </div>

</div>
@endsection
