@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

@section('topbar-left')
    <div class="flex items-center gap-3">
        <a href="{{ route('budget.index') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <span class="text-white font-bold text-lg">{{ __('categories.categories') }}</span>
    </div>
@endsection

@section('topbar-right')
    <a href="{{ route('categories.create') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" d="M12 5v14m-7-7h14"/>
        </svg>
    </a>
@endsection

    <div class="pt-4"></div>

    @if(session('success'))
        <div class="bg-lime-400/20 text-lime-200 rounded-2xl px-5 py-3 mb-4 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/20 text-red-200 rounded-2xl px-5 py-3 mb-4 text-sm">{{ session('error') }}</div>
    @endif

    {{-- List --}}
    <div class="bg-white rounded-3xl overflow-hidden mb-6">
        @forelse($categories as $category)
            <div class="flex items-center gap-3 px-5 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0"
                     style="background-color: {{ $category->color ? $category->color . '22' : '#f3f4f6' }}">
                    {{ $category->emoji }}
                </div>
                <div class="flex-1 font-semibold text-gray-800 text-sm">{{ $category->name }}</div>
                <a href="{{ route('categories.edit', $category) }}"
                   class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-[#667eea] transition rounded-full hover:bg-indigo-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 0l.172.172a2 2 0 010 2.828L12 16H9v-3z"/>
                    </svg>
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf
                    <button type="button"
                            class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-400 transition rounded-full hover:bg-red-50"
                            onclick="nativeConfirm(this.closest('form'), '{{ __('categories.confirm_delete_category') }}')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        @empty
            <div class="px-5 py-12 text-center text-gray-400">
                <div class="text-4xl mb-3">📂</div>
                <div class="font-medium">{{ __('categories.no_categories') }}</div>
            </div>
        @endforelse
    </div>

</div>
@endsection
