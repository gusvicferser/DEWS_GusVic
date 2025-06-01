@extends('layout')

@section('title', 'Login')

@section('welcome')
    <div class="">
        <div class="">
            <h1 id="loginMsg" class="">Iniciar sesión</h1>
            <form method="post" action="{{ route('login') }}">
                @csrf
                <input id="user_name" name="user_name" class="" placeholder="Usuario" type="text"
                    value="{{ old('user_name') }}">
                <br>
                <input class="" name="password" placeholder="Contraseña" type="password">
                @if (isset($error))
                    <div class="">
                        <div class="">{{ $error }}</div>
                    </div>
                @endif
                <div class="">
                    <input class="" type="checkbox" name="remember" id="remember">
                    <label class="" for="remember">Recuérdame en este dispositivo</label>
                </div>
                <div class="">
                    <button id="btnSubmit" type="submit" class="">Entra</button>
                </div>
                <div class="">
                    <a class="" href="">
                        He olvidado mi contraseña
                    </a>
                    <span class="">|</span>
                    <a class="" href="{{ route('signup') }}">
                        Aún no tengo cuenta
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
