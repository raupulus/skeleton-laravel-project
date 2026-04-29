@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-24 text-center">
    <h1 class="text-6xl font-bold text-red-600">500</h1>
    <p class="mt-4 text-xl text-gray-600">Error interno del servidor</p>
    <a href="{{ route('home') }}" class="mt-8 inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Volver al inicio</a>
</div>
@endsection
