@extends('panel.layouts.app')

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

            {{-- Botones de Acción Sobre la tabla de contenidos --}}
            <div class="row">
                <div class="col-md-12">
                    <h3 id="title-content">
                        @if ($type->slug == 'all')
                            Viendo todos los tipos de contenidos
                        @else
                            Viendo los resultados por {{$type->plural_name}}
                        @endif
                    </h3>
                </div>

                <div class="col-12 text-center">
                    {!! Buttom::generic(route('panel.content.index'), 'all-types', [
                        'class' => 'm-1 btn btn-panel btn-panel-selector ' . ($type->slug == 'all' ? 'btn-secondary disabled' : 'btn-primary'),
                        'text' => 'Todos',
                        'icon' => 'fa fa-file',
                    ]) !!}

                    @foreach($types as $t)
                        {!! Buttom::generic(route('panel.content.index', ['type_slug' => $t->slug]), $t->slug, [
                            'class' => 'm-1 btn btn-panel btn-panel-selector  ' . ($type->slug == $t->slug ? 'btn-secondary disabled' : 'btn-primary'),
                            'text' => $t->plural_name,
                            'icon' => $t->icon,
                        ]) !!}
                    @endforeach
                </div>
            </div>

            {{-- Tabla con los resultados de contenidos --}}
            <div>
                <table id="panel-content-table"
                       class="table table-striped table-bordered">
                    {{--
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Imagen</th>
                        <th>Estado</th>
                        <th>Autor</th>
                        <th>Título</th>
                        <th>Tipo de Contenido</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    --}}
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ mix('assets/css/datatables.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ mix('assets/js/datatables.js') }}"></script>

    <script>
        var getContentUrl = "{{route('panel.content.filtered.get_json')}}";

        @if ($type->slug == 'all')
            var getContentUrlOnInit = "{{route('panel.content.filtered.get_json')}}";
        @else
            var getContentUrlOnInit = "{{route('panel.content.filtered.get_json', ['type_slug' => $type->slug])}}";
        @endif

        var typeSlug = "{{$type->slug}}";
        var dataTableTranslation = "{{route('datatable.translation')}}";

        var datatablesColumns = [
            { data: 'title', name: 'title', title: 'Título', width: "300px" },
            { data: 'id', name: 'id' , title: 'ID', width: "20px", class: "text-center"},
            {
                data: 'urlImage',
                name: 'urlImage',
                render: function (data, type, full, meta) {
                    return "<img src=\"" + data + "\" height=\"80\"" + "alt=\"Imagen de portada\"/>";
                },
                title: "Imagen",
                width: "80px",
                class: "text-center",
                orderable: false,
                searchable: false
            },
            { data: 'user.name', name: 'user.name', title: 'Autor', width: "100px" },
            {
                data: 'type.name',
                name: 'type.name',
                title: 'Tipo de Contenido',
                width: "50px",
                class: "text-center"
            },
            {
                data: 'status.name',
                name: 'status.name',
                title: 'Estado',
                width: "60px",
                class: "text-center"
            },
            {
                data: 'action',
                name: 'action',
                title: 'Acciones',
                width: "150px",
                class: "text-center"
            },
        ];

        var datatableOptions = {};

        $(document).ready(() => {
            async function getContent() {
                return await createDatatable(
                    'panel-content-table',
                    getContentUrlOnInit,
                    datatablesColumns,
                    datatableOptions
                );
            }

            // Al cargar por defecto cargo todos contenidos.
            var panelContentTable = getContent();

            // Cuando se completa la promesa añado eventos a botones de acción.
            $.when(panelContentTable).done((table) => {
                // Todos los contenidos.
                $('a[data-name="all-types"]').click(function(e) {
                    e.preventDefault();
                    table.ajax.url(getContentUrl).load();

                    $('#title-content').text('Viendo todos los contenidos');
                });

                @foreach($types as $t)
                    $('a[data-name="{{$t->slug}}"]').click(function(e) {
                        e.preventDefault();
                        console.log(getContentUrl + '/' + "{{$t->slug}}");
                        table.ajax.url(getContentUrl + '/' + "{{$t->slug}}").load();

                        $('#title-content').text('Viendo los resultados por ' + "{{$t->plural_name}}");
                    });
                @endforeach
            });

            // Desactivo el botón al ser pulsado y marco los demás como activos.
            $('.btn-panel-selector').click(function() {
                $('.btn-panel-selector').removeClass('disabled btn-secondary');
                $('.btn-panel-selector').addClass('btn-primary');
                $(this).addClass('disabled btn-secondary');
                $(this).removeClass('btn-primary');
            });
        });
    </script>
@endsection
