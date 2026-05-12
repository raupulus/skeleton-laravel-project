<x-filament-panels::page>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('filament.clear_cache') }}</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ __('filament.clear_cache_desc') }}
        </p>
        <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-700">
            <p class="text-sm font-medium text-amber-800 dark:text-amber-300">⚠️ {{ __('filament.clear_cache_warning') }}</p>
            <ul class="mt-2 text-sm text-amber-700 dark:text-amber-400 list-disc list-inside space-y-1">
                <li>{{ __('filament.clear_cache_warn_sessions') }}</li>
                <li>{{ __('filament.clear_cache_warn_data') }}</li>
                <li>{{ __('filament.clear_cache_warn_queues') }}</li>
                <li>{{ __('filament.clear_cache_warn_slow') }}</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
