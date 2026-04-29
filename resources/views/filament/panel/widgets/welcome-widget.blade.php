<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-4">
            <div class="flex-shrink-0">
                <x-heroicon-o-hand-raised class="h-10 w-10 text-primary-500" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ __('messages.welcome_greeting', ['name' => $userName]) }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.active_tokens_count', ['count' => $tokenCount]) }}
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
