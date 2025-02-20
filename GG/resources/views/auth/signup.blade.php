@extends('layout')

@section('styles')
    <link rel="stylesheet" href="css/login.css">
@endsection

@section('title', 'Index')

@section('welcome')
    <div class="container-fluid">
        <div class="container-fluid lg-w-75 login">
            <div class="login-form mt-lg-6rem">
                <h1 id="loginMsg" class="login-text">Regístrate con nosotros</h1>
                <form method="post" action="{{ route('signup') }}">
                    @csrf

                    <label class="form-label" for="username">Nombre de usuario</label>
                    <input id="username" name="username" class="login-form__input" placeholder="Nombre de usuario"
                        type="text" value="{{old('username')}}">
                    @if ($errors->has('username'))
                        <div class="login-form__span-error">
                            @foreach ($errors->get('username') as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <label class="form-label" for="name">Nombre Completo</label>
                    <input id="name" name="name" class="login-form__input" placeholder="Nombre completo"
                        type="text" value="{{old('name')}}">
                    @if ($errors->has('name'))
                        <div class="login-form__span-error">
                            @foreach ($errors->get('name') as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <br>
                    <label class="form-label" for="email">Email</label>
                    <br>
                    <input id="email" name="email" class="login-form__input" placeholder="E-mail válido"
                        type="email" value="{{old('email')}}">
                        @if ($errors->has('email'))
                        <div class="login-form__span-error">
                            @foreach ($errors->get('email') as $error)
                                    <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <label class="form-label" for="birthday">Día de nacimiento</label>
                    <input id="birthday" name="birthday" class="login-form__input" placeholder="¿Qué año naciste?"
                        type="date" value="{{old('birthday')}}">

                    <label class="form-label" for="password">Contraseña</label>
                    <input class="login-form__input " id="password" name="password" placeholder="Contraseña"
                        type="password">
                        @if ($errors->has('password'))
                        <div class="login-form__span-error">
                            @foreach ($errors->get('password') as $error)
                                    <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <label class="form-label" for="password_confirmation">Repita la contraseña</label>
                    <input class="login-form__input " id="password_confirmation" name="password_confirmation"
                        placeholder="Repite la contraseña" type="password">
                        @if ($errors->has('password.confirmed'))
                        <div class="login-form__span-error">
                            @foreach ($errors->get('password.confirmed') as $error)
                                    <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-grid mt-3 gap-2 col-8 mx-auto">
                        <input id="btnSubmit" type="submit" class="btn-warning btn btn-lg px-4rem mb-3 text-secondary"
                            value="Regístrate">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
