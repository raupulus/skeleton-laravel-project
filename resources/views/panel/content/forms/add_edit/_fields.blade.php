<div class="row">
    <div class="col-md-12 form-row">
        <h3>Título</h3>
        <input class="form-control"
               name="title"
               type="text"
               placeholder="Título de la entrada" />
    </div>

    <div class="col-12 form-row">
        <h3>Slug</h3>

        <input class="form-control"
               name="slug"
               type="text"
               placeholder="slug-content" />
    </div>

    <div class="col-12">
        <h3>Imagen</h3>

        <image src="{{asset('images/default/default_1200x600.jpg')}}"
               alt="Image Content"
               title="Image Content"
               class="form-image-preview" />

        <input class="form-control"
               name="image"
               style=""
               type="file" />
    </div>

    <div class="col-12">
        <h3>Excerpt <small>(250 carácteres)</small></h3>
        <textarea class="form-control"></textarea>
    </div>

    <div class="col-12">
        <h3>Contenido</h3>
        <textarea class="form-control"></textarea>
    </div>
</div>
