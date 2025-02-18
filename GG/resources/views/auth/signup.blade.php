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
                <form method="post" action="{{ route('signup')}}">
                    @csrf

                    <label class="form-label" for="username">Nombre de usuario</label>
                    <input id="username" name="username" class="login-form__input" placeholder="Nombre de usuario"
                        type="text">
                    <div class="login-form__span-error">
                    </div>

                    <label class="form-label" for="name">Nombre Completo</label>
                    <input id="name" name="name" class="login-form__input" placeholder="Nombre completo"
                        type="text">
                    <div class="login-form__span-error">
                    </div>

                    <label class="form-label" for="email">Email</label>
                    <br>
                    <input id="email" name="email" class="login-form__input" placeholder="E-mail válido"
                        type="email">
                    <div class="login-form__span-error">
                    </div>

                    <label class="form-label" for="birthday">Día de nacimiento</label>
                    <input id="birthday" name="birthday" class="login-form__input" placeholder="¿Qué año naciste?"
                        type="date">
                    <div class="login-form__span-error">
                    </div>

                    <label class="form-label" for="password">Contraseña</label>
                    <input class="login-form__input " id="password" name="password" placeholder="Contraseña" type="password">
                    <div class="login-form__span-error">
                    </div>

                    <label class="form-label" for="pass_check">Repita la contraseña</label>
                    <input class="login-form__input " id="pass_check" name="pass_check" placeholder="Repite la contraseña" type="password">
                    <div class="login-form__span-error">
                    </div>

                    <div class="d-grid gap-2 col-8 mx-auto">
                        <button id="btnSubmit" type="submit" class="btn-warning btn btn-lg px-4rem mb-3 text-secondary">Regístrate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
