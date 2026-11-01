<footer class="bg-gray-800 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h2 class="text-white text-lg font-semibold mb-4">{{ setting('site_title', config('app.name')) }}</h2>
                <p class="text-sm">{{ setting('site_description', '') }}</p>
            </div>
            <div>
                <h2 class="text-white text-lg font-semibold mb-4">{{ __('messages.footer_links') }}</h2>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white">{{ __('messages.about') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">{{ __('messages.contact') }}</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white">{{ __('messages.privacy') }}</a></li>
                    <li><a href="{{ route('cookies') }}" class="hover:text-white">{{ __('messages.cookies') }}</a></li>
                    <li><a href="{{ route('pages.show', 'terms') }}" class="hover:text-white">{{ __('messages.terms') }}</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-white text-lg font-semibold mb-4">{{ __('messages.footer_social') }}</h2>
                <div class="flex flex-wrap gap-4">
                    @if(setting('facebook_url'))<a href="{{ setting('facebook_url') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white">Facebook</a>@endif
                    @if(setting('twitter_url'))<a href="{{ setting('twitter_url') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white">Twitter</a>@endif
                    @if(setting('instagram_url'))<a href="{{ setting('instagram_url') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white">Instagram</a>@endif
                    @if(setting('linkedin_url'))<a href="{{ setting('linkedin_url') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white">LinkedIn</a>@endif
                    @if(setting('github_url'))<a href="{{ setting('github_url') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white">GitHub</a>@endif
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ setting('site_title', config('app.name')) }}. {{ __('messages.all_rights_reserved') }}.</p>
        </div>
    </div>
</footer>
