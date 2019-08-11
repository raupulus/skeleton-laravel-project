<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('index')}}">
            El Tiempo Desde Chipiona
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarResponsive"
                aria-controls="navbarResponsive"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item @yield('active-index')">
                    <a class="nav-link" href="{{route('index')}}">
                        Inicio
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="nav-item @yield('active-service')">
                    <a class="nav-link" href="{{route('services')}}">
                        Servicios
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Ver el tiempo
                    </a>
                    <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
                    <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">
                            El clima en tiempo real
                        </a>

                        <a class="dropdown-item" href="#">
                            Comparar días
                        </a>

                        <a class="dropdown-item" href="#">
                            Esta semana
                        </a>

                        <a class="dropdown-item" href="#">
                            Este mes
                        </a>

                        <a class="dropdown-item" href="#">
                            Tabla de Mareas
                        </a>

                        <a class="dropdown-item" href="#">
                            Calidad del aire
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="#">
                            Ver pronósticos
                        </a>
                    </div>
                </li>

                <li class="nav-item @yield('active-about')">
                    <a class="nav-link" href="{{route('about')}}">
                        About
                    </a>
                </li>

                <li class="nav-item @yield('active-contact')">
                    <a class="nav-link" href="{{route('contact')}}">
                        Contacto
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
