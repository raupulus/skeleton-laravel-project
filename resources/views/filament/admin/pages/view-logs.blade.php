<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Descripción --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('filament.view_logs') }}</h3>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                {{ __('filament.view_logs_desc') }}
            </p>
        </div>

        {{-- Tabla de logs --}}
        <x-filament::section>
            <div class="overflow-x-auto -mx-6 -my-4">
                <table class="w-full" style="table-layout: fixed;">
                    <colgroup>
                        <col style="width: 35%;">
                        <col style="width: 15%;">
                        <col style="width: 22%;">
                        <col style="width: 28%;">
                    </colgroup>
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('filament.view_logs_col_file') }}</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('filament.view_logs_col_size') }}</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('filament.view_logs_col_modified') }}</th>
                            <th class="px-8 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('filament.view_logs_col_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->logFiles as $log)
                            <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="font-mono text-sm font-medium text-gray-900 dark:text-white truncate block">{{ $log['name'] }}</span>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $log['size'] }}
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $log['modified'] }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <x-filament::button size="sm" color="gray" icon="heroicon-m-eye" wire:click="viewLog('{{ $log['name'] }}')">
                                            {{ __('filament.view_logs_view') }}
                                        </x-filament::button>
                                        <x-filament::button size="sm" color="primary" icon="heroicon-m-arrow-down-tray" wire:click="downloadLog('{{ $log['name'] }}')">
                                            {{ __('filament.view_logs_download') }}
                                        </x-filament::button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center text-sm text-gray-400 dark:text-gray-500">
                                    {{ __('filament.view_logs_empty') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>

    {{-- Modal de contenido del log --}}
    @if($selectedLog)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click.self="closeLogModal">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-5xl max-h-[80vh] flex flex-col m-4">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $selectedLog }}</h3>
                    <div class="flex items-center gap-2">
                        <x-filament::button size="sm" color="primary" wire:click="downloadLog('{{ $selectedLog }}')">
                            {{ __('filament.view_logs_download') }}
                        </x-filament::button>
                        <x-filament::button size="sm" color="gray" wire:click="closeLogModal">
                            {{ __('filament.close') }}
                        </x-filament::button>
                    </div>
                </div>
                <div class="flex-1 overflow-auto p-4">
                    <pre class="text-xs font-mono text-gray-800 dark:text-gray-200 whitespace-pre-wrap break-words">{{ $logContent }}</pre>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
