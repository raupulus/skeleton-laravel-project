<div class="form-row">
    {{-- Profesión --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="profesion">Seleccionar Red Social</label>

            <select title="Selecciona red social"
                    class="form-control selectpicker"
                    name="social_id">
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
                   placeholder="Nick"
                   aria-describedby="social_nick"
                   name="social_nick"
                   required>
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
                   placeholder="Nick"
                   aria-describedby="social_url"
                   name="social_url"
                   required>
        </div>
    </div>
</div>
