@extends('layout')

@section('title', $director->title .' - FluxVid')

@section('welcome')
    <h1>Ficha del director {{$director->title}}</h1>

    <div class="director">
        <span>{{ $director->name }}</span>
        <span>{{ date('(d - m - y)', strtotime($director->birthday)) }}</span>
        <span>{{ $director->nationality }}</span>
    </div>
    <br><br>
    <div>
        <a href="{{route('directors.index')}}">Volver al index</a>
    </div>
@endsection
