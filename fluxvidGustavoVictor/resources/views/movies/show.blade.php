@extends('layout')

@section('title', 'Ficha de la película {{$id}}')

@section('welcome')
    <h1>Ficha de la película  {{$id}}</h1>

    <div>
        <a href="{{route('movies.edit', $id)}}">Editar película</a>
    </div>
@endsection

