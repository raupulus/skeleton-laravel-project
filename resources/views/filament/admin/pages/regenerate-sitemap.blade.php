<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('filament.regenerate_sitemap') }}
        </x-slot>
        <p class="text-gray-600 dark:text-gray-400" style="margin: 0; font-size: 0.875rem;">
            {{ __('filament.regenerate_sitemap_desc') }}
        </p>
        <p class="text-gray-500 dark:text-gray-400" style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">
            {{ __('filament.regenerate_sitemap_location') }} <code class="bg-gray-100 dark:bg-white/10 text-gray-900 dark:text-gray-200" style="padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.75rem;">public/sitemap.xml</code>
        </p>
    </x-filament::section>
</x-filament-panels::page>
