@extends('panel.layouts.app')

{{-- Descripción sobre esta página --}}
@section('title', 'Viendo usuarios')
@section('description', 'Vista de todos los usuarios')

{{-- Marca el elemento del menú que se encuentra activo --}}
@section('active-index', 'active')

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Usuarios',
                'url' => route('panel.users.index'),
                'icon' => 'fas fa-users'
            ],
            [
                'title' => 'Crear Usuario',
                'icon' => 'fas fa-plus'
            ],
        ]
    ])

    {{-- Botones de Acción General --}}
    <div class="row">
        <div class="col-12">
            {{--
            <button class="btn btn-success">
                <i class="fa fa-user-plus"></i>
                Añadir nuevo usuario
            </button>
            --}}
        </div>
    </div>

    {{-- Botones de Acción Sobre la tabla de usuarios --}}
    <div class="row">
        <div class="col-12">

        </div>
    </div>

    {{-- Tabla de Usuarios --}}
    <div>

    </div>
@endsection
