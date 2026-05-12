<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{-- Formulario con espaciado --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            {{ $this->form }}
        </div>

        {{-- Botón guardar con espaciado correcto --}}
        <div class="flex justify-end pt-4">
            <x-filament::button type="submit" size="lg">
                {{ __('messages.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
