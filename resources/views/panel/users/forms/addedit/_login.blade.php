<div class="row">
    {{-- Correo --}}
    <div class="col-md-12">
        <label for="email">Correo</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="email">
                    <i class="fa fa-mail-bulk"></i>
                </span>
            </div>

            <input type="email" class="form-control"
                   placeholder="Correo"
                   aria-describedby="email"
                   name="email"
                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 5}$"
                   required />
        </div>
    </div>
</div>

<div class="row mt-5">
    {{-- Contraseña --}}
    <div class="col-md-6">
        <label for="password">Password</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="password">
                    <i class="fa fa-user-secret"></i>
                </span>
            </div>

            <input type="password" class="form-control"
                   aria-describedby="password"
                   name="password"
                   required />
        </div>
    </div>

    {{-- Contraseña --}}
    <div class="col-md-6">
        <label for="password_repeat">Password Repeat</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="password_repeat">
                    <i class="fa fa-repeat"></i>
                </span>
            </div>

            <input type="password" class="form-control"
                   aria-describedby="password_confirmation"
                   name="password_confirmation"
                   required />
        </div>
    </div>
</div>
