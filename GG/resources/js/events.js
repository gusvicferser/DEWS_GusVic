/**
 * JS para eventos del proyecto GG:
 *
 * Se supone que a través de un fetch, podemos mostrar los eventos que hay en la base de datos:
 */

fetch('/Api/events').then(
    response => {
        response.json();
    }
).then(
    data => {
        console.log(data);
    }
).catch(error => {
    console.log(error);
})
