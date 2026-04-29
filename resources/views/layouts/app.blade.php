<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head_css')
        @stack('head_js')
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">
        @include('layouts.navbar')
        <x-flash-messages />
        @yield('header')
        <main class="flex-1">@yield('content')</main>
        @include('layouts.footer')
        @stack('scripts')
    </body>
</html>
