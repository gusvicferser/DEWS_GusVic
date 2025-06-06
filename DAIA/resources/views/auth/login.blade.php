@extends('layout')

@section('title', 'Login')

@section('welcome')
    <div class="container-fluid d-flex justify-content-center login">
        <div class="login-form d-flex flex-column align-items-center justify-content-center text-center papyrus mt-lg-6rem">
            <h1 id="loginMsg" class="login-text text-secondary">Iniciar sesión</h1>
            <form method="post" action="{{ route('login') }}">
                @csrf
                <input id="user_name" name="user_name" class="login-form__input" placeholder="Usuario" type="text"
                    value="{{ old('user_name') }}">
                <br>
                <input class="login-form__input" name="password" placeholder="Contraseña" type="password">
                @if (isset($error))
                    <div class="alert alert-danger text-center h-3" role="alert">{{ $error }}</div>
                @endif
                <div class="">
                    <input class="" type="checkbox" name="remember" id="remember">
                    <label class="form-label" for="remember">Recuérdame en este dispositivo</label>
                </div>
                <div class="d-grid mt-3 gap-2 col-8 mx-auto">
                    <button id="btnSubmit" type="submit"
                        class="paper btn btn-lg btn-outline-secondary px-4rem mb-3">Entra</button>
                </div>
                <div class="login-form-links d-flex flex-row justify-items-center align-items-center">
                    <a class="login-form__link p-2" href="">
                        He olvidado mi contraseña
                    </a>
                    <span class="login-form__link-divider p-2">|</span>
                    <a class="login-form__link p-2" href="{{ route('signup') }}">
                        Aún no tengo cuenta
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
