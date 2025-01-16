@extends('layout')

@section('title', 'Ficha de la película {{$movie_id}}')

@section('welcome')
    <h1>Ficha de la película  {{$movie_id}}</h1>

    <div>
        <a href="{{route('movies.edit', compact('movie_id'))}}">Editar película</a>
    </div>
@endsection

