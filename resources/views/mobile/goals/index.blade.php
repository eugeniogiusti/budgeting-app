@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-12 pb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">{{ __('ui.nav_goals') }}</h1>
        <a href="{{ route('goals.create') }}"
           class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" d="M12 5v14m-7-7h14"/>
            </svg>
        </a>
    </div>

    {{-- Goals list --}}
    @forelse($goals as $goal)
        <div class="bg-white rounded-3xl p-5 mb-3">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">{{ $goal->emoji }}</span>
                    <div>
                        <div class="text-gray-800 font-bold">{{ $goal->name }}</div>
                        @if($goal->target_date)
                            <div class="text-gray-400 text-xs">
                                {{ __('ui.goal_by') }} {{ \Carbon\Carbon::parse($goal->target_date)->format('M Y') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('goals.edit', $goal) }}"
                       class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-[#667eea] transition rounded-full hover:bg-[#667eea]/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form action="{{ route('goals.destroy', $goal) }}" method="POST">
                        @csrf
                        <button type="button"
                                class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-400 transition rounded-full hover:bg-red-50"
                                onclick="nativeConfirm(this.closest('form'), '{{ __('ui.confirm_delete_goal') }}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="mb-2">
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="h-3 rounded-full transition-all duration-500
                        {{ $goal->progress_pct >= 100 ? 'bg-lime-400' : 'bg-gradient-to-r from-[#667eea] to-[#4ecdc4]' }}"
                         style="width: {{ $goal->progress_pct }}%">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-400">
                    {{ number_format($goal->saved, 2, ',', '.') }} {{ $currency }}
                    {{ __('ui.of') }}
                    {{ number_format($goal->target_amount, 2, ',', '.') }} {{ $currency }}
                </span>
                <div class="flex items-center gap-2">
                    <span class="font-bold {{ $goal->progress_pct >= 100 ? 'text-lime-600' : 'text-[#667eea]' }}">
                        {{ $goal->progress_pct }}%
                    </span>
                    <a href="{{ route('budget.edit', $goal) }}"
                       class="px-3 py-1 bg-[#667eea]/10 text-[#667eea] text-xs font-bold rounded-full hover:bg-[#667eea]/20 transition">
                        {{ __('ui.goal_add_funds') }}
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-10 text-center">
            <div class="text-5xl mb-4">🎯</div>
            <div class="text-white font-bold text-lg mb-1">{{ __('ui.no_goals') }}</div>
            <div class="text-white/60 text-sm mb-5">{{ __('ui.no_goals_subtitle') }}</div>
            <a href="{{ route('goals.create') }}"
               class="inline-block px-6 py-3 bg-white text-[#667eea] font-bold rounded-2xl text-sm">
                {{ __('ui.create_goal') }}
            </a>
        </div>
    @endforelse

</div>
@endsection
