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
                'title' => 'Test 1',
                'url' => route('panel.index'),
                'icon' => 'fa fa-star'
            ],
            [
                'title' => 'Test 2',
                'url' => route('panel.index'),
            ],
        ]
    ])

    {{-- Botones de Acción General --}}
    <div class="row">
        <div class="col-12">
            <button class="btn btn-success">
                <i class="fa fa-user-plus"></i>
                Añadir nuevo usuario
            </button>
        </div>
    </div>

    {{-- Tarjetas con resumen de usuarios --}}
    <div class="row">
        @widget('cardSeeDetailsWidget', [
            'title' => 'n Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'url' => '#',
            'color' => 'bg-primary'
        ])

        @widget('cardSeeDetailsWidget', [
            'title' => 'n Usuarios nuevos este mes',
            'icon' => 'fas fa-fw fa-user-clock',
            'url' => '#',
            'color' => 'bg-success'
        ])

        @widget('cardSeeDetailsWidget', [
            'title' => 'n Usuarios eliminados este mes',
            'icon' => 'fas fa-fw fa-user-times',
            'url' => '#',
            'color' => 'bg-danger'
        ])

        @widget('cardSeeDetailsWidget', [
            'title' => 'n Usuarios bloqueados',
            'icon' => 'fas fa-fw fa-user-shield',
            'url' => '#',
            'color' => 'bg-warning'
        ])
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
