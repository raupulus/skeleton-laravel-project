<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('filament.clear_cache') }}
        </x-slot>
        <p class="text-gray-600 dark:text-gray-400" style="margin: 0; font-size: 0.875rem;">
            {{ __('filament.clear_cache_desc') }}
        </p>
        <div class="bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-500/30" style="margin-top: 1rem; padding: 1rem; border-radius: 0.5rem;">
            <p class="text-amber-800 dark:text-amber-300" style="margin: 0; font-size: 0.875rem; font-weight: 600;">⚠️ {{ __('filament.clear_cache_warning') }}</p>
            <ul class="text-amber-700 dark:text-amber-400" style="margin: 0.5rem 0 0 0; padding-left: 1.25rem; font-size: 0.875rem; list-style-type: disc;">
                <li>{{ __('filament.clear_cache_warn_sessions') }}</li>
                <li>{{ __('filament.clear_cache_warn_data') }}</li>
                <li>{{ __('filament.clear_cache_warn_queues') }}</li>
                <li>{{ __('filament.clear_cache_warn_slow') }}</li>
            </ul>
        </div>
    </x-filament::section>
</x-filament-panels::page>
