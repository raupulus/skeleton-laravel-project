@props(['post'])
@php
    $postTitle = $post->getTranslation('title', app()->getLocale());
@endphp
<article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
    @if($post->image)<img src="{{ Storage::disk('public')->url($post->image) }}" alt="{{ $postTitle }}" loading="lazy" decoding="async" width="800" height="450" class="w-full h-48 object-cover" />@endif
    <div class="p-6">
        <div class="flex flex-wrap gap-2 mb-2">
            @foreach($post->categories as $cat)<span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">{{ $cat->getTranslation('name', app()->getLocale()) }}</span>@endforeach
        </div>
        <h2 class="text-lg font-semibold mb-2"><a href="{{ route('blog.show', $post->slug) }}" class="hover:text-indigo-600">{{ $postTitle }}</a></h2>
        <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($post->getTranslation('excerpt', app()->getLocale()) ?: $post->getTranslation('content', app()->getLocale())), 120) }}</p>
        <div class="flex justify-between items-center text-xs text-gray-600">
            @if($post->published_at)
                <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('d/m/Y') }}</time>
            @else
                <span></span>
            @endif
            <a href="{{ route('blog.show', $post->slug) }}" aria-label="{{ __('messages.read_more') }}: {{ $postTitle }}" class="text-indigo-600 hover:underline">{{ __('messages.read_more') }} <span aria-hidden="true">&rarr;</span></a>
        </div>
    </div>
</article>
