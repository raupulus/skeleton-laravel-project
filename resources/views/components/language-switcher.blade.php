<div role="group" aria-label="{{ __('messages.language_switcher') }}" class="flex items-center space-x-1 text-sm">
    @foreach(config('locales.available', ['es', 'en']) as $locale)
        @php
            $isActive = app()->getLocale() === $locale;
            $label = $locale === 'es' ? 'Español' : ($locale === 'en' ? 'English' : strtoupper($locale));
        @endphp
        <a
            href="{{ route('language.switch', $locale) }}"
            hreflang="{{ $locale }}"
            lang="{{ $locale }}"
            aria-label="{{ $label }}"
            @if($isActive) aria-current="true" @endif
            class="px-2 py-1 rounded {{ $isActive ? 'bg-indigo-600 text-white font-semibold' : 'text-gray-600 hover:bg-gray-100' }}"
        >{{ strtoupper($locale) }}</a>
    @endforeach
</div>
