@extends('layout')

@section('styles')
    <link rel="stylesheet" href="css/login.css">
@endsection

@section('title', 'Index')

@section('welcome')
    <div class="container-fluid lg-w-75 login">
        <div class="login-form mt-lg-6rem">
            <h1 id="loginMsg" class="login-text">Iniciar sesión</h1>
            <form method="post" action="{{ route('login') }}">
                @csrf
                <input id="username" name="username" class="login-form__input" placeholder="Usuario" type="text"
                    value="{{ old('username') }}">
                <br>
                <input class="login-form__input" name="password" placeholder="Contraseña" type="password">
                @if (isset($error))
                    <div class="login-form__span-error">
                        <div class="text-center">{{ $error }}</div>
                    </div>
                @endif
                <div class="login-form-links d-flex flex-row justify-center items-center mb-4">
                    <input class="me-2" type="checkbox" name="remember" id="remember">
                    <label class="ms-2" for="remember">Recuérdame en este dispositivo</label>
                </div>
                <div class="d-grid gap-2 col-8 mx-auto">
                    <button id="btnSubmit" type="submit" class=" btn-warning btn btn-lg px-4rem mb-3">Entra</button>
                </div>
                <div class="login-form-links d-flex flex-row justify-center items-center">
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
