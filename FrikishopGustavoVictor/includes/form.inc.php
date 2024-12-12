<?php

/**
 * Include para el formulario de registro y login:
 * 
 * @author (Corrección) Gustavo Víctor
 * @version 1.1
 */

//Si el usuario no está logueado (no existe su variable de sesión) -->
?>
<div class="loginContainer">
    <h2>Regístrate para poder comprar en la tienda</h2>

    <form action="/signup" method="post">
        <label for="user">Usuario</label>
        <input type="text" name="user" id="user">
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
        <br>
        <label></label>
        <input type="submit" value="Registrarse">
    </form>

    <span>¿Ya tienes cuenta? <a href="/login">Loguéate aquí</a>.</span>
</div>