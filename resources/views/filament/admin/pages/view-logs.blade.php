<x-filament-panels::page>
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        {{-- Descripción --}}
        <x-filament::section>
            <x-slot name="heading">
                {{ __('filament.view_logs') }}
            </x-slot>
            <p class="text-gray-600 dark:text-gray-400" style="margin: 0; font-size: 0.875rem;">
                {{ __('filament.view_logs_desc') }}
            </p>
        </x-filament::section>

        {{-- Tabla de logs --}}
        <x-filament::section>
            <div style="overflow-x: auto; margin: -1rem -1.5rem;">
                <table style="width: 100%; min-width: 600px; text-align: left; border-collapse: collapse;">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-white/10">
                            <th class="text-gray-500 dark:text-gray-400" style="padding: 0.875rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('filament.view_logs_col_file') }}</th>
                            <th class="text-gray-500 dark:text-gray-400" style="padding: 0.875rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('filament.view_logs_col_size') }}</th>
                            <th class="text-gray-500 dark:text-gray-400" style="padding: 0.875rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('filament.view_logs_col_modified') }}</th>
                            <th class="text-gray-500 dark:text-gray-400" style="padding: 0.875rem 1.25rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('filament.view_logs_col_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($this->logFiles as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <td style="padding: 1rem 1.25rem;">
                                    <span class="text-gray-900 dark:text-white" style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.875rem; font-weight: 500; word-break: break-all;">{{ $log['name'] }}</span>
                                </td>
                                <td class="text-gray-600 dark:text-gray-400" style="padding: 1rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                                    {{ $log['size'] }}
                                </td>
                                <td class="text-gray-600 dark:text-gray-400" style="padding: 1rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                                    {{ $log['modified'] }}
                                </td>
                                <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                                    <div style="display: inline-flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: 0.5rem;">
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
                                <td colspan="4" class="text-gray-500 dark:text-gray-400" style="padding: 3rem 1.5rem; text-align: center; font-size: 0.875rem;">
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
        <div
            style="position: fixed; inset: 0; z-index: 50; display: flex; align-items: center; justify-content: center; background: rgba(3, 7, 18, 0.6); backdrop-filter: blur(2px); padding: 1rem;"
            role="dialog"
            aria-modal="true"
            aria-labelledby="log-modal-title"
            wire:click.self="closeLogModal"
            x-on:keydown.escape.window="$wire.closeLogModal()"
        >
            <div class="bg-white dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10" style="border-radius: 0.75rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); width: 100%; max-width: 64rem; max-height: 85vh; display: flex; flex-direction: column;">
                <div class="border-b border-gray-200 dark:border-white/10" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.5rem; padding: 1rem 1.5rem;">
                    <h3 id="log-modal-title" class="text-gray-950 dark:text-white" style="margin: 0; font-size: 1rem; font-weight: 600; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; word-break: break-all;">{{ $selectedLog }}</h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <x-filament::button size="sm" color="primary" icon="heroicon-m-arrow-down-tray" wire:click="downloadLog('{{ $selectedLog }}')">
                            {{ __('filament.view_logs_download') }}
                        </x-filament::button>
                        <x-filament::button size="sm" color="gray" wire:click="closeLogModal">
                            {{ __('filament.close') }}
                        </x-filament::button>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-950/50" style="flex: 1; overflow: auto; padding: 1rem 1.5rem; border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem;">
                    <pre class="text-gray-800 dark:text-gray-200" style="margin: 0; font-size: 0.75rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; white-space: pre-wrap; word-break: break-word;">{{ $logContent }}</pre>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
