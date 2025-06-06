<header class="p-2 mb-2 border-bottom">
    <nav
        class="navbar papyrus fixed-lg-top navbar-expand-lg d-flex align-items-center justify-content-lg-around justify-content-between flex-column flex-sm-row">
        <div class="row">
            <ul class="nav col me-lg-auto mb-2 justify-content-start align-items-start">
                <il class="bv bgf"><a href="{{ route('index') }}"
                        class="nav-link px-2 pb-1 link-secondary btn btn-lg">Home</a></il>
                <il><a href="{{ route('products.index') }}" class="nav-link px-2 pb-1 link-dark btn btn-lg">Tienda</a>
                </il>
                <il><a href="{{ route('events.index') }}" class="nav-link px-2 pb-1 link-dark btn btn-lg">Events</a></il>
            </ul>
        </div>
        <div class="row">
            <div class="navbar-brand col">
                <a href="{{ route('index') }}" class="d-flex flex-wrap align-items-lg-center justify-content-center "
                    id="navbar_logo">
                    <img class="img-filter" height="75" src="/storage/img/DAIA_logo.png" alt="DAIA Logo">
                </a>
            </div>
        </div>
        @auth
            <div class="row">
                <div class="col">
                    <ul class="navbar-nav">
                        <li class="">
                            <a class="btn btn-lg" href="{{ route('users.index') }}">Perfil</a>
                        </li>
                        <li class="">
                            <a class="btn btn-lg" href=" {{ route('logout') }}">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
            @if (Auth::user()->role === 'admin')
                <div class="row">
                    <div class="col">
                        <div class="dropdown">
                            <a class="btn btn-lg btn-secondary dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                Administrar
                            </a>
                            <div class="row">
                                <div class="dropdown-menu">
                                    <a href="{{ route('events.create') }}" class="dropdown-item" class="dropdown-item">Crear
                                        Evento</a>
                                    <a href="{{ route('products.create') }}" class="dropdown-item">Crear Producto</a>
                                    <a href="{{ route('users.index') }}" class="dropdown-item">Ascender a usuario a Mod</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="row">
                <div class="navbar-nav mr-auto mt-2 mt-lg-0 text-end px-2">
                    <a href="{{ route('login') }}"><button type="button"
                            class="btn btn-lg btn-outline-secondary mx-2">Login</button></a>
                    <a href="{{ route('signup') }}">
                        <button type="button" class="btn btn-lg btn-secondary">Sign Up</button></a>
                </div>
            </div>
        @endauth
    </nav>
</header>
