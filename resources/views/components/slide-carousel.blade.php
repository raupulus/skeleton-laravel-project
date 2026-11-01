@props(['zone'])
@php $slides = \App\Models\Slide::forZone($zone)->get(); @endphp
@if($slides->count())
<div
    x-data="{
        active: 0,
        count: {{ $slides->count() }},
        tid: null,
        play() {
            this.stop();
            this.tid = setInterval(() => { this.active = (this.active + 1) % this.count; }, 5000);
        },
        stop() {
            clearInterval(this.tid);
            this.tid = null;
        },
        next() { this.active = (this.active + 1) % this.count; this.play(); },
        prev() { this.active = (this.active - 1 + this.count) % this.count; this.play(); },
        go(n)  { this.active = n; this.play(); }
    }"
    x-init="play()"
    @mouseenter="stop()"
    @mouseleave="play()"
    style="position:relative; width:100%; height:24rem; border-radius:0.75rem; overflow:hidden;"
>
    {{-- Diapositivas --}}
    @foreach($slides as $i => $slide)
    <div
        x-show="active === {{ $i }}"
        x-transition:enter="transition-opacity ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="position:absolute; inset:0;"
        @if($i === 0) x-show.initial @endif
    >
        <img
            src="{{ Storage::disk('public')->url($slide->image) }}"
            alt="{{ $slide->getTranslation('title', app()->getLocale()) ?: '' }}"
            style="width:100%; height:100%; object-fit:cover; display:block;"
        />
        @if($slide->getTranslation('title', app()->getLocale()))
        <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(0,0,0,.6),transparent); padding:1.5rem;">
            <h2 style="color:#fff; font-size:1.5rem; font-weight:700; margin:0;">
                {{ $slide->getTranslation('title', app()->getLocale()) }}
            </h2>
            @if($slide->getTranslation('content', app()->getLocale()))
            <p style="color:rgba(255,255,255,.9); font-size:.875rem; margin:.25rem 0 0;">
                {{ $slide->getTranslation('content', app()->getLocale()) }}
            </p>
            @endif
        </div>
        @endif
    </div>
    @endforeach

    {{-- Botón anterior --}}
    <button
        type="button"
        @click.prevent="prev()"
        style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); z-index:30;
               background:rgba(255,255,255,.85); border:none; border-radius:50%; width:2.5rem; height:2.5rem;
               display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 1px 4px rgba(0,0,0,.3);"
        aria-label="{{ __('messages.slide_prev') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </button>

    {{-- Botón siguiente --}}
    <button
        type="button"
        @click.prevent="next()"
        style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); z-index:30;
               background:rgba(255,255,255,.85); border:none; border-radius:50%; width:2.5rem; height:2.5rem;
               display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 1px 4px rgba(0,0,0,.3);"
        aria-label="{{ __('messages.slide_next') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>

    {{-- Indicadores de posición --}}
    @if($slides->count() > 1)
    <div style="position:absolute; bottom:0.75rem; left:0; right:0; z-index:30;
                display:flex; justify-content:center; gap:0.4rem; pointer-events:none;">
        @foreach($slides as $i => $slide)
        <button
            type="button"
            @click.prevent="go({{ $i }})"
            :style="active === {{ $i }}
                ? 'background:#fff; width:1rem;'
                : 'background:rgba(255,255,255,.5); width:0.5rem;'"
            style="height:0.5rem; border:none; border-radius:9999px; cursor:pointer;
                   transition:all .3s; pointer-events:auto;"
            aria-label="{{ __('messages.slide_go_to', ['n' => $i + 1]) }}"
        ></button>
        @endforeach
    </div>
    @endif
</div>
@endif

