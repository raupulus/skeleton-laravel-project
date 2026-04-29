@foreach (['success', 'error', 'warning', 'info'] as $type)
    @if (session($type))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="max-w-4xl mx-auto mt-4 px-4">
            @php
                $classes = match($type) {
                    'success' => 'bg-green-100 text-green-800',
                    'error' => 'bg-red-100 text-red-800',
                    'warning' => 'bg-yellow-100 text-yellow-800',
                    'info' => 'bg-blue-100 text-blue-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <div class="p-4 rounded-lg {{ $classes }}">{{ session($type) }}</div>
        </div>
    @endif
@endforeach
