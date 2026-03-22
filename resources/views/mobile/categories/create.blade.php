@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- Header --}}
    <div class="pt-12 pb-6 flex items-center gap-4">
        <a href="{{ route('categories.index') }}" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold">{{ __('ui.new_category') }}</h1>
    </div>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-3xl p-6 mb-4 space-y-5">

            {{-- Emoji + Name --}}
            <div class="flex gap-3">
                <div class="w-20 flex-shrink-0">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('ui.goal_emoji') }}</label>
                    <input type="text" name="emoji" value="{{ old('emoji') }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-3 text-center text-2xl focus:outline-none focus:ring-2 focus:ring-[#667eea]/30"
                           placeholder="🏠" maxlength="5" required>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">{{ __('ui.category_name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#667eea]/30"
                           placeholder="{{ __('ui.category_name_placeholder') }}" required>
                </div>
            </div>

            {{-- Color presets --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">{{ __('ui.category_color') }}</label>
                <input type="hidden" name="color" id="colorInput" value="{{ old('color', '#667eea') }}">
                <div class="flex gap-3 flex-wrap">
                    @foreach(['#667eea','#4ecdc4','#f093fb','#f5a623','#43e97b','#fa709a','#4facfe','#f7971e','#a18cd1','#ff6b6b'] as $c)
                        <button type="button"
                                onclick="document.getElementById('colorInput').value='{{ $c }}'; document.querySelectorAll('.color-dot').forEach(el => el.classList.remove('ring-2','ring-offset-2','ring-gray-600')); this.classList.add('ring-2','ring-offset-2','ring-gray-600')"
                                class="color-dot w-8 h-8 rounded-full transition {{ old('color','#667eea') === $c ? 'ring-2 ring-offset-2 ring-gray-600' : '' }}"
                                style="background-color: {{ $c }}"></button>
                    @endforeach
                </div>
            </div>

        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#667eea]/30 text-base">
            {{ __('ui.create_category') }}
        </button>
    </form>

</div>
@endsection
