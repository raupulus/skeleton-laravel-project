<div class="row">
    <div class="col-md-12 form-row">
        <h3>Título</h3>

        {!!
            FormHelper::inputText('title', $content->title, [
                'placeholder' => 'Título de la entrada',
                'required' => 'true',
                'maxlength' => 500
            ])
        !!}
    </div>

    <div class="col-12 form-row">
        <h3>Slug</h3>

        {!!
            FormHelper::inputText('slug', $content->slug, [
                'placeholder' => 'slug-content',
                'required' => 'true',
                'maxlength' => 250,
            ])
        !!}
    </div>

    <div class="col-12">
        <h3>Imagen Principal</h3>

        <image src="{{$content->urlImage}}"
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
        {!!
            FormHelper::textarea('excerpt', $content->excerpt, [
                'required' => 'true',
                'maxlength' => 250,
            ])
        !!}
    </div>

    <div class="col-12">
        <h3>Contenido</h3>
        {!!
            FormHelper::textarea('body', $content->body, [
                'required' => 'true',
            ])
        !!}


         <!-- Editor -->
        <h2>Editor</h2>
        <div id="editor"></div>

        <!-- Viewer Using Editor -->
        <h2>Viewer</h2>
        <div id="viewer"></div>

    </div>
</div>
