<div class="px-3 py-2 border-b border-gray-100 dark:border-white/5">
    <p class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">
        {{ __('messages.language') }}
    </p>
    <div class="flex items-center gap-x-1">
        @foreach(config('locales.available', ['es', 'en']) as $locale)
            <a
                href="{{ route('language.switch', $locale) }}"
                class="flex-1 text-center px-2 py-1 rounded text-xs font-semibold uppercase transition
                    {{ app()->getLocale() === $locale
                        ? 'bg-primary-500 text-white shadow-sm'
                        : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 hover:text-gray-700 dark:hover:text-gray-200' }}"
            >{{ strtoupper($locale) }}</a>
        @endforeach
    </div>
</div>
