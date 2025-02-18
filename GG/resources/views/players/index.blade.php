@extends('layout')

@section('title', 'Index')
@section('content')
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mx-auto">
        @forelse ($players as $player)
            @if ($player->visible === 1)
                <div class="container d-flex flex-column justify-content-center align-items-center mx-auto px-4 py-6">
                    <div class="container mx-auto px-4 py-6">
                        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
                            <!-- Avatar -->
                            <div class="d-flex justify-content-center mb-4">
                                <img src="{{ $player->avatar ? asset('img/' . $player->avatar) : asset('img/GG_Icon.png') }}"
                                    alt="Avatar de {{ $player->name }}"
                                    class="w-32 h-32 rounded-full border-4 border-gray-300">
                            </div>

                            <!-- Información del Jugador -->
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $player->name }}</h2>
                                <p class="text-gray-600 text-sm">{{ ucfirst($player->position) }} - {{ $player->age }} años
                                </p>
                            </div>

                            <!-- Redes Sociales -->
                            <div class="d-flex justify-content-center gap-4 my-4">
                                <a href="{{ $player->twitter }}" class="text-blue-500 hover:underline"
                                    target="_blank">Twitter</a>
                                <a href="{{ $player->instagram }}" class="text-pink-500 hover:underline"
                                    target="_blank">Instagram</a>
                                <a href="{{ $player->twitch }}" class="text-purple-500 hover:underline"
                                    target="_blank">Twitch</a>
                            </div>

                            <!-- Botón de Regreso -->
                            <div class="mt-6 text-center">
                                <a href="{{ route('players.index') }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Volver a la lista
                                </a>
                            </div>
                        </div>
                    </div>
            @endif
        @empty
            <div class="container-fluid">
                <div class="container-fluid d-flex m-auto align-items-center justify-content-center p-3">
                    <h1>¡No se ha conseguido ningún jugador!</h1>
                </div>
                <div class="container-fluid d-flex m-auto align-items-center justify-content-center w-50">
                    <img class="w-75 h-75" src="img/GG_Icon.png" alt="GG_Logo">
                </div>
            </div>
        @endforelse
    @endsection
