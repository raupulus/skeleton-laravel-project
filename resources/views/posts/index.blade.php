@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">{{ __('messages.blog') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <p class="text-gray-500 col-span-3">{{ __('messages.no_results') }}</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection
