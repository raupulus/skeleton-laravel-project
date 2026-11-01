@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('messages.privacy') }}</h1>

    @forelse ($sections as $section)
        <x-section-block :block="$section" />
    @empty
        <div class="prose max-w-none text-gray-600">
            <p>{{ __('messages.privacy_default_text') }}</p>
        </div>
    @endforelse
</div>
@endsection
