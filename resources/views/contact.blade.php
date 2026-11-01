@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">{{ __('messages.contact') }}</h1>
    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.contact_name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('name')<p id="name-error" role="alert" class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.contact_email') }}</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('email')<p id="email-error" role="alert" class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">{{ __('messages.contact_subject') }}</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required maxlength="255" @error('subject') aria-invalid="true" aria-describedby="subject-error" @enderror class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('subject')<p id="subject-error" role="alert" class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">{{ __('messages.contact_message') }}</label>
            <textarea name="message" id="message" rows="5" required maxlength="5000" @error('message') aria-invalid="true" aria-describedby="message-error" @enderror class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea>
            @error('message')<p id="message-error" role="alert" class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center">
            <input type="checkbox" name="privacy" id="privacy" value="1" required @error('privacy') aria-invalid="true" aria-describedby="privacy-error" @enderror class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="privacy" class="ml-2 text-sm text-gray-600">{{ __('messages.contact_privacy_accept') }} <a href="{{ route('privacy') }}" class="text-indigo-600 underline">{{ __('messages.contact_privacy_link') }}</a></label>
        </div>
        @error('privacy')<p id="privacy-error" role="alert" class="text-sm text-red-600">{{ $message }}</p>@enderror
        <x-recaptcha-script action="contact" />
        @error('g-recaptcha-response')<p role="alert" class="text-sm text-red-600">{{ $message }}</p>@enderror
        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition font-medium">{{ __('messages.contact_send') }}</button>
    </form>
</div>
@endsection
