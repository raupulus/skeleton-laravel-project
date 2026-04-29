<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Formulario de creación de token --}}
        <div class="bg-white rounded-xl shadow p-6 dark:bg-gray-800">
            <h3 class="text-lg font-medium mb-4">Crear nuevo token</h3>
            <div class="flex gap-4 items-start">
                <div class="flex-1">
                    <input
                        type="text"
                        wire:model="tokenName"
                        wire:keydown.enter="createToken"
                        placeholder="Nombre del token"
                        class="w-full rounded-lg border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('tokenName') border-red-500 @enderror"
                    />
                    @error('tokenName')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <x-filament::button wire:click="createToken" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="createToken">Crear</span>
                    <span wire:loading wire:target="createToken">Creando…</span>
                </x-filament::button>
            </div>

            @if($plainTextToken)
                <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200 dark:bg-green-900/20 dark:border-green-700">
                    <p class="text-xs font-semibold text-green-700 dark:text-green-400 mb-1">Token generado — cópialo ahora, no se mostrará de nuevo:</p>
                    <p class="text-sm font-mono break-all text-green-900 dark:text-green-200 select-all">{{ $plainTextToken }}</p>
                </div>
            @endif
        </div>

        {{-- Listado de tokens existentes --}}
        <div class="bg-white rounded-xl shadow overflow-hidden dark:bg-gray-800">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Nombre</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Creado</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 dark:text-gray-300">Último uso</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->tokens as $token)
                        <tr class="border-t border-gray-100 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $token->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $token->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $token->last_used_at ? $token->last_used_at->format('d/m/Y H:i') : '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                <x-filament::button
                                    color="danger"
                                    size="sm"
                                    wire:click="deleteToken({{ $token->id }})"
                                    wire:confirm="¿Seguro que quieres eliminar este token?"
                                    wire:loading.attr="disabled"
                                >
                                    Eliminar
                                </x-filament::button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">No tienes tokens de API creados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
