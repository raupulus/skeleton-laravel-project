@extends('mail.layouts.base')
@section('content')
<h2 style="color: #1f2937;">{{ __('messages.mail_contact_heading') }}</h2>
<p><strong>{{ __('messages.contact_name') }}:</strong> {{ $data['name'] }}</p>
<p><strong>{{ __('messages.contact_email') }}:</strong> {{ $data['email'] }}</p>
<p><strong>{{ __('messages.contact_subject') }}:</strong> {{ $data['subject'] }}</p>
<hr style="border: 1px solid #e5e7eb;">
<p>{{ $data['message'] }}</p>
@endsection
