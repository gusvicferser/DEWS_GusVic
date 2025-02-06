@extends('layout')

@section('title', {{$movie->title}})

@section('welcome')
    <h1>Película {{$movie->title}} guardada</h1>
@endsection

