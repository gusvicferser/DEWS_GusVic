@extends('layout')

@section('title', 'Terms')

@section('content')
    <div class="container-fluid mt-3">
        <h1>Aviso Legal</h1>

        <div>
            <h2>Titularidad del Sitio Web</h2>
            <p>El presente aviso legal regula el uso del sitio web <a href="{{ route('index') }}">https://www.daia.com</a>
                (en
                adelante, "el Sitio Web"), cuyo titular es <span>DAIA S.L. </span> (en adelante, "el Titular"), con
                domicilio en C/ Actor Mauri Portal 14 puerta 3, 46022 Valencia, Spain y NIF/CIF 43212844F.</p>
            <p>Contacto: contact@daia.com</p>
        </div>

        <div>
            <h2>Aceptación de los Términos de Uso</h2>
            <p>El uso del Sitio Web implica la aceptación de este Aviso Legal. El usuario debe revisarlo periódicamente.</p>
        </div>
        <div>
            <h2>Condiciones de Uso</h2>
            <div>
                <h3>1. Uso del Sitio Web</h3>
                <p>El usuario se compromete a utilizar el Sitio Web conforme a la ley y este Aviso Legal.</p>
            </div>
            <div>
                <h3>2. Propiedad Intelectual e Industrial</h3>
                <p>Todos los contenidos del Sitio Web son propiedad del Titular o de terceros. No se ceden derechos de
                    explotación.
                </p>
            </div>
            <div>
                <h3>3. Limitación de Responsabilidad por Contenidos</h3>
                <p>El Titular no garantiza la disponibilidad continua ni la exactitud del contenido del Sitio Web.</p>
            </div>
            <div>
                <h3>4. Protección de Datos</h3>
                <p>Consulta nuestra <a href="{{ route('privacy') }}">Política de Privacidad</a> para más información
                    sobre el
                    tratamiento de datos personales.</p>
            </div>
            <div>
                <h3>5. Uso de Servicios Especiales</h3>
                <p>Los usuarios que utilicen servicios de suscripción o comercio electrónico aceptan términos específicos de
                    servicio.</p>
            </div>
            <div>
                <h3>6. Enlaces Externos</h3>
                <p>El Titular no se hace responsable de los contenidos de enlaces externos.</p>
            </div>
            <div>
                <h3>7. Modificaciones del Aviso Legal</h3>
                <p>El Titular puede modificar este Aviso Legal en cualquier momento.</p>
            </div>
            <div>
                <h3>8. Política de Cookies</h3>
                <p>Consulta nuestra <a href="{{ route('cookies') }}">Política de Cookies</a> para más información.</p>
            </div>
            <div>
                <h3>9. Condiciones para Usuarios Registrados</h3>
                <p>Los usuarios registrados deben mantener la confidencialidad de sus credenciales.</p>
            </div>
            <div>
                <h3>10. Prohibiciones Específicas de Uso</h3>
                <p>Está prohibido el uso del Sitio Web para actividades ilegales o envío de spam.</p>
            </div>
            <div>
                <h3>11. Política de Cancelación o Modificación de Servicios</h3>
                <p>El Titular puede modificar, suspender o cancelar servicios sin previo aviso.</p>
            </div>
            <div>
                <h3>12. Jurisdicción Internacional</h3>
                <p>El usuario es responsable de cumplir con la legislación de su país de residencia.</p>
            </div>
            <div>
                <h2>Legislación Aplicable y Jurisdicción</h2>
                <p>Este Aviso Legal se rige por la ley española y las disputas se someterán a los tribunales españoles.</p>
            </div>
        </div>
    </div>
@endsection
