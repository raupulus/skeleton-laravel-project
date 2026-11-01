@extends('mail.layouts.base')
@section('content')
<h2 style="color: #1f2937;">{{ __('messages.mail_welcome_greeting', ['name' => $user->name]) }}</h2>
<p>{{ __('messages.mail_welcome_thanks', ['site' => setting('site_title', config('app.name'))]) }}</p>
<p>{{ __('messages.mail_welcome_body') }}</p>
@endsection
