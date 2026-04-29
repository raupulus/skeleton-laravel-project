@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">{{ __('messages.about') }}</h1>
    @foreach($sections as $section)
        <x-section-block :block="$section" />
    @endforeach
</div>
@endsection
