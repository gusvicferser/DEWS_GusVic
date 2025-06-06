@extends('layout')

@section('title', 'Index')

@section('welcome')
    <div class="container-fluid d-flex justify-content-center login">
        <div class="login-form d-flex flex-column align-items-center justify-content-center text-center papyrus mt-lg-6rem">
            <h1 id="loginMsg" class="login-text text-secondary">Es hora de registrar un evento:</h1>
            <form method="post" enctype="multipart/form-data" action="{{ route('events.store') }}">
                @csrf
                <br>
                <label class="form-label" for="user_name">Nombre del evento</label>
                <br>

                <input id="event_name" name="event_name" class="login-form__input" placeholder="Nombre del evento"
                    type="text" value="{{ old('event_name') }}">
                @if ($errors->has('event_name'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('event_name') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>

                @endif
                <br>
                <label class="form-label" for="event_desc">Descripción</label>
                <br>
                <input id="event_desc" name="event_desc" class="login-form__input" placeholder="Tremenda descripción"
                    type="text" value="{{ old('event_desc') }}">
                <br>
                <label class="form-label" for="event_img">Foto o imagen para patrocinar el evento</label>
                <br>
                <input id="event_img" name="event_img" class="login-form__input" placeholder="Fotico" type="file">

                <br>
                <label class="form-label" for="external_url">Enlace Externo (si lo hay)</label>
                <br>
                <input class="login-form__input" id="external_url" name="external_url" placeholder="URL" type="text">
                <br>

                <div class="d-grid mt-3 gap-2 col-8 mx-auto">
                    <input id="btnSubmit" type="submit" class="paper btn btn-lg btn-secondary px-4rem mb-3"
                        value="Regístrate">
                </div>
            </form>
        </div>
    </div>
@endsection
