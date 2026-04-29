<nav class="bg-white shadow-sm border-b" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">{{ setting('site_title', config('app.name')) }}</a>
                <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">{{ __('messages.home') }}</a>
                    <a href="{{ route('blog.index') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">{{ __('messages.blog') }}</a>
                    <a href="{{ route('about') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">{{ __('messages.about') }}</a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">{{ __('messages.contact') }}</a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                <x-language-switcher />
                @auth
                    <a href="{{ route('filament.panel.pages.dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-600">{{ __('messages.profile') }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button type="submit" class="text-sm text-gray-700 hover:text-indigo-600">{{ __('messages.logout') }}</button></form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">{{ __('messages.register') }}</a>
                @endauth
            </div>
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
            </div>
        </div>
    </div>
    <div x-show="open" class="sm:hidden border-t">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('home') }}" class="block text-gray-700">{{ __('messages.home') }}</a>
            <a href="{{ route('blog.index') }}" class="block text-gray-700">{{ __('messages.blog') }}</a>
            <a href="{{ route('about') }}" class="block text-gray-700">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}" class="block text-gray-700">{{ __('messages.contact') }}</a>
        </div>
    </div>
</nav>
