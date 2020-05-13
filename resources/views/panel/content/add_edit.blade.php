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
            {{isset($content_id) && $content_id ? 'Añadir' : 'Editar' . ' Contenido'}}
        </h1>
    </div>

    {{-- Botones de Acción General --}}
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <button type="submit"
                    class="btn btn-success"
                    form="form-add-user">
                <i class="fa fa-file-export"></i>
                Guardar
            </button>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-md-8">
            @include('panel.content.forms.add_edit._fields')
            @include('panel.content.forms.add_edit._seo')
        </div>

        <div class="col-md-4">
            @include('panel.content.forms.add_edit._contributors')
            @include('panel.content.forms.add_edit._status')
            @include('panel.content.forms.add_edit._subcategories')
            @include('panel.content.forms.add_edit._tags')
        </div>
    </div>
@endsection

@section('js')
    {{--
    <script src="{{ mix('admin-panel/users/js/user_add.js') }}"></script>
    --}}
@endsection
