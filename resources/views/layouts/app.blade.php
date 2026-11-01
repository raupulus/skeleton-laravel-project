<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head_css')
        @stack('head_js')
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-indigo-600 focus:text-white focus:rounded-lg focus:shadow-lg focus:outline-none">
            {{ __('messages.skip_to_content') }}
        </a>
        @include('layouts.navbar')
        <x-flash-messages />
        @yield('header')
        <main id="main-content" tabindex="-1" class="flex-1 focus:outline-none">@yield('content')</main>
        @include('layouts.footer')
        @stack('scripts')
    </body>
</html>
