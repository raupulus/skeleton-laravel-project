@php($category = new \App\Category())
<div class="modal fade" id="modal-category-add" tabindex="-1" role="dialog"
     aria-labelledby="modal-category-addedit-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-category-addedit-label">
                    Añadir categoría
                </h5>

                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-category-add"
                      action="{{route('panel.category.store')}}"
                      enctype="multipart/form-data"
                      method="POST">
                    @csrf

                    <input type="hidden" name="category_id"
                           value="{{old('category_id', $category->id)}}">

                    @if($category->urlImage)
                        <div class="text-center">
                            <img src="{{$category->urlImage}}"
                                 class="text-center"
                                 style="max-height: 120px;"
                                 alt="{{$category->name}}" />
                        </div>
                    @endif

                    <div class="form-group text-center">
                        <label for="image">Imagen (400x400px)</label>
                        <input class="form-control-file text-center"
                               type="file"
                               name="image"
                               value="{{old('image', $category->image)}}" />
                    </div>

                    <div class="form-group text-center">
                        <label for="name">Nombre</label>
                        <input type="text" name="name"
                               placeholder="My Categoría"
                               required
                               class="text-center form-control"
                               value="{{old('name', $category->name)}}" />
                    </div>

                    <div class="form-group text-center">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug"
                               placeholder="mi-categoria"
                               class="text-center form-control"
                               value="{{old('slug', $category->slug)}}" />
                    </div>


                    <div class="form-group text-center">
                        <label for="description">Descripción</label>
                        <textarea
                                class="text-center form-control"
                                placeholder="Escribe una breve descripción de la categoría"
                                name="description">{{old('description', $category->description)}}</textarea>
                    </div>

                    <div class="form-group text-center">
                        <label for="icon">Icono</label>
                        <input type="text" name="icon"
                               placeholder="fa fa-page"
                               class="text-center form-control"
                               value="{{old('icon', $category->icon)}}"/>
                        <small>
                            <a href="https://fontawesome.com/icons?d=gallery"
                               rel="nofollow"
                               target="_blank">
                                Ver iconos fontawesome disponibles
                            </a>
                        </small>
                    </div>

                    <div class="form-group text-center">
                        <label for="color">Color</label>
                        <input type="color" name="color"
                               class="text-center form-control"
                               value="{{old('color', $category->color)}}"/>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                    Cerrar
                </button>

                <button type="submit"
                        form="form-category-add"
                        class="btn btn-primary">
                    Crear
                </button>
            </div>
        </div>
    </div>
</div>
