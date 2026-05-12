<x-filament-panels::page>
    <div style="display: flex; flex-direction: column; gap: 2rem;">

        {{-- Texto descriptivo --}}
        <div style="display: flex; align-items: flex-start; gap: 0.875rem; padding: 1.125rem 1.5rem; border-radius: 0.75rem; background: #eff6ff; border: 1px solid #bfdbfe;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3b82f6" style="width: 1.25rem; height: 1.25rem; flex-shrink: 0; margin-top: 0.125rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <p style="margin: 0; font-size: 0.875rem; color: #1e40af; line-height: 1.7;">
                {{ __('messages.api_tokens_description') }}
            </p>
        </div>

        {{-- Formulario de creación de token --}}
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 1rem; overflow: hidden;">
            <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid #f3f4f6;">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 600; color: #111827;">
                    {{ __('messages.api_tokens_create_title') }}
                </h3>
            </div>

            <div style="padding: 1.75rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="flex: 1;">
                        <input
                            type="text"
                            wire:model="tokenName"
                            wire:keydown.enter="createToken"
                            placeholder="{{ __('messages.api_tokens_placeholder') }}"
                            style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; padding: 0.625rem 1rem; font-size: 0.875rem; background: #ffffff; color: #111827; outline: none; transition: border-color 0.15s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 2px rgba(99,102,241,0.15)'"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                        />
                        @error('tokenName')
                            <p style="margin: 0.5rem 0 0; font-size: 0.8125rem; color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>
                    <x-filament::button wire:click="createToken" wire:loading.attr="disabled" icon="heroicon-m-plus">
                        <span wire:loading.remove wire:target="createToken">{{ __('messages.create') }}</span>
                        <span wire:loading wire:target="createToken">...</span>
                    </x-filament::button>
                </div>

                {{-- Token recién generado --}}
                @if($plainTextToken)
                    <div style="margin-top: 1.5rem; padding: 1.25rem; background: #f0fdf4; border-radius: 0.75rem; border: 1px solid #bbf7d0;">
                        <p style="margin: 0 0 0.75rem; font-size: 0.8125rem; font-weight: 600; color: #15803d;">
                            {{ __('messages.api_tokens_created_msg') }}
                        </p>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <button
                                onclick="navigator.clipboard.writeText('{{ $plainTextToken }}').then(() => { this.querySelector('span').textContent = '{{ __('messages.api_tokens_copied') }}'; setTimeout(() => { this.querySelector('span').textContent = '{{ __('messages.api_tokens_copy') }}'; }, 2000); })"
                                style="flex-shrink: 0; display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 0.875rem; font-size: 0.75rem; font-weight: 600; border-radius: 0.5rem; background: #16a34a; color: #ffffff; border: none; cursor: pointer;"
                                title="{{ __('messages.api_tokens_copy') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 0.875rem; height: 0.875rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9.75a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>
                                <span>{{ __('messages.api_tokens_copy') }}</span>
                            </button>
                            <code style="flex: 1; font-size: 0.8125rem; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; word-break: break-all; color: #14532d; user-select: all; background: #dcfce7; padding: 0.5rem 0.875rem; border-radius: 0.5rem;">{{ $plainTextToken }}</code>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Listado de tokens existentes --}}
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 1rem; overflow: hidden;">
            <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid #f3f4f6;">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 600; color: #111827;">
                    {{ __('messages.api_tokens_list_title') }}
                </h3>
            </div>

            @if($this->tokens->isEmpty())
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 2rem; text-align: center;">
                    <div style="display: flex; align-items: center; justify-content: center; width: 3.5rem; height: 3.5rem; border-radius: 50%; background: #f3f4f6; margin-bottom: 1.25rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9ca3af" style="width: 1.5rem; height: 1.5rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>
                    </div>
                    <p style="margin: 0; font-size: 0.9375rem; font-weight: 500; color: #6b7280;">
                        {{ __('messages.api_tokens_empty') }}
                    </p>
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: 1rem 1.75rem; text-align: left; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280;">
                                {{ __('messages.api_tokens_col_name') }}
                            </th>
                            <th style="padding: 1rem 1.75rem; text-align: left; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280;">
                                {{ __('messages.api_tokens_col_created') }}
                            </th>
                            <th style="padding: 1rem 1.75rem; text-align: left; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280;">
                                {{ __('messages.api_tokens_col_last_used') }}
                            </th>
                            <th style="padding: 1rem 1.75rem; text-align: left; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280;">
                                {{ __('messages.api_tokens_col_expires') }}
                            </th>
                            <th style="padding: 1rem 1.75rem; text-align: right; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280;">
                                {{ __('messages.api_tokens_col_actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->tokens as $index => $token)
                            <tr style="border-bottom: 1px solid #f3f4f6; background: {{ $index % 2 === 1 ? '#f9fafb' : '#ffffff' }};"
                                onmouseover="this.style.background='#f3f4f6'"
                                onmouseout="this.style.background='{{ $index % 2 === 1 ? '#f9fafb' : '#ffffff' }}'">

                                {{-- Nombre --}}
                                <td style="padding: 1.125rem 1.75rem;">
                                    <div style="display: flex; align-items: center; gap: 0.875rem;">
                                        <div style="display: flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; background: #eef2ff; flex-shrink: 0;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6366f1" style="width: 1rem; height: 1rem;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                            </svg>
                                        </div>
                                        <span style="font-weight: 600; font-size: 0.875rem; color: #111827;">{{ $token->name }}</span>
                                    </div>
                                </td>

                                {{-- Creado --}}
                                <td style="padding: 1.125rem 1.75rem; font-size: 0.8125rem; color: #4b5563; white-space: nowrap;">
                                    {{ $token->created_at->translatedFormat('d M Y, H:i') }}
                                </td>

                                {{-- Último uso --}}
                                <td style="padding: 1.125rem 1.75rem; font-size: 0.8125rem; white-space: nowrap;">
                                    @if($token->last_used_at)
                                        <span style="color: #4b5563;">{{ $token->last_used_at->translatedFormat('d M Y, H:i') }}</span>
                                    @else
                                        <span style="color: #9ca3af; font-style: italic;">{{ __('messages.api_tokens_never') }}</span>
                                    @endif
                                </td>

                                {{-- Expiración --}}
                                <td style="padding: 1.125rem 1.75rem; font-size: 0.8125rem; white-space: nowrap;">
                                    @if($token->expires_at)
                                        @if($token->expires_at->isPast())
                                            <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;">
                                                {{ $token->expires_at->translatedFormat('d M Y') }}
                                            </span>
                                        @else
                                            <span style="color: #4b5563;">{{ $token->expires_at->translatedFormat('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: #f3f4f6; color: #6b7280;">
                                            {{ __('messages.api_tokens_no_expiry') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td style="padding: 1.125rem 1.75rem; text-align: right;">
                                    <x-filament::icon-button
                                        color="danger"
                                        icon="heroicon-m-trash"
                                        size="sm"
                                        wire:click="deleteToken({{ $token->id }})"
                                        wire:confirm="{{ __('messages.api_tokens_delete_confirm') }}"
                                        wire:loading.attr="disabled"
                                        :tooltip="__('messages.delete')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Contador de tokens --}}
                <div style="padding: 1rem 1.75rem; border-top: 1px solid #f3f4f6; background: #f9fafb;">
                    <p style="margin: 0; font-size: 0.8125rem; color: #6b7280;">
                        {{ $this->tokens->count() }} {{ $this->tokens->count() === 1 ? 'token' : 'tokens' }}
                    </p>
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>
