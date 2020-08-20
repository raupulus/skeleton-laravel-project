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

    <div class="col-12 form-row mt-4">
        <h3>Slug</h3>

        {!!
            FormHelper::inputText('slug', $content->slug, [
                'placeholder' => 'slug-content',
                'required' => 'true',
                'maxlength' => 250,
            ])
        !!}
    </div>

    <div class="col-12 mt-4">
        <h3>Excerpt <small>(250 carácteres)</small></h3>
        {!!
            FormHelper::textarea('excerpt', $content->excerpt, [
                'required' => 'true',
                'maxlength' => 250,
            ])
        !!}
    </div>

    {{-- Imagen Principal --}}
    <div class="col-12 mt-4">
        <h3>Imagen Principal</h3>

        <div class="text-center">
            <img src="{{$content->urlImage}}"
                 alt="Image Content"
                 title="Image Content"
                 class="form-image-preview text-center" />

            <input class="form-control-file mt-3 mb-3 text-center"
                   name="image"
                   type="file" />
        </div>
    </div>

    {{-- Editor Gutenberg --}}
    <div class="col-12 mt-4">
        <h3>Contenido</h3>
        <textarea id="form-addedit-body"
                  name="body"
                  placeholder="Añade aquí el contenido"
                  rows="10"
                  hidden>{{old('body', $content->getRawContent())}}</textarea>
    </div>

    {{-- Usando mi editor en vue.js --}}
    {{--
    <div class="col-12">
        <h3>Contenido</h3>
        {!!
            FormHelper::textarea('body', $content->body, [
                'required' => 'true',
            ])
        !!}

         <!-- Editor -->
        <h2>Editor</h2>
        <v-toast-editor></v-toast-editor>
    </div>
    --}}
</div>
