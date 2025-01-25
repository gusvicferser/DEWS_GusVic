<?php

/**
 * Aplicación web para mostrar la cabecera. Ha de incluír:
 * 
 * El logo de la red social (Ha de contener a su vez un enlace a index.html)
 *  (TO DO)
 * 
 * Si el usuario no está logueado, un enlace a loguin
 *  (HECHO)
 * 
 * Si el usuario está logueado, un formulario de búsqueda (campo de texto y botón)
 *  que mandará los datos a la página results y también aparecerá el nombre de
 *  usuario que será un enlace a account y enlaces a new(publicación) y close
 *  (log out).
 * 
 *  (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 2.0
 */
// Si el usuario no está logueado (no existe su variable de sesión): -->
if (!isset($_SESSION['user_name'])) {
?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">TrollNeXt</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h4 class="text-warning">¡Únete a la comunidad y comienza a trollear!</h4>
            <span class="nav-links">
                <a href="/login" class="btn btn-outline-warning">Trolléate</a>
            </span>
        </div>
    </nav>

<?php
    // Fin usuario no logueado -->

    //Si el usuario está logueado (existe su variable de sesión): -->
} else {
?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="img/TrollNeXt.png" alt="TrollNeXt" width="200px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link text-warning" aria-current="page" href="/account"><?= $_SESSION['user_name'] ?></a>
                        <a></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/new">Nueva Publicación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/close">Desconectar</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" action="/results" method="GET">
                    <input class="form-control me-2" type="search" aria-label="Search" id="search" name="search" placeholder="¿Qué buscas?">
                    <button class="btn btn-outline-warning" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
<?php
}
?>
</div>
</header>