@extends('layout')

@section('styles')
    <link rel="stylesheet" href="css/login.css">
@endsection

@section('title', 'Index')

@section('welcome')
    <div class="">
        <div class="">
            <div class="">
                <h1 id="loginMsg" class="">Regístrate con nosotros</h1>
                <form method="post" action="{{ route('signup') }}">
                    @csrf

                    <br>
                    <label class="" for="user_name">Nombre de usuario</label>
                    <br>

                    <input id="user_name" name="user_name" class="" placeholder="Nombre de usuario" type="text"
                        value="{{ old('user_name') }}">
                    @if ($errors->has('user_name'))
                        <div class="">
                            @foreach ($errors->get('user_name') as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    <label class="" for="email">Email</label>
                    <br>
                    <input id="email" name="email" class="login-form__input" placeholder="E-mail válido"
                        type="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="">
                            @foreach ($errors->get('email') as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    <label class="" for="birthday">Día de nacimiento</label>
                    <br>
                    <input id="birthday" name="birthday" class="" placeholder="¿Qué año naciste?" type="date"
                        value="{{ old('birthday') }}">

                    <br>
                    <label class="" for="password">Contraseña</label>
                    <br>
                    <input class="" id="password" name="password" placeholder="Contraseña" type="password">
                    @if ($errors->has('password'))
                        <div class="">
                            @foreach ($errors->get('password') as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    <label class="" for="password_confirmation">Repita la contraseña</label>
                    <br>
                    <input class="" id="password_confirmation" name="password_confirmation"
                        placeholder="Repite la contraseña" type="password">
                    @if ($errors->has('password.confirmed'))
                        <div class="">
                            @foreach ($errors->get('password.confirmed') as $error)
                                <div> {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    <label class="" for="first_name">Nombre (Opcional)</label>
                    <br>
                    <input id="first_name" name="first_name" class="" placeholder="Nombre" type="text"
                        value="{{ old('first_name') }}">

                    <br>
                    <label class="" for="last_name">Apellidos (Opcional)</label>
                    <br>

                    <input id="last_name" name="last_name" class="" placeholder="Apellidos" type="text"
                        value="{{ old('last_name') }}">
                    <br>
                    <label class="" for="address">Dirección (Opcional)</label>
                    <br>
                    <input id="address" name="address" class="" placeholder="Nombre" type="text"
                        value="{{ old('address') }}">
                    <br>
                    <label class="" for="telephone">Teléfono (Opcional)</label>
                    <br>
                    <input id="telephone" name="telephone" class="" placeholder="Nombre" type="text"
                        value="{{ old('telephone') }}">

                    <div class="">
                        <input id="btnSubmit" type="submit" class="" value="Regístrate">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
