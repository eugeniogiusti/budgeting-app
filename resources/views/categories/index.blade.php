@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ __('categories.categories') }}</h1>
    <a href="{{ route('categories.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
        {{ __('categories.new_category') }}
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400 text-sm">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 text-sm">
        {{ session('error') }}
    </div>
@endif

{{-- Lista --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    @forelse($categories as $category)
        <div class="flex items-center gap-4 px-6 py-4 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-white/[0.02] transition">

            {{-- Emoji --}}
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0"
                 style="background-color: {{ $category->color ? $category->color . '22' : '#f3f4f6' }}">
                {{ $category->emoji }}
            </div>

            {{-- Nome --}}
            <div class="flex-1 font-semibold text-gray-800 dark:text-white/90 text-sm">
                {{ $category->name }}
            </div>

            {{-- Colore dot --}}
            @if($category->color)
                <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $category->color }}"></div>
            @endif

            {{-- Azioni --}}
            <div class="flex items-center gap-1">
                <a href="{{ route('categories.edit', $category) }}"
                   class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-900/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                      onsubmit="return confirm('{{ __('categories.confirm_delete_category') }}')">
                    @csrf
                    <button type="submit"
                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>

        </div>
    @empty
        <div class="px-6 py-16 text-center">
            <div class="text-4xl mb-3">📂</div>
            <div class="text-gray-400 dark:text-gray-600 font-medium">{{ __('categories.no_categories') }}</div>
        </div>
    @endforelse
</div>

@endsection
