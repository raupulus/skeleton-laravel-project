<x-filament-panels::page>
    <form wire:submit="save" style="display: flex; flex-direction: column; gap: 1.5rem;">
        <x-filament::section>
            {{ $this->form }}
        </x-filament::section>

        <div style="display: flex; justify-content: flex-end; padding-top: 0.5rem;">
            <x-filament::button type="submit" size="lg">
                {{ __('messages.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
