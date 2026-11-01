@extends('layouts.app')
@section('content')

{{-- ============================================================
     HERO
     ============================================================ --}}
<div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20 sm:py-28 text-center">
        <span class="inline-block bg-white/15 text-white text-xs font-semibold uppercase tracking-widest px-4 py-1 rounded-full mb-6">
            {{ __('messages.home_hero_badge') }}
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
            {{ __('messages.home_hero_title') }}
        </h1>
        <p class="max-w-2xl mx-auto text-lg sm:text-xl text-indigo-100 mb-10">
            {{ __('messages.home_hero_description') }}
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold px-8 py-3 rounded-xl shadow hover:bg-indigo-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                {{ __('messages.home_hero_btn_docs') }}
            </a>
            <a href="{{ route('filament.admin.pages.dashboard') }}"
               class="inline-flex items-center gap-2 bg-indigo-500 text-white font-semibold px-8 py-3 rounded-xl shadow hover:bg-indigo-400 transition border border-white/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('messages.home_hero_btn_admin') }}
            </a>
            <a href="{{ route('scribe') }}"
               class="inline-flex items-center gap-2 bg-transparent text-white font-semibold px-8 py-3 rounded-xl border border-white/40 hover:bg-white/10 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ __('messages.home_hero_btn_api') }}
            </a>
        </div>
    </div>
</div>

{{-- ============================================================
     QUICK START
     ============================================================ --}}
<div class="bg-gray-900 text-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-10">
        <p class="text-gray-400 text-sm font-semibold uppercase tracking-wider mb-3">{{ __('messages.home_quickstart_title') }}</p>
        <div class="bg-gray-800 rounded-xl p-5 font-mono text-sm overflow-x-auto">
            <span class="text-green-400">$</span> git clone https://github.com/raupulus/skeleton-laravel-project.git &amp;&amp; cd skeleton-laravel-project<br>
            <span class="text-green-400">$</span> cp .env.example .env &amp;&amp; composer install &amp;&amp; pnpm install<br>
            <span class="text-green-400">$</span> php artisan project:install<br>
            <span class="text-green-400">$</span> php artisan serve &amp;&amp; pnpm run dev
        </div>
    </div>
</div>

