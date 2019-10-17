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
                'title' => 'Mostrar todos',
                'icon' => 'fas fa-list'
            ],
        ]
    ])

    {{-- Botones de Acción General --}}
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <a href="{{route('panel.users.add')}}" class="btn btn-success">
                <i class="fa fa-user-plus"></i>
                Añadir nuevo usuario
            </a>
        </div>
    </div>

    {{-- Tarjetas con resumen de usuarios --}}
    <div class="row">
        @widget('cardSeeDetailsWidget', [
            'title' => $n_users . ' Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'url' => '#',
            'color' => 'bg-primary'
        ])

        @widget('cardSeeDetailsWidget', [
            'title' => $n_users_this_month . ' Usuarios en 1 mes',
            'icon' => 'fas fa-fw fa-user-clock',
            'url' => '#',
            'color' => 'bg-success'
        ])

        @widget('cardSeeDetailsWidget', [
            'title' => $n_usersInactive . ' Usuarios Inactivos',
            'icon' => 'fas fa-fw fa-user-times',
            'url' => '#',
            'color' => 'bg-danger'
        ])

        @widget('cardSeeDetailsWidget', [
            'title' => 'nº Usuarios bloqueados',
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
        <table id="panel-users-table"
               class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Nick</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    {{-- Tabla de Usuarios Inactivos--}}
    <div>
        @foreach($usersInactive as $user)
            ̣{{$user->name}} - {{$user->nick}}
            <br />
        @endforeach
    </div>
@endsection

@section('css')
    <link href="{{ mix('assets/css/datatables.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ mix('assets/js/datatables.js') }}"></script>
    <script src="{{ mix('admin-panel/users/js/user_index.js') }}"></script>
@endsection


