<div class="row">
    {{-- Profesión --}}
    <div class="col-md-6">
        <label for="profesion">Profesión</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="profesion">
                    <i class="fa fa-graduation-cap"></i>
                </span>
            </div>

            <input type="text" class="form-control"
                   aria-describedby="profesion"
                   name="profesion"
                   placeholder="Profesión" />
        </div>
    </div>

    {{-- Web --}}
    <div class="col-md-6">
        <label for="web">Web</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="web">
                    <i class="fa fa-globe-europe"></i>
                </span>
            </div>

            <input type="text" class="form-control"
                   aria-describedby="web"
                   name="web"
                   placeholder="{{config('app.url')}}" />
        </div>
    </div>
</div>
