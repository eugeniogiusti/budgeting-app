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
        <h1 class="text-2xl font-bold">{{ __('ui.new_income') }}</h1>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl p-6">
        <form action="{{ route('income.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('ui.amount') }}</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl font-bold">{{ $currency }}</span>
                    <input type="number" name="amount" step="0.01" min="0.01" required
                           placeholder="0.00"
                           class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-2xl text-gray-800 text-2xl font-bold placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('ui.note') }}</label>
                <input type="text" name="note" placeholder="{{ __('ui.note_placeholder') }}"
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <div class="mb-8">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('ui.date') }}</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold rounded-2xl text-lg transition hover:opacity-90">
                {{ __('ui.submit_income') }}
            </button>
        </form>
    </div>

</div>
@endsection
