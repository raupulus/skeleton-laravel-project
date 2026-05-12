<x-filament-panels::page>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('filament.regenerate_sitemap') }}</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ __('filament.regenerate_sitemap_desc') }}
        </p>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-500">
            {{ __('filament.regenerate_sitemap_location') }} <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">public/sitemap.xml</code>
        </p>
    </div>
</x-filament-panels::page>
