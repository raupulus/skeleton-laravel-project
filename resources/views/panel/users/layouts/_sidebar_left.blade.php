<div class="col-12 col-md-3 user-profil-part pull-left">
    {{-- User Card --}}
    <div class="row ">
        <div class="col-12 user-image text-center">
            <img class="rounded-circle"
                 src="https://www.jamf.com/jamf-nation/img/default-avatars/generic-user-purple.png">
        </div>

        <div class="col-12 user-detail-section1 text-center">
            <button id="btn-contact"
                    data-toggle="modal"
                    data-target="#contact"
                    class="btn btn-primary btn-block follow">
                <i class="fas fa-globe"></i>
                Redes Sociales¿?
            </button>

            <button class="btn btn-warning btn-block">
                <i class="fas fa-file-download"></i>
                Descargar Curriculum
            </button>

            <button class="btn btn-danger btn-block">
                <i class="fas fa-user-shield"></i>
                Reportar Usuario
            </button>

            <button class="btn btn-dark btn-block">
                <i class="fas fa-envelope-open"></i>
                Enviar Mensaje
            </button>

            <a href="{{route('panel.users.add')}}"
               class="btn btn-primary btn-block">
                <i class="fas fa-user-edit"></i>
                Editar Perfil
            </a>

            <a href="{{route('panel.users.add')}}"
               class="btn btn-danger btn-block">
                <i class="fas fa-trash"></i>
                Eliminar Cuenta
            </a>
        </div>

        {{-- Seguidores --}}
        <div class="row user-detail-row">
            <div class="col-12 user-detail-section2 pull-left">
                <div class="border"></div>
                <p>FOLLOWER</p>
                <span>320</span>
            </div>
        </div>
    </div>
</div>
