@extends('layout')

@section('title', $movie->title .' - FluxVid')

@section('welcome')
    <h1>Ficha de la película {{$movie->title}}</h1>

    <div class="movie">
        <div class="mTitle">{{ $movie->title }}</div>
        <div class="mYear">{{ $movie->year }}</div>
        <div class="mPlot">{{ $movie->plot }}</div>
        <div class="mRating">{{ $movie->rating }}</div>
        <form
            action="{{route('movies.destroy', ['movie' => $movie->id])}}"
            method="post"
        >
        @csrf
        @method('delete')
        <input type="submit" value="Eliminar">
        </form>
    </div>
    <div>
        <a href="{{route('movies.index')}}">Volver al index</a>
    </div>
@endsection

