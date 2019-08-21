@extends('panel.layouts.app')

@section('title', 'Panel Admin - Dashboard')

{{-- Descripción sobre esta página --}}
@section('title', 'Viendo usuario')
@section('description', 'Vista individual de usuario')

{{-- Marca el elemento del menú que se encuentra activo --}}
@section('active-index', 'active')

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Test 1',
                'url' => route('panel-index'),
                'icon' => 'fa fa-star'
            ],
            [
                'title' => 'Test 2',
                'url' => route('panel-index'),
            ],
        ]
    ])

    <div>

    </div>
@endsection
