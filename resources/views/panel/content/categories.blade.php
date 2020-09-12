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
                <div class="col-lg-6">
                    {{-- Selector --}}
                    <div id="box-list-categories">
                        <div class="text-center mt-3 mb-3">
                            <h2>Listado de categorías</h2>
                        </div>

                        {{-- Botones --}}
                        <div class="text-center mb-3">
                            <button class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modal-category-add">
                                Crear categoría
                            </button>

                            <a href="#" class="btn btn-danger">
                                Eliminar categorías seleccionadas
                            </a>
                        </div>

                        <div>
                            <table class="table table-dark table-condensed table-borderless">
                                <tr>
                                    <th class="text-center">Subcategorías</th>
                                    <th class="text-center">Categorías</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="text-center align-middle">
                                        {{$category->subcategories->count()}}
                                    </td>

                                    <td class="text-center align-middle">
                                        {{ $category->name }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button class="btn btn-info m-1">
                                            Subcategorías
                                        </button>

                                        <button class="btn btn-primary m-1">
                                            Editar
                                        </button>

                                        <button class="btn btn-danger m-1">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Derecha → Subcategorías --}}
                <div class="col-lg-6">
                    <div class="text-center mt-3 mb-3">
                        <h2>Listado de subcategorías</h2>
                    </div>

                    {{-- Botones --}}
                    <div class="text-center mb-3">
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

        }

        #box-list-subcategories {

        }
    </style>
@endsection

@section('modal')
    @include('panel.content.modals.modal_category_add')
@endsection

@section('js')

@endsection
