<div class="row">
    <div class="col-md-12 text-center">
        <h2>
            SEO
        </h2>
    </div>

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Descripción</h3>

        {!!
            FormHelper::inputText('description', $seo->description, [
                'placeholder' => 'Descripción de la entrada',
                'maxlength' => 500
            ])
        !!}
    </div>

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Keywords</h3>
        <br />
        [ Crear sistema de tarjetas con sugerencias (select2???) y guardar en json ]
    </div>

    <br />
    <br />

    <hr />

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Redes Sociales - Título</h3>

        {!!
            FormHelper::inputText('og_title', $seo->og_title, [
                'placeholder' => 'Título para redes',
                'maxlength' => 500
            ])
        !!}
    </div>

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Redes Sociales - Nombre del sitio</h3>

        {!!
            FormHelper::inputText('og_site_name', $seo->og_site_name, [
                'placeholder' => 'Nombre del sitio',
                'maxlength' => 500
            ])
        !!}
    </div>

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Redes Sociales - Descripción</h3>

        {!!
            FormHelper::inputText('og_description', $seo->og_description, [
                'placeholder' => 'Descripción',
                'maxlength' => 500
            ])
        !!}
    </div>

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Redes Sociales - Image</h3>
        <br />
        <br />
        [ Modificar por selector y añadir file_id en tabla "files" ]

        <br />
        <br />
        Facebook (???px x ???px): <input type="file"
                                         class="form-control-file" />

        <br />
        <br />
        Twitter: <input type="file" class="form-control-file" />

        <br />
        <br />
        Instagram: <input type="file" class="form-control-file" />
    </div>

    <br />
    <br />

    <div class="col-md-12 form-row">
        <h3>Redes Sociales - Image Alt</h3>

        {!!
            FormHelper::inputText('og_image_alt', $seo->og_image_alt, [
                'placeholder' => 'Image Alt',
                'maxlength' => 500
            ])
        !!}
    </div>

    <br />
    <br />


    {{-- Campos para enviar contenido al guardar --}}
    <div class="col-md-12 form-row">
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
