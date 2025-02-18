<header class="p-2 mb-2 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-lg-center justify-content-center justify-content-lg-start">
            <a href="{{ route('index') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                <img class="bi" width="100" height="100" src="img/GG_Icon.png" aria-label="Bootstrap"></img>
            </a>

            <h5 class="nav-link px-2 link-dark m-0" style="color:#6f42c1">Ganking Gods</h5>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center align-items-end mb-md-0">
                <li><a href="{{ route('index') }}" class="nav-link px-2 pb-1 link-secondary">Inicio</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link px-2 pb-1 link-dark">Eventos</a></li>
                <li><a href="{{ route('players.index') }}" class="nav-link px-2 pb-1 link-dark">Jugadores</a></li>
                <li><a href="{{ route('location') }}" class="nav-link px-2 pb-1 link-dark">Dónde encontrarnos</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link px-2 pb-1 link-dark">Contáctanos</a></li>
            </ul>
            @auth
                <div class="dropdown text-end">
                    <a href="{{ route('users.profile') }}" class="d-block link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32"
                            class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="{{ route() }}">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                </div>
            @else
                <div class="text-end px-2">
                    <a href="{{ route('login') }}"><button type="button"
                            class="btn btn-outline-secondary mx-2">Login</button></a>
                    <a href="{{ route('signup') }}"><button type="button" class="btn btn-secondary">Sign Up</button></a>
                </div>
            @endauth
        </div>
    </div>
</header>
