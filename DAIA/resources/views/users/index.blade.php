@extends('layout')

@section('title', 'DAIA Account')

@section('content')
    @auth
        @if (Auth::user()->role !== 'admin')
            <div class="container-fluid d-flex flex-column text-center p-4">

                <div class="row ">
                    <div class="col align-self-center">
                        <div class="d-flex flex-row align-items-center justify-content-around">
                            <h1>Bienvenido a DAIA</h1>
                        </div>
                    </div>
                    <div class="col p-4 align-self-start">
                        <form method="post" action="{{ route('users.destroy', Auth::user()) }}">
                            @csrf
                            @method('delete')
                            <input id="destroy_user" name="destroy_user" class="btn btn-danger btn-lg" placeholder="Usuario"
                                onclick="return confirm('¿Está seguro de que quiere eliminar su cuenta?')" type="submit"
                                value="Borrar cuenta">
                            <br>
                        </form>
                    </div>
                </div>
                <form action="{{ route('users.update', ['user' => Auth::user()]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="container">
                        <div class="row">
                            <div class="col p-4 align-self-center big-text text-secondary border-radius-2">
                                <h2>{{ Auth::user()->user_name }}</h2>
                            </div>
                            <div class="col p-4 align-self-center d-flex flex-column align-items-center"><img class="w-50"
                                    src="{{ asset(Auth::user()->user_avatar) === 'http://daia.test/' ? '/storage/img/no_photo.png' : asset(Auth::user()->user_avatar) }}"
                                    alt="{{ Auth::user()->user_name }}">
                                <label for="avatar" class="form-label">Cambia tu avatar:</label>
                                <input type="file" id="avatar" name="avatar" class="btn btn-secondary m-3"
                                    value="Cambia tu avatar">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-4 align-self-center">
                                <label for="user_email" class="form-label">Email:</label>
                                <br>
                                {{ Auth::user()->email }}
                            </div>
                            <div class="col p-4 align-self-center">
                                <label for="address" class="form-label">Dirección:</label>
                                <br>
                                <input class="login-form__input" type="text" name="address" id="address"
                                    value="{{ Auth::user()->address }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-4 align-self-center">
                                <label for="first_name" class="form-label">Nombre:</label>
                                <br>
                                <input class="login-form__input" type="text" name="first_name" id="first_name"
                                    value="{{ Auth::user()->first_name }}">
                            </div>
                            <div class="col p-4 align-self-center">
                                <label for="las_name" class="form-label">Apellidos:</label>
                                <br>
                                <input class="login-form__input" type="text" name="last_name" id="last_name"
                                    value="{{ Auth::user()->last_name }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-4 align-self-center">
                                <label for="birthday" class="form-label">Fecha de nacimiento:</label>
                                <br>
                                <div>
                                    {{ Auth::user()->birthday }}
                                </div>
                            </div>
                            <div class="col p-4 align-self-center">
                                <label for="user_address" class="form-label">Teléfono:</label>
                                <br>
                                <input class="login-form__input" type="text" name="telephone" id="telephone"
                                    value="{{ Auth::user()->telephone }}" placeholder="{{ Auth::user()->telephone }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-4 align-self-center">
                                <input type="submit" value="Actualiza tus datos" class="btn btn-secondary btn-lg">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @else
        <div class="container justify-content-center text-center align-items-center"></div>
            @foreach ($users as $user)
                <div class="row justify-content-center text-center align-items-center">
                    <div class="col m-1 p-2 d-none d-md-block">
                        <img src="{{ $user->user_avatar }}" width='75'></img>
                    </div>
                    <div class="col m-2 p-3">
                        <h4>{{ $user->user_name }}</h4>
                    </div>
                    <div class="col m-2 p-3 d-none d-lg-block">
                        <h4>{{ $user->first_name }}</h4>
                    </div>
                    <div class="col d-none d-lg-block">
                        <h4>{{ $user->last_name }}</h4>
                    </div>
                    <div class="col d-none d-lg-block">
                        <h4>{{ $user->email }}</h4>
                    </div>
                    <div class="col">
                        <div class="btn-group" role="group" aria-label="Role">
                            <form action="{{ route('users.update', $user) }}" class="d-flex flex-row" method="post">
                                @csrf
                                @method('put')
                                <input type="submit"
                                    class="btn btn-lg {{ $user->role === 'player' ? 'btn-secondary' : 'btn-outline-secondary' }}" id="{{$user->user_name . '_player'}}" name='{{$user->user_name . '_player'}}' value="Player">
                                <input type="submit"
                                    class="btn btn-lg {{ $user->role === 'mod' ? 'btn-warning' : 'btn-outline-warning' }}" id="{{$user->user_name . '_player'}}" name="{{$user->user_name . '_mod'}}" value="Mod">
                                <input type="submit"
                                    class="btn btn-lg {{ $user->role === 'admin' ? 'btn-primary '. $user->user_name === Auth::user()->user_name ? 'disabled' : 'btn-outline-primary' }}" id="{{$user->user_name . '_admin'}}" name='{{$user->user_name . '_admin'}}' value="Admin">
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endauth
@endsection
