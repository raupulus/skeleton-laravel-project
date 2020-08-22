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

            {{-- Botones de Acción Sobre la tabla de contenidos --}}
            <div class="row">
                <div class="col-md-12">
                    <h3 id="title-content">
                        @if ($type->slug == 'all')
                            Viendo todos los tipos de contenidos
                        @else
                            Viendo los resultados por {{$type->name}}
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
                            'text' => $t->name,
                            'icon' => $t->icon,
                        ]) !!}
                    @endforeach
                </div>
            </div>

            {{-- Tabla con los resultados de contenidos --}}
            <div>
                <table id="panel-content-table"
                       class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
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
    <script src="{{ mix('assets/js/datatables.js') }}"></script>

    <script>
        var getContentUrl = "{{route('panel.content.filtered.get_json')}}";
        var typeSlug = "{{$type->slug}}";
        var dataTableTranslation = "{{route('datatable.translation')}}";

        var columnsContent = [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
        ];

        $(document).ready(() => {
            async function getContent() {
                console.log('entra');
                return await createDatatable(
                    'panel-content-table',
                    getContentUrl,
                    columnsContent,
                    {}
                );
            }

            // Al cargar por defecto cargo todos contenidos.
            var panelContentTable = getContent();

            // Cuando se completa la promesa añado eventos a botones de acción.
            $.when(panelContentTable).done((table) => {
                // Todos los Usuarios.
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

                    $('#title-content').text('Viendo los resultados por ' + "{{$t->name}}");
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
