@extends('layouts.app')
@section('content')
<article class="max-w-4xl mx-auto px-4 py-12">
    @if($post->image)<img src="{{ Storage::disk('public')->url($post->image) }}" alt="{{ $post->getTranslation('title', app()->getLocale()) }}" width="1200" height="675" fetchpriority="high" decoding="async" class="w-full h-64 md:h-96 object-cover rounded-xl mb-8" />@endif
    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->getTranslation('title', app()->getLocale()) }}</h1>
    <div class="flex flex-wrap items-center text-sm text-gray-600 mb-8 gap-4">
        @if($post->user)<span>{{ $post->user->name }}</span>@endif
        @if($post->published_at)<time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('d/m/Y') }}</time>@endif
        @foreach($post->categories as $cat)<span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">{{ $cat->getTranslation('name', app()->getLocale()) }}</span>@endforeach
    </div>
    <div class="prose max-w-none">{!! $post->getTranslation('content', app()->getLocale()) !!}</div>
    <div class="mt-12"><a href="{{ route('blog.index') }}" class="text-indigo-600 hover:underline"><span aria-hidden="true">&larr;</span> {{ __('messages.back') }}</a></div>
</article>
@endsection
