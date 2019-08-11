@extends('panel.layouts.app')

@section('title', 'Error 500')

@section('content')
    @include('panel.layouts.breadcrumbs')
    <h1 class="display-1">500</h1>
    <p class="lead">Error de Servidor, si se repite contacte con el
        administrador. Puedes
        <a href="javascript:history.back()">volver</a>
        a la página anterior o ir al
        <a href="{{route('panel-index')}}">dashboard principal</a>.</p>
@endsection


