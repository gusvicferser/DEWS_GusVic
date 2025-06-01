<header>
    <nav>
        <div class="left">
            <ul>
                <il><a href="{{ route('index') }}">Home</a></il>
                <il><a href="{{ route('index') }}">Eventos</a></il>
                <il><a href="">Productos</a></il>
            </ul>
        </div>
        <div class="center">
            <a href="{{ route('index') }}" class="" id="">
                <img width="100" height="100" src="img/DAIA_logo_trans.png" alt="DAIA Logo">
            </a>
        </div>
        <div class="right">
            @auth
                <div class="">
                    <a href="{{ route('index') }}" class="" id="">
                        <img src="img/DAIA_logo_trans.png" alt="Avatar" width="32" height="32" class="">
                    </a>
                    <ul class="">
                        <li><a class="" href="{{ route('user.index') }}">Perfil</a></li>
                        <li><a class="" href=" {{ route('logout') }}">Cerrar sesión</a></li>
                    </ul>
                </div>
            @else
                <div class="">
                    <a href="{{ route('login') }}"><button type="button" class="">Login</button></a>
                    <a href="{{ route('signup') }}"><button type="button" class="">Sign Up</button></a>
                </div>
            @endauth
        </div>
    </nav>
</header>
