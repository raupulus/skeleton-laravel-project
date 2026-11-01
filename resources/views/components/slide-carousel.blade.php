@props(['zone', 'slides' => null])
@php
    $slides = $slides ?? \App\Models\Slide::forZone($zone)->get();
@endphp
@if($slides->count())
<section
    role="region"
    aria-roledescription="carousel"
    aria-label="{{ __('messages.carousel_label') }}"
    x-data="{
        active: 0,
        count: {{ $slides->count() }},
        tid: null,
        paused: false,
        play() {
            if (this.paused || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            this.stop();
            this.tid = setInterval(() => { this.active = (this.active + 1) % this.count; }, 5000);
        },
        stop() {
            clearInterval(this.tid);
            this.tid = null;
        },
        togglePause() {
            this.paused = !this.paused;
            if (this.paused) {
                this.stop();
            } else {
                this.play();
            }
        },
        next() { this.active = (this.active + 1) % this.count; if (!this.paused) this.play(); },
        prev() { this.active = (this.active - 1 + this.count) % this.count; if (!this.paused) this.play(); },
        go(n)  { this.active = n; if (!this.paused) this.play(); }
    }"
    x-init="play()"
    @mouseenter="stop()"
    @mouseleave="play()"
    @focusin="stop()"
    @focusout="play()"
    @keydown.arrow-left.prevent="prev()"
    @keydown.arrow-right.prevent="next()"
    class="relative w-full h-96 rounded-xl overflow-hidden"
>
    {{-- Diapositivas --}}
    @foreach($slides as $i => $slide)
    <div
        role="group"
        aria-roledescription="slide"
        aria-label="{{ $i + 1 }} / {{ $slides->count() }}"
        x-show="active === {{ $i }}"
        @if($i !== 0) x-cloak @endif
        x-transition:enter="transition-opacity ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0"
    >
        @if($slide->image_vertical)
            <picture>
                <source media="(max-width: 767px)" srcset="{{ Storage::disk('public')->url($slide->image_vertical) }}">
                <img
                    src="{{ Storage::disk('public')->url($slide->image) }}"
                    alt="{{ $slide->getTranslation('title', app()->getLocale()) ?: '' }}"
                    width="1200"
                    height="675"
                    @if($i === 0) fetchpriority="high" decoding="async" @else loading="lazy" decoding="async" @endif
                    class="w-full h-full object-cover block"
                />
            </picture>
        @else
            <img
                src="{{ Storage::disk('public')->url($slide->image) }}"
                alt="{{ $slide->getTranslation('title', app()->getLocale()) ?: '' }}"
                width="1200"
                height="675"
                @if($i === 0) fetchpriority="high" decoding="async" @else loading="lazy" decoding="async" @endif
                class="w-full h-full object-cover block"
            />
        @endif
        @if($slide->getTranslation('title', app()->getLocale()))
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/75 via-black/40 to-transparent p-6 pb-12">
            <h2 class="text-white text-2xl font-bold m-0">
                {{ $slide->getTranslation('title', app()->getLocale()) }}
            </h2>
            @if($slide->getTranslation('content', app()->getLocale()))
            <p class="text-white/90 text-sm mt-1 mb-0">
                {{ $slide->getTranslation('content', app()->getLocale()) }}
            </p>
            @endif
        </div>
        @endif
    </div>
    @endforeach

    @if($slides->count() > 1)
    {{-- Botón pausa / reproducir (WCAG 2.2.2) --}}
    <button
        type="button"
        @click.prevent="togglePause()"
        :aria-label="paused ? '{{ __('messages.slide_play') }}' : '{{ __('messages.slide_pause') }}'"
        :aria-pressed="paused.toString()"
        class="absolute top-3 right-3 z-30 bg-white/90 hover:bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow focus:outline-none focus:ring-2 focus:ring-indigo-500"
    >
        <svg x-show="!paused" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <rect x="6" y="4" width="4" height="16" rx="1"></rect>
            <rect x="14" y="4" width="4" height="16" rx="1"></rect>
        </svg>
        <svg x-cloak x-show="paused" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <polygon points="5 3 19 12 5 21 5 3"></polygon>
        </svg>
    </button>

    {{-- Botón anterior --}}
    <button
        type="button"
        @click.prevent="prev()"
        class="absolute left-3 top-1/2 -translate-y-1/2 z-30 bg-white/90 hover:bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow focus:outline-none focus:ring-2 focus:ring-indigo-500"
        aria-label="{{ __('messages.slide_prev') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </button>

    {{-- Botón siguiente --}}
    <button
        type="button"
        @click.prevent="next()"
        class="absolute right-3 top-1/2 -translate-y-1/2 z-30 bg-white/90 hover:bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow focus:outline-none focus:ring-2 focus:ring-indigo-500"
        aria-label="{{ __('messages.slide_next') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>

    {{-- Indicadores de posición --}}
    <div class="absolute bottom-3 left-0 right-0 z-30 flex justify-center gap-2 pointer-events-none">
        @foreach($slides as $i => $slide)
        <button
            type="button"
            @click.prevent="go({{ $i }})"
            :aria-current="active === {{ $i }} ? 'true' : 'false'"
            :class="active === {{ $i }} ? 'bg-white w-5' : 'bg-white/60 w-2.5'"
            class="h-2.5 rounded-full transition-all duration-300 pointer-events-auto focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-label="{{ __('messages.slide_go_to', ['n' => $i + 1]) }}"
        ></button>
        @endforeach
    </div>
    @endif
</section>
@endif

