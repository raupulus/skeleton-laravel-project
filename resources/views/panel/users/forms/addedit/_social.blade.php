<div id="user_social_content_box">
    <div class="user_social_box row">
        {{-- Red Social --}}
        <div class="col-md-4">
            <div class="form-group">
                <button class="user_social_box_delete btn btn-sm btn-danger">
                    <i class="fa fa-trash-alt"></i>
                </button>

                <label for="social_id">Red Social</label>

                <select title="Selecciona red social"
                        class="form-control selectpicker"
                        name="social_id[]">
                    @foreach($socialNetworks as $social)
                        <option data-icon="{{ $social->icon }}"
                                data-subtext="{{ $social->type }}"
                                style="color: {{ $social->color }}"
                                value="{{ $social->id }}">
                            {{ $social->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Nick --}}
        <div class="col-md-4">
            <label for="social_nick">Nick</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="social_nick">@</span>
                </div>

                <input type="text" class="form-control"
                       placeholder="Username"
                       aria-describedby="social_nick"
                       name="social_nick[]" />
            </div>
        </div>

        {{-- Url del Perfil --}}
        <div class="col-md-4">
            <label for="social_url">Url del perfil</label>

            <div class="input-group">
                <div class="input-group-prepend">
                <span class="input-group-text" id="social_url">
                    <i class="fa fa-globe"></i>
                </span>
                </div>

                <input type="text" class="form-control"
                       placeholder="https://redsocial.es/nick"
                       aria-describedby="social_url"
                       name="social_url[]" />
            </div>
        </div>
    </div>

    {{-- Añadir otra red social --}}
    <div class="row">
        <div class="col-12">
            <button id="red_social_add" class="btn btn-warning">
                Agregar Otra
            </button>
        </div>
    </div>
</div>
