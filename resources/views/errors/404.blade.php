@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-24 text-center">
    <h1 class="text-6xl font-bold text-indigo-600">404</h1>
    <p class="mt-4 text-xl text-gray-600">{{ __('messages.error_404_title') }}</p>
    <a href="{{ route('home') }}" class="mt-8 inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">{{ __('messages.back_home') }}</a>
</div>
@endsection
