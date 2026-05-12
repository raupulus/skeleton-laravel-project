@php
    $log = $this->getLatestLog();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        @if($log['exists'])
            <x-filament::button
                color="warning"
                icon="heroicon-o-arrow-down-tray"
                tag="a"
                :href="route('admin.logs.download', $log['name'])"
                :tooltip="__('filament.view_logs_download')"
            />
        @endif

        <div class="fi-account-widget-main">
            <h2 class="fi-account-widget-heading">
                {{ __('filament.download_error_log') }}
            </h2>

            <p class="fi-account-widget-user-name">
                @if($log['exists'])
                    {{ $log['size'] }}
                @else
                    {{ __('filament.view_logs_empty') }}
                @endif
            </p>
        </div>

        <x-filament::button
            color="gray"
            icon="heroicon-o-document-magnifying-glass"
            labeled-from="sm"
            tag="a"
            :href="route('filament.admin.pages.view-logs')"
        >
            {{ __('filament.view_logs') }}
        </x-filament::button>
    </x-filament::section>
</x-filament-widgets::widget>
