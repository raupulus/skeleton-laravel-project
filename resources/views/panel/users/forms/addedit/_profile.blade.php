<div class="row">
    {{-- Nombre --}}
    <div class="col-md-6">
        <label for="nombre">Nombre</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="nombre">
                    <i class="fa fa-user"></i>
                </span>
            </div>

            <input type="text" class="form-control"
                   aria-describedby="nombre"
                   name="nombre"
                   placeholder="Tu nombre" />
        </div>
    </div>

    {{-- Teléfono --}}
    <div class="col-md-6">
        <label for="phone">Teléfono</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="phone">
                    <i class="fa fa-mobile-phone"></i>
                </span>
            </div>

            <input type="text" class="form-control"
                   aria-describedby="phone"
                   name="phone"
                   placeholder="Teléfono" />
        </div>
    </div>
</div>

<div class="row mt-5">
    {{-- Descripción --}}
    <div class="col-md-12">
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control"
                      name="description"
                      rows="4"
                      placeholder="Descríbete aquí"></textarea>
        </div>
    </div>
</div>

<div class="row mt-5">
    {{-- Biografía --}}
    <div class="col-md-12">
        <div class="form-group">
            <label for="biography">Biografía</label>
            <textarea class="form-control"
                      name="biography"
                      rows="6"
                      placeholder="Cuenta aquí tu trayectoría"></textarea>
        </div>
    </div>
</div>
