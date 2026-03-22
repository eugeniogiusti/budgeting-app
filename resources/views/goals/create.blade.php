@extends('layouts.app')

@section('content')

<div class="mb-6">
    <x-common.page-breadcrumb :pageTitle="__('ui.new_goal')" />
</div>

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('ui.new_goal') }}</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('goals.store') }}" method="POST">
                @csrf

                {{-- Emoji + Nome --}}
                <div class="mb-5">
                    <div class="flex gap-2 mb-1.5">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400 w-20 text-center">{{ __('ui.goal_emoji') }}</label>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400 flex-1">{{ __('ui.goal_name') }} <span class="text-red-500">*</span></label>
                    </div>
                    <div class="flex gap-3">
                        <input type="text" name="emoji" maxlength="4"
                               value="{{ old('emoji', '🎯') }}"
                               class="w-20 text-center px-2 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                        <input type="text" name="name" required
                               value="{{ old('name') }}"
                               placeholder="{{ __('ui.goal_name_placeholder') }}"
                               class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                    </div>
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Target amount --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('ui.goal_target') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">{{ $currency }}</span>
                        <input type="number" name="target_amount" step="0.01" min="1" required
                               value="{{ old('target_amount') }}"
                               placeholder="0.00"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500 text-lg font-semibold">
                    </div>
                    @error('target_amount')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Target date --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                        {{ __('ui.goal_date') }}
                        <span class="text-gray-400 font-normal ml-1">({{ __('ui.optional') }})</span>
                    </label>
                    <input type="date" name="target_date"
                           value="{{ old('target_date') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('goals.index') }}"
                       class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        {{ __('ui.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
                        {{ __('ui.create_goal') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