{{-- ============================================================
     FUNCIONALIDADES PRINCIPALES
     ============================================================ --}}
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">{{ __('messages.home_features_title') }}</h2>
            <p class="max-w-2xl mx-auto text-gray-500 text-lg">{{ __('messages.home_features_description') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @php
                $features = [
                    ['key' => 'auth',     'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'bg' => 'indigo'],
                    ['key' => 'filament', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'bg' => 'orange'],
                    ['key' => 'api',      'icon' => 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'bg' => 'green'],
                    ['key' => 'i18n',     'icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129', 'bg' => 'blue'],
                    ['key' => 'seo',      'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'bg' => 'pink'],
                    ['key' => 'content',  'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'bg' => 'yellow'],
                    ['key' => 'settings', 'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'bg' => 'teal'],
                    ['key' => 'docker',   'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'bg' => 'sky'],
                    ['key' => 'tests',    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'violet'],
                ];
            @endphp

            @foreach($features as $feat)
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 hover:shadow-md transition">
                    <div class="w-11 h-11 bg-{{ $feat['bg'] }}-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-{{ $feat['bg'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feat['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ __('messages.home_feat_' . $feat['key'] . '_title') }}</h3>
                    <p class="text-gray-500 text-sm">{{ __('messages.home_feat_' . $feat['key'] . '_desc') }}</p>
                </div>
            @endforeach

        </div>
    </div>
</div>

{{-- ============================================================
     STACK TECNOLÓGICO
     ============================================================ --}}
<div class="bg-gray-50 border-y border-gray-200 py-14">
    <div class="max-w-7xl mx-auto px-4">
        <p class="text-center text-gray-500 text-sm font-semibold uppercase tracking-widest mb-8">{{ __('messages.home_stack_title') }}</p>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach([
                ['PHP 8.5', 'bg-violet-100 text-violet-800'],
                ['Laravel 13', 'bg-red-100 text-red-800'],
                ['Filament 5', 'bg-orange-100 text-orange-800'],
                ['Livewire 4', 'bg-pink-100 text-pink-800'],
                ['Tailwind CSS 4', 'bg-cyan-100 text-cyan-800'],
                ['Alpine.js 3', 'bg-blue-100 text-blue-800'],
                ['Vue 3', 'bg-green-100 text-green-800'],
                ['PostgreSQL', 'bg-sky-100 text-sky-800'],
                ['Sanctum', 'bg-indigo-100 text-indigo-800'],
                ['Spatie Translatable', 'bg-yellow-100 text-yellow-800'],
                ['Spatie Sitemap', 'bg-lime-100 text-lime-800'],
                ['Scribe API Docs', 'bg-teal-100 text-teal-800'],
                ['Docker', 'bg-blue-100 text-blue-900'],
                ['Vite 8', 'bg-purple-100 text-purple-800'],
            ] as [$tech, $cls])
                <span class="inline-block {{ $cls }} text-sm font-medium px-4 py-1.5 rounded-full">{{ $tech }}</span>
            @endforeach
        </div>
    </div>
</div>

{{-- ============================================================
     PANELES DE ACCESO
     ============================================================ --}}
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ __('messages.home_panels_title') }}</h2>
            <p class="text-gray-500">{{ __('messages.home_panels_description') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <a href="{{ route('filament.admin.pages.dashboard') }}" class="group bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-2xl p-7 hover:shadow-lg transition text-center">
                <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ __('messages.home_panel_admin_title') }}</h3>
                <p class="text-gray-500 text-sm mb-3">{{ __('messages.home_panel_admin_desc') }}</p>
                <code class="text-xs bg-orange-200 text-orange-800 px-3 py-1 rounded-lg">admin@example.com</code>
            </a>
            <a href="{{ route('filament.panel.pages.dashboard') }}" class="group bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200 rounded-2xl p-7 hover:shadow-lg transition text-center">
                <div class="w-14 h-14 bg-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ __('messages.home_panel_user_title') }}</h3>
                <p class="text-gray-500 text-sm mb-3">{{ __('messages.home_panel_user_desc') }}</p>
                <code class="text-xs bg-indigo-200 text-indigo-800 px-3 py-1 rounded-lg">/panel</code>
            </a>
            <a href="{{ route('scribe') }}" class="group bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl p-7 hover:shadow-lg transition text-center">
                <div class="w-14 h-14 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ __('messages.home_panel_api_title') }}</h3>
                <p class="text-gray-500 text-sm mb-3">{{ __('messages.home_panel_api_desc') }}</p>
                <code class="text-xs bg-green-200 text-green-800 px-3 py-1 rounded-lg">/docs</code>
            </a>
        </div>
    </div>
</div>

{{-- ============================================================
     SECCIONES DINÁMICAS (desde BD, editables en Filament)
     ============================================================ --}}
@if($sections->count())
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4">
        @foreach($sections as $sectionItem)
            <x-section-block :block="$sectionItem" />
        @endforeach
    </div>
</div>
@endif

{{-- ============================================================
     SLIDES / CARRUSEL ZONA HOME
     ============================================================ --}}
<div class="max-w-7xl mx-auto px-4 py-12">
    <x-slide-carousel zone="home" />
</div>

{{-- ============================================================
     ÚLTIMOS POSTS (documentación)
     ============================================================ --}}
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-indigo-600 font-semibold text-sm uppercase tracking-wider mb-2">{{ __('messages.home_blog_subtitle') }}</p>
                <h2 class="text-3xl font-bold text-gray-900">{{ __('messages.blog') }}</h2>
            </div>
            <a href="{{ route('blog.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition">
                {{ __('messages.read_more') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($latestPosts as $post)
                <x-post-card :post="$post" />
            @empty
                <p class="text-gray-500 col-span-3 text-center py-10">{{ __('messages.no_results') }}</p>
            @endforelse
        </div>
        <div class="mt-10 text-center sm:hidden">
            <a href="{{ route('blog.index') }}"
               class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                {{ __('messages.read_more') }}
            </a>
        </div>
    </div>
</div>

{{-- Vue 3 mount point --}}
<div id="vue-app" class="hidden"><example-component /></div>

@endsection
