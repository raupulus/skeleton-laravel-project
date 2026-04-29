@extends('mail.layouts.base')
@section('content')
<h2 style="color: #1f2937;">Nuevo mensaje de contacto</h2>
<p><strong>Nombre:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Asunto:</strong> {{ $data['subject'] }}</p>
<hr style="border: 1px solid #e5e7eb;">
<p>{{ $data['message'] }}</p>
@endsection
