<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display: flex; align-items: center; gap: 1rem;">
            {{-- Icono pequeño a la izquierda --}}
            <div style="display: flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; background: var(--primary-50); flex-shrink: 0;">
                <x-filament::icon icon="heroicon-o-user-circle" style="width: 1.25rem; height: 1.25rem; color: var(--primary-600);" />
            </div>

            {{-- Contenido principal --}}
            <div style="flex: 1; min-width: 0;">
                <h2 class="fi-account-widget-heading" style="font-size: 0.9375rem; font-weight: 600; line-height: 1.5;">
                    {{ __('messages.welcome_greeting', ['name' => $userName]) }}
                </h2>
                <div style="display: flex; align-items: center; gap: 0.375rem; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--gray-500);">
                    <x-filament::icon icon="heroicon-m-key" style="width: 0.875rem; height: 0.875rem; color: var(--gray-400);" />
                    <span>{{ __('messages.active_tokens_count', ['count' => $tokenCount]) }}</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
