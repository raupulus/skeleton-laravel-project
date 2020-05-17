@extends('panel.layouts.app')

{{-- Descripción sobre esta página --}}
@section('title', isset($content_id) && $content_id ? 'Añadir' : 'Editar' . 'Contenido')
@section('description', 'Vista de todos los usuarios')

{{-- Marca el elemento del menú que se encuentra activo --}}
@section('active-index', 'active')

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Contenido',
                'url' => route('panel.content.index'),
                'icon' => 'fas fa-file'
            ],
            [
                'title' => isset($content_id) && $content_id ? 'Editando Contenido' : 'Crear Contenido',
                'icon' => 'fas ' . (isset($content_id) && $content_id ? 'fa-edit' : 'fa-plus')
            ],
        ]
    ])

    <div class="col-12">
        <h1 class="text-center">
            {{isset($content->id) && $content->id ? 'Añadir' : 'Editar' . ' Contenido'}}
        </h1>
    </div>

    {{-- Botones de Acción General --}}
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <nav class="nav nav-pills nav-justified">
                <a class="nav-item nav-link active"
                   href="#">
                    Contenido
                </a>

                <a class="nav-item nav-link"
                   href="#">
                    Previsualizar
                </a>

                <a class="nav-item nav-link disabled"
                   href="#">
                    SEO
                </a>
            </nav>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-md-8">
            <form id="form-content"
                  enctype="multipart/form-data"
                  action="#"
                  method="post"
                  class="">
                @csrf
                @include('panel.content.forms.add_edit._fields')
            </form>

            <hr />

            <form id="form-seo"
                  action="#"
                  method="post"
                  class="">
                @csrf
                @include('panel.content.forms.add_edit._seo')
            </form>
        </div>

        <div class="col-md-4 content-panel-right">
            <div class="text-center">
                {!!
                    FormHelper::submit('Guardar', 'fa fa-file-export', [
                        'form' => 'form-add-user',
                    ])
                !!}

                <button class="btn btn-success">
                    <i class="fa fa-file"></i>
                    Publicar
                </button>

                <button class="btn btn-warning">
                    <i class="fa fa-clock"></i>
                    Programar
                </button>
            </div>

            <form id="form-contributors"
                  action="#"
                  method="post"
                  class="">
                @csrf
                @include('panel.content.forms.add_edit._contributors')
            </form>

            <hr />

            <form id="form-status"
                  action="#"
                  method="post"
                  class="">
                @csrf
                @include('panel.content.forms.add_edit._status')
            </form>

            <hr />

            <form id="form-subcategories"
                  action="#"
                  method="post"
                  class="">
                @csrf
                @include('panel.content.forms.add_edit._subcategories')
            </form>

            <hr />

            <form id="form-tags"
                  action="#"
                  method="post"
                  class="">
                @csrf
                @include('panel.content.forms.add_edit._tags')
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ mix('admin-panel/content/js/content_add.js') }}"></script>
@endsection
