@extends('layouts.app')
@section('content')
<article class="max-w-4xl mx-auto px-4 py-12">
    @if($post->image)<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->getTranslation('title', app()->getLocale()) }}" class="w-full h-64 md:h-96 object-cover rounded-xl mb-8" />@endif
    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->getTranslation('title', app()->getLocale()) }}</h1>
    <div class="flex items-center text-sm text-gray-500 mb-8 space-x-4">
        <span>{{ $post->user?->name }}</span>
        <span>{{ $post->published_at?->format('d/m/Y') }}</span>
        @foreach($post->categories as $cat)<span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">{{ $cat->getTranslation('name', app()->getLocale()) }}</span>@endforeach
    </div>
    <div class="prose max-w-none">{!! $post->getTranslation('content', app()->getLocale()) !!}</div>
    <div class="mt-12"><a href="{{ route('blog.index') }}" class="text-indigo-600 hover:underline">&larr; {{ __('messages.back') }}</a></div>
</article>
@endsection
