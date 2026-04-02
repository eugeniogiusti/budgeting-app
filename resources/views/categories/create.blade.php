@extends('layouts.app')

@section('content')

<div class="mb-6">
    <x-common.page-breadcrumb :pageTitle="__('categories.new_category')" />
</div>

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ __('categories.new_category') }}</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                {{-- Emoji + Nome --}}
                <div class="mb-5">
                    <div class="flex gap-2 mb-1.5">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400 w-20 text-center">{{ __('goals.goal_emoji') }}</label>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400 flex-1">{{ __('categories.category_name') }} <span class="text-red-500">*</span></label>
                    </div>
                    <div class="flex gap-3">
                        <input type="text" name="emoji" maxlength="5" required
                               value="{{ old('emoji') }}"
                               placeholder="🏠"
                               class="w-20 text-center px-2 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                        <input type="text" name="name" required
                               value="{{ old('name') }}"
                               placeholder="{{ __('categories.category_name_placeholder') }}"
                               class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                    </div>
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Colore --}}
                <div class="mb-8" x-data="{ selected: '{{ old('color', '#667eea') }}' }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">{{ __('categories.category_color') }}</label>
                    <input type="hidden" name="color" x-bind:value="selected">
                    <div class="flex gap-3 flex-wrap">
                        @foreach($categoryColors as $c)
                            <button type="button"
                                    x-on:click="selected = '{{ $c }}'"
                                    class="w-8 h-8 rounded-full transition"
                                    :class="selected === '{{ $c }}' ? 'ring-2 ring-offset-2 ring-gray-400' : ''"
                                    style="background-color: {{ $c }}"></button>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('categories.index') }}"
                       class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        {{ __('transactions.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
                        {{ __('categories.create_category') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
