@extends('layout')

@section('title', 'Index')

@section('content')
    <div class="container-fluid">
        <div class="container-fluid d-flex m-auto align-items-center justify-content-center">
            <img width="200" height="200" src="img/GG_Icon.png" alt="GG_Logo">
        </div>
        <div class="container-fluid d-flex m-auto align-items-center justify-content-center p-3">
            <h1>Donde nos encontramos</h1>
        </div>
        <div class="container-fluid d-flex m-auto align-items-center justify-content-center">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3079.8184574988277!2d-0.34060742358878376!3d39.47342981251027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd60f0b2511761b5%3A0x40747fcf97fa41e9!2sIES%20Serpis!5e0!3m2!1ses!2ses!4v1739903211478!5m2!1ses!2ses"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection
