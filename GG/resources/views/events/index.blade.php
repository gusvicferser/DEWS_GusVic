@extends('layout')

@section('title', 'Index')

@section('content')
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mx-auto">
        <div class="container d-flex flex-column justify-content-center align-items-center mx-auto px-4 py-6"
            id="eventContainer">
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/events.js') }}"></script>
@endsection
