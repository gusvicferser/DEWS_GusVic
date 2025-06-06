@extends('layout')

@section('title', 'Index')

@section('welcome')
    <div class="container-fluid d-flex justify-content-center login">
        <div class="login-form d-flex flex-column align-items-center justify-content-center text-center papyrus mt-lg-6rem">
            <h1 id="loginMsg" class="login-text text-secondary">Regístrate con nosotros</h1>
            <form method="post" action="{{ route('signup') }}">
                @csrf

                <br>
                <label class="form-label" for="user_name">Nombre de usuario</label>
                <br>

                <input id="user_name" name="user_name" class="login-form__input" placeholder="Nombre de usuario"
                    type="text" value="{{ old('user_name') }}">
                @if ($errors->has('user_name'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('user_name') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <br>
                <label class="form-label" for="email">Email</label>
                <br>
                <input id="email" name="email" class="login-form__input" placeholder="E-mail válido" type="email"
                    value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('email') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <br>
                <label class="form-label" for="birthday">Día de nacimiento</label>
                <br>
                <input id="birthday" name="birthday" class="login-form__input" placeholder="¿Qué año naciste?"
                    type="date" value="{{ old('birthday') }}">

                <br>
                <label class="form-label" for="password">Contraseña</label>
                <br>
                <input class="login-form__input" id="password" name="password" placeholder="Contraseña" type="password">
                <br>
                <small id="passwordHelpBlock" class="form-text text-muted">
                    Tu contraseña ha de tener entre 8 y 20 caracteres. <br> Debe contener letras y números y no debe en
                    ningún
                    caso contener caracteres especiales o emojis
                </small>
                <br>
                @if ($errors->has('password'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('password') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <br>
                <label class="form-label" for="password_confirmation">Repita la contraseña</label>
                <br>
                <input class="login-form__input" id="password_confirmation" name="password_confirmation"
                    placeholder="Repite la contraseña" type="password">
                @if ($errors->has('password.confirmed'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('password.confirmed') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <br>
                <label class="form-label" for="first_name">Nombre (Opcional)</label>
                <br>
                <input id="first_name" name="first_name" class="login-form__input" placeholder="Nombre" type="text"
                    value="{{ old('first_name') }}">

                <br>
                <label class="form-label" for="last_name">Apellidos (Opcional)</label>
                <br>

                <input id="last_name" name="last_name" class="login-form__input" placeholder="Apellidos" type="text"
                    value="{{ old('last_name') }}">
                <br>
                <label class="form-label" for="address">Dirección (Opcional)</label>
                <br>
                <input id="address" name="address" class="login-form__input" placeholder="Nombre" type="text"
                    value="{{ old('address') }}">
                <br>
                <label class="form-label" for="telephone">Teléfono (Opcional)</label>
                <br>
                <input id="telephone" name="telephone" class="login-form__input" placeholder="Nombre" type="text"
                    value="{{ old('telephone') }}">

                <div class="d-grid mt-3 gap-2 col-8 mx-auto">
                    <input id="btnSubmit" type="submit" class="paper btn btn-lg btn-secondary px-4rem mb-3"
                        value="Regístrate">
                </div>
            </form>
        </div>
    </div>
@endsection
