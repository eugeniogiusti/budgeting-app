@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-12 pb-6 flex items-center gap-4">
        <a href="{{ route('goals.index') }}" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold">{{ __('ui.edit_goal') }}</h1>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl p-6">
        <form action="{{ route('goals.update', $goal) }}" method="POST">
            @csrf

            <div class="mb-5">
                <div class="flex gap-2 mb-1.5">
                    <label class="text-gray-500 text-sm font-medium w-16 text-center">{{ __('ui.goal_emoji') }}</label>
                    <label class="text-gray-500 text-sm font-medium flex-1">{{ __('ui.goal_name') }}</label>
                </div>
                <div class="flex gap-3">
                    <input type="text" name="emoji" maxlength="4" value="{{ $goal->emoji }}"
                           class="w-16 text-center px-2 py-3.5 bg-gray-100 rounded-2xl text-2xl focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                    <input type="text" name="name" required value="{{ $goal->name }}"
                           placeholder="{{ __('ui.goal_name_placeholder') }}"
                           class="flex-1 px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">{{ __('ui.goal_target') }}</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl font-bold">{{ $currency }}</span>
                    <input type="number" name="target_amount" step="0.01" min="1" required
                           value="{{ number_format($goal->target_amount, 2, '.', '') }}"
                           class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-2xl text-gray-800 text-2xl font-bold focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-gray-500 text-sm font-medium mb-1.5">
                    {{ __('ui.goal_date') }}
                    <span class="text-gray-300 font-normal ml-1">{{ __('ui.optional') }}</span>
                </label>
                <input type="date" name="target_date"
                       value="{{ $goal->target_date ? \Carbon\Carbon::parse($goal->target_date)->format('Y-m-d') : '' }}"
                       class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/50">
            </div>

            <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold rounded-2xl text-lg transition hover:opacity-90">
                {{ __('ui.save_goal') }}
            </button>
        </form>
    </div>

</div>
@endsection
