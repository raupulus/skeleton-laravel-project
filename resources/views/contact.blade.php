@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">{{ __('messages.contact') }}</h1>
    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">{{ __('Asunto') }}</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">{{ __('Mensaje') }}</label>
            <textarea name="message" id="message" rows="5" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea>
            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center">
            <input type="checkbox" name="privacy" id="privacy" required class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="privacy" class="ml-2 text-sm text-gray-600">Acepto la <a href="{{ route('pages.show', 'politica-privacidad') }}" class="text-indigo-600 underline">política de privacidad</a></label>
        </div>
        @error('privacy')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition font-medium">{{ __('Enviar mensaje') }}</button>
    </form>
</div>
@endsection
