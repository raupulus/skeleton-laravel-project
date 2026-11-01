@foreach (['success', 'error', 'warning', 'info'] as $type)
    @if (session($type))
        @php
            $classes = match($type) {
                'success' => 'bg-green-100 text-green-800 border-green-200',
                'error' => 'bg-red-100 text-red-800 border-red-200',
                'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'info' => 'bg-blue-100 text-blue-800 border-blue-200',
                default => 'bg-gray-100 text-gray-800 border-gray-200',
            };
            $role = in_array($type, ['error', 'warning'], true) ? 'alert' : 'status';
        @endphp
        <div
            x-data="{
                show: true,
                tid: null,
                startTimer() {
                    this.clearTimer();
                    this.tid = setTimeout(() => { this.show = false; }, 8000);
                },
                clearTimer() {
                    if (this.tid) clearTimeout(this.tid);
                }
            }"
            x-init="startTimer()"
            @mouseenter="clearTimer()"
            @mouseleave="startTimer()"
            @focusin="clearTimer()"
            @focusout="startTimer()"
            x-show="show"
            role="{{ $role }}"
            class="max-w-4xl mx-auto mt-4 px-4"
        >
            <div class="p-4 rounded-lg border flex items-center justify-between gap-4 {{ $classes }}">
                <span>{{ session($type) }}</span>
                <button
                    type="button"
                    @click="show = false"
                    aria-label="{{ __('messages.close') }}"
                    class="p-1 rounded hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-current"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
@endforeach
