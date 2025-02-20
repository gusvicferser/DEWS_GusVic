@extends('layout')

@section('title', 'Index')
@section('content')
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mx-auto">
        <div class="container d-flex flex-column justify-content-center align-items-center mx-auto px-4 py-6">
            <div class="container mx-auto px-4 py-6">
                <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
                    <!-- Avatar -->
                    <div class="d-flex justify-content-center mb-4">
                        <img width="200" height="200" src="{{ $user->avatar ? asset('img/' . $user->avatar) : asset('img/GG_Icon.png') }}"
                            alt="Avatar de {{ $user->name }}" class="w-32 h-32 rounded-full border-4 border-gray-300">
                    </div>

                    <!-- Información del Jugador -->
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-800">Nombre: {{ $user->name }}</h2>
                        <h2 class="text-2xl font-bold text-gray-800">Email: {{ $user->email }}</h2>
                        <h2 class="text-2xl font-bold text-gray-800">Cumpleaños: {{ $user->birthday }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
