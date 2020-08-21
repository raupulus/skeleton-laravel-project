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
            <ul>
                @foreach($contents as $content)
                    <li>{{$content->title}}</li>
                @endforeach
            </ul>

            {{-- Botones de Acción Sobre la tabla de contenidos --}}
            <div class="row">
                <div class="col-md-12">
                    <h3 id="title-users">
                        @if ($type->slug == 'all')
                            Viendo todos los tipos de contenidos
                        @else
                            Viendo los resultados de {{$type->name}}
                        @endif
                    </h3>
                </div>

                <div class="col-12 text-center">
                    {!! Buttom::generic('#', 'all-types', [
                        'class' => 'm-1 btn btn-panel btn-panel-selector ' . ($type->slug == 'all' ? 'btn-secondary disabled' : 'btn-primary'),
                        'text' => 'Todos',
                        'icon' => 'fa fa-file',
                    ]) !!}

                    @foreach($types as $t)
                        {!! Buttom::generic(route('panel.content.index', ['type_slug' => $t->slug]), $t->slug, [
                            'class' => 'm-1 btn btn-panel btn-panel-selector  ' . ($type->slug == $t->slug ? 'btn-secondary disabled' : 'btn-primary'),
                            'text' => $t->name,
                            'icon' => $t->icon,
                        ]) !!}
                    @endforeach
                </div>
            </div>

            {{-- Tabla con los resultados de contenidos --}}
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
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ mix('assets/css/datatables.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script>
        var panelUsersGetAllUrl = "{{route('panel.users.table.allusers')}}";
        var panelUsersGetThisMonth = "{{route('panel.users.table.thismonth')}}";
        var panelUsersGetActive = "{{route('panel.users.table.active')}}";
        var panelUsersGetInactive = "{{route('panel.users.table.inactive')}}";
        var dataTableTranslation = "{{route('datatable.translation')}}";
        var userColumns = [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'nick', name: 'nick' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action' }
        ];
    </script>
    <script src="{{ mix('assets/js/datatables.js') }}"></script>
    <script async src="{{ mix('admin-panel/users/js/user_index.js') }}"></script>
@endsection
