@extends('panel.layouts.app')

@section('title', 'Categorías')

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Contenido',
                'url' => route('panel.content.index'),
                'icon' => 'fas fa-file'
            ],
            [
                'title' => 'Categorías',
                'icon' => 'fas fa-file'
            ],
        ]
    ])

    <div class="row">
        <div class="col-12 m-5">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h1>Gestionar Categorías de Contenido</h1>
                </div>
            </div>

            <div class="row">

                {{-- Izquierda → Categorías --}}
                <div class="col-6">
                    {{-- Botones --}}
                    <div class="text-center">
                        <a href="#" class="btn btn-primary">
                            Crear categoría
                        </a>

                        <a href="#" class="btn btn-danger">
                            Eliminar categorías seleccionadas
                        </a>
                    </div>

                    {{-- Selector --}}
                    <div id="box-list-categories">
                        <div class="text-center mt-3 mb-3">
                            <h2>Listado de categorías</h2>
                        </div>
                    </div>
                </div>

                {{-- Derecha → Subcategorías --}}
                <div class="col-6">
                    {{-- Botones --}}
                    <div class="text-center">
                        <a href="#" class="btn btn-primary">
                            Añadir subcategoría
                        </a>

                        <a href="#" class="btn btn-danger">
                            Eliminar subcategorías seleccionadas
                        </a>
                    </div>

                    {{-- Selector --}}
                    <div id="box-list-subcategories">
                        <div class="text-center mt-3 mb-3">
                            <h2>Listado de subcategorías</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <style>
        #box-list-categories {
            border-right: 3px groove #000;
        }

        #box-list-subcategories {
            border-left: 3px groove #000;
        }
    </style>
@endsection

@section('js')

@endsection
