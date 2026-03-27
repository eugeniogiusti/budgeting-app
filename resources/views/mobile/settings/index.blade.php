@extends('layouts.mobile')

@section('content')
<div class="max-w-lg mx-auto px-4">

@section('topbar-left')
    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <span class="text-white font-bold text-lg">{{ __('settings.settings') }}</span>
    </div>
@endsection

    <div class="pt-4"></div>

    @if(session('success'))
        <div class="bg-lime-400/20 text-lime-200 rounded-2xl px-5 py-3 mb-4 text-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf

        <div class="bg-white rounded-3xl p-5 space-y-5 mb-4">

            {{-- Language --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">{{ __('settings.language') }}</label>
                <select name="locale"
                        class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#667eea]/30 appearance-none">
                    @foreach($locales as $code => $label)
                        <option value="{{ $code }}" {{ $locale === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Currency --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">{{ __('settings.currency') }}</label>
                <select name="currency"
                        class="w-full px-4 py-3.5 bg-gray-100 rounded-2xl text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#667eea]/30 appearance-none">
                    @foreach($currencies as $code => $label)
                        <option value="{{ $code }}" {{ $currencyCode === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-[#667eea] to-[#4ecdc4] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#667eea]/30 text-base">
            {{ __('settings.save_settings') }}
        </button>
    </form>

    {{-- Profile --}}
    <a href="{{ route('profile.index') }}"
       class="mt-4 flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold py-4 rounded-2xl transition text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        {{ __('auth.profile') }}
    </a>

    {{-- Export --}}
    <a href="{{ route('export.csv') }}"
       class="mt-3 flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold py-4 rounded-2xl transition text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        </svg>
        {{ __('import.export_csv') }}
    </a>

    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-white/10 hover:bg-red-500/30 text-white font-semibold py-4 rounded-2xl transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            {{ __('auth.logout') }}
        </button>
    </form>

</div>
@endsection
