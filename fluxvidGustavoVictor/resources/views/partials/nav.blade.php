@extends('index');

@section('nav')
    <nav>
        <span>
            <a href="{{ route('index') }}">Inicio</a>
        </span>
        <span>
            <a href="{{ route('movies') }}">Listado de películas</a>
        </span>
    </nav>
@endsection
