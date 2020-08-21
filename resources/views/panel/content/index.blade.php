@extends('panel.layouts.app')

@section('title', 'Panel Admin - Dashboard')
{{-- Descripción sobre esta página --}}
@section('title', 'Listando todos los ' . $type->name)
@section('description', 'Vista de todos los ' . $type->name)

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Contenido',
                'url' => route('panel.content.index'),
                'icon' => 'fas fa-file'
            ],
            [
                'title' => $type->name,
                'icon' => $type->icon
            ],
        ]
    ])

    <div class="row">
        <div class="col-12">
            CONTENIDO
        </div>
    </div>
@endsection
