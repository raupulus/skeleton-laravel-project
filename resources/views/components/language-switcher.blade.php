<div class="flex items-center space-x-1 text-sm">
    @foreach(config('locales.available', ['es', 'en']) as $locale)
        <a href="{{ route('language.switch', $locale) }}" class="px-2 py-1 rounded {{ app()->getLocale() === $locale ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">{{ strtoupper($locale) }}</a>
    @endforeach
</div>
