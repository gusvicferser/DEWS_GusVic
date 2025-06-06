<footer
    class="d-flex flex-column flex-lg-row flex-wrap justify-content-lg-between justify-content-center align-items-center border-top papyrus text-center">
    <ul class="nav col-md-4 justify-content-around">
        <div class="row-sm">

            <li class="nav-item col"><a href="{{ route('index') }}" class="text-muted">Inicio</a></li>
            <li class="nav-item col"><a href="{{ route('terms') }}" class="text-muted">Términos y condiciones</a>
            </li>
        </div>
        <div class="row">
            <li class="nav-item col"><a href="{{ route('privacy') }}" class="text-muted">Política de
                    privacidad</a></li>
            <li class="nav-item col"><a href="{{ route('cookies') }}" class="text-muted">Política de
                    cookies</a></li>
            <li class="nav-item col"><a href="{{ route('cookies') }}" class="text-muted">Contáctanos</a></li>
        </div>
    </ul>

    <a href="{{ route('index') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
        <img class="bi p-2 me-2 img-filter" width="150" height="80" src="/storage/img/DAIA_logo.png"
            aria-label="Bootstrap"></img>
    </a>

    <p class="col-md-4 mb-0 text-muted">© 2025 Gustavo Víctor Fernández Serantes</p>
</footer>
