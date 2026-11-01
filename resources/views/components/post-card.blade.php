@props(['post'])
<article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
    @if($post->image)<img src="{{ Storage::disk('public')->url($post->image) }}" alt="{{ $post->getTranslation('title', app()->getLocale()) }}" class="w-full h-48 object-cover" />@endif
    <div class="p-6">
        <div class="flex flex-wrap gap-2 mb-2">
            @foreach($post->categories as $cat)<span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">{{ $cat->getTranslation('name', app()->getLocale()) }}</span>@endforeach
        </div>
        <h3 class="text-lg font-semibold mb-2"><a href="{{ route('blog.show', $post->slug) }}" class="hover:text-indigo-600">{{ $post->getTranslation('title', app()->getLocale()) }}</a></h3>
        <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($post->getTranslation('excerpt', app()->getLocale()) ?: $post->getTranslation('content', app()->getLocale())), 120) }}</p>
        <div class="flex justify-between items-center text-xs text-gray-500">
            <span>{{ $post->published_at?->format('d/m/Y') }}</span>
            <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-600 hover:underline">{{ __('messages.read_more') }} &rarr;</a>
        </div>
    </div>
</article>
