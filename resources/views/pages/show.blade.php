@extends('layouts.app')
@section('content')
<article class="max-w-4xl mx-auto px-4 py-12">
    @if($page->image)<img src="{{ Storage::disk('public')->url($page->image) }}" alt="{{ $page->getTranslation('title', app()->getLocale()) }}" width="1200" height="675" fetchpriority="high" decoding="async" class="w-full h-64 md:h-96 object-cover rounded-xl mb-8" />@endif
    <h1 class="text-4xl font-bold text-gray-800 mb-6">{{ $page->getTranslation('title', app()->getLocale()) }}</h1>
    <div class="prose max-w-none">{!! $page->getTranslation('content', app()->getLocale()) !!}</div>
</article>
@endsection
