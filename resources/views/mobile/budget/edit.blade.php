@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-4 pb-6 flex items-center gap-4">
        <a href="{{ route('budget.index') }}" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-2">
            <span class="text-3xl">{{ $category->emoji }}</span>
            <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
        </div>
    </div>

    {{-- Ready to Assign --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 mb-5 flex items-center justify-between">
        <span class="text-sm text-white/70 font-medium">{{ __('ui.ready_to_assign') }}</span>
        <span class="text-xl font-extrabold {{ $readyToAssign < 0 ? 'text-red-300' : 'text-lime-300' }}">
            {{ number_format($readyToAssign, 2, ',', '.') }} {{ $currency }}
        </span>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl p-6">
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-gray-50 rounded-2xl p-3 text-center">
                <div class="text-red-500 font-bold text-lg">{{ number_format($spent, 2, ',', '.') }} {{ $currency }}</div>
                <div class="text-gray-400 text-xs mt-0.5">{{ __('ui.spent') }}</div>
            </div>
            <div class="bg-gray-50 rounded-2xl p-3 text-center">
                @php $available = $assigned - $spent; @endphp
                <div class="font-bold text-lg {{ $available < 0 ? 'text-red-500' : 'text-lime-600' }}">
                    {{ number_format($available, 2, ',', '.') }} {{ $currency }}
                </div>
                <div class="text-gray-400 text-xs mt-0.5">{{ __('ui.available') }}</div>
            </div>
        </div>

        <form action="{{ route('budget.update', $category) }}" method="POST">
            @csrf
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="month" value="{{ $month }}">

            <div class="mb-6">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('ui.assign_amount') }}</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl font-bold">{{ $currency }}</span>
                    <input type="number" name="amount" step="0.01" min="0"
                           value="{{ number_format($assigned, 2, '.', '') }}"
                           class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-2xl text-gray-800 text-2xl font-bold focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                </div>
            </div>

            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold rounded-2xl text-lg transition hover:opacity-90">
                {{ __('ui.save_budget') }}
            </button>
        </form>
    </div>

</div>
@endsection
