<div class="row">
    <div class="col-md-12 text-center mt-3">
        <h2>
            SEO
        </h2>
    </div>

    <div class="col-md-12 form-row mt-4">
        <h3>Descripción</h3>

        {!!
            FormHelper::inputText('description', $seo->description, [
                'placeholder' => 'Descripción de la entrada',
                'maxlength' => 500
            ])
        !!}
    </div>

    <div class="col-md-12 form-row mt-4">
        <h3>Keywords</h3>
        <br />
        [ Crear sistema de tarjetas con sugerencias (select2???) y guardar en json ]
    </div>

    <hr />

    <div class="col-md-12 form-row mt-4">
        <h3>Redes Sociales - Título</h3>

        {!!
            FormHelper::inputText('og_title', $seo->og_title, [
                'placeholder' => 'Título para redes',
                'maxlength' => 500
            ])
        !!}
    </div>

    <div class="col-md-12 form-row mt-4">
        <h3>Redes Sociales - Nombre del sitio</h3>

        {!!
            FormHelper::inputText('og_site_name', $seo->og_site_name, [
                'placeholder' => 'Nombre del sitio',
                'maxlength' => 500
            ])
        !!}
    </div>

    <div class="col-md-12 form-row mt-4">
        <h3>Redes Sociales - Descripción</h3>

        {!!
            FormHelper::inputText('og_description', $seo->og_description, [
                'placeholder' => 'Descripción',
                'maxlength' => 500
            ])
        !!}
    </div>

    <div class="col-md-12 form-row mt-4">
        <div class="form-text">
            <h3>Redes Sociales - Image</h3>

            <br />

            <p>
                [ Modificar por selector y añadir file_id en tabla "files" ]
            </p>

            <img src="{{$content->seo ? $content->seo->urlImage : (new \App\ContentSeo)->urlImage}}"
                 alt="Image Content"
                 title="Image Content"
                 class="form-image-preview text-center" />

            <input type="file" name="og_image" class="form-control-file" />
        </div>
    </div>

    <div class="col-md-12 form-row mt-4">
        <h3>Redes Sociales - Image Alt</h3>

        {!!
            FormHelper::inputText('og_image_alt', $seo->og_image_alt, [
                'placeholder' => 'Image Alt',
                'maxlength' => 500
            ])
        !!}
    </div>

    {{-- Campos para enviar contenido al guardar --}}
    <div class="col-md-12 form-row mt-4">
        <input type="checkbox" class="form-check">
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
