@extends('mail.layouts.base')
@section('content')
<h2 style="color: #1f2937;">¡Bienvenido, {{ $user->name }}!</h2>
<p>Gracias por registrarte en {{ setting('site_title', config('app.name')) }}.</p>
<p>Tu cuenta ha sido creada correctamente. Puedes acceder al panel de usuario desde nuestra web.</p>
@endsection
