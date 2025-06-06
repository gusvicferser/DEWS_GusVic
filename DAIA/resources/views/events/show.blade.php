@extends('layout')

@section('title', 'DAIA')

@section('content')

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">{{ $event->event_name }}</h1>
            <p class="lead font-weight-normal">{{ $event->event_desc }}</p>
            <a class="btn btn-outline-secondary" href="{{ $event->external_url }}">Pronto... en sus pantallas...</a>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
@endsection
