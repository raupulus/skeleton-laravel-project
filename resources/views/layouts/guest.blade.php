<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ setting('site_title', config('app.name', 'Laravel')) }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-indigo-600 focus:text-white focus:rounded-lg focus:shadow-lg focus:outline-none">
            {{ __('messages.skip_to_content') }}
        </a>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="{{ route('home') }}" aria-label="{{ setting('site_title', config('app.name', 'Laravel')) }} — {{ __('messages.home') }}">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" aria-hidden="true" />
                </a>
            </div>

            <main id="main-content" tabindex="-1" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg focus:outline-none">
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
