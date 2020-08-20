@extends('panel.layouts.app')

{{-- Descripción sobre esta página --}}
@section('title', isset($content_id) && $content_id ? 'Añadir ' . $type->name : 'Editar ' . $type->name)
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
                'title' => isset($content_id) && $content_id ?
                           'Editando ' . $type->name :
                           'Crear ' . $type->name,
                'icon' => 'fas ' . (isset($content_id) && $content_id ? 'fa-edit' : 'fa-plus')
            ],
        ]
    ])

    <div class="col-12">
        <h1 class="text-center">
            {{isset($content->id) && $content->id ? 'Editar ' . $type->name : 'Crear ' . $type->name}}
        </h1>

        <br />

        <p class="text-center">
            <i class="fa {{$type->icon}}" style="color: {{$type->color}}"></i>
            {{$type->description}}
        </p>
    </div>

    {{-- Menú de navegación entre secciones --}}
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <nav class="nav nav-pills nav-justified" role="tablist">
                <a class="nav-item nav-link active"
                   data-toggle="pill"
                   id="link-form-content"
                   role="tab"
                   aria-controls="box-form-content"
                   aria-selected="true"
                   href="#box-form-content">
                    Contenido
                </a>

                {{--
                <a class="nav-item nav-link"
                   data-toggle="pill"
                   id="link-form-preview"
                   role="tab"
                   aria-controls="box-form-preview"
                   aria-selected="false"
                   href="#box-form-preview">
                    Previsualizar
                </a>
                --}}

                <a class="nav-item nav-link"
                   data-toggle="pill"
                   id="link-form-seo"
                   role="tab"
                   aria-controls="box-form-seo"
                   aria-selected="false"
                   href="#box-form-seo">
                    SEO
                </a>
            </nav>
        </div>
    </div>

    {{-- Formulario --}}
    <form id="form-content"
          enctype="multipart/form-data"
          action="{{route('panel.content.store')}}"
          method="post"
          class="">
        @csrf

        {{-- Almacena el id del contenido si existiera --}}
        <input name="content_id"
               type="hidden"
               value="{{isset($content->id) ?? $content->id}}" />

        {{-- Almacena el tipo de contenido a editar o crear --}}
        <input name="type_id"
               type="hidden"
               value="{{isset($type) ?? $type->id}}" />

        <div class="row">
            <div class="col-md-8 tab-content">
                <div id="box-form-content"
                     class="col-md-12 tab-pane fade show active"
                     role="tabpanel"
                     aria-labelledby="link-form-content">

                        @include('panel.content.forms.add_edit._fields')

                </div>

                {{--
                <div id="box-form-preview"
                     class="col-md-12 tab-pane fade"
                     role="tabpanel"
                     aria-labelledby="link-form-preview">
                    <!-- Viewer Using Editor -->
                    <h2>Viewer</h2>
                    <v-toast-viewer content="
    # Prueba del visor
    ---
    ## Subtítulo de prueba"
                    ></v-toast-viewer>
                </div>
                --}}

                <div id="box-form-seo"
                     class="col-md-12 tab-pane fade"
                     role="tabpanel"
                     aria-labelledby="link-form-seo">
                        @include('panel.content.forms.add_edit._seo')
                </div>
            </div>

            <div class="col-md-4 content-panel-right">
                {{-- Botones de Acción General --}}
                <div class="text-center mt-5 mb-5">
                    {!!
                        FormHelper::submit('Guardar', 'fa fa-file-export', [
                        ])
                    !!}

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

                @include('panel.content.forms.add_edit._status')

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

                {{-- Contenido Relacionado --}}
                <form id="form-tags"
                      action="#"
                      method="post"
                      class="">
                    @csrf
                    @include('panel.content.forms.add_edit._related_content')
                </form>

                {{-- Campos para enviar contenido al guardar --}}
                <div class="col-md-12 mt-4">
                    <h2>Enviar Publicación al Guardar</h2>
                    <input type="checkbox" class="form-check form-inline">
                    <h3>Enviar por Telegram</h3>
                    <br />
                    <br />

                    <input type="checkbox" class="form-check">
                    <h3>Enviar por Email</h3>
                    <br />
                    <br />

                    <input type="checkbox" class="form-check">
                    <h3>Enviar por Twitter</h3>
                    <br />
                    <br />
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script src="{{ mix('admin-panel/content/js/content_add.js') }}"></script>

    {{-- Editor Gutenberg --}}
    @include('panel.content.layouts._edit_gutenberg_assets')
    <script>
        document.addEventListener('DOMContentLoaded',  () => {
            Laraberg.init('form-addedit-body', {
                // https://github.com/VanOns/laraberg#configuration-options
                sidebar: false,
                //laravelFilemanager: true,
                laravelFilemanager: {
                    prefix: '/filemanager?type=posts&no\\',
                    type: 'posts'
                },
                minHeight: '500px',
            });
        })
    </script>
@endsection
