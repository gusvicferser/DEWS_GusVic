@extends('layout')

@section('title', 'Index')

@section('content')
<div class="max-w-3xl mx-auto bg-grey shadow-md rounded-lg p-6">
    <!-- Nombre del Evento -->
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">{{ $event->name }}</h2>

    <!-- Información del Evento -->
    <div class="bg-gray-100 p-4 rounded-lg mb-4">
        <p class="text-gray-700"><strong>📍 Ubicación:</strong> {{ $event->location }}</p>
        <p class="text-gray-700"><strong>📅 Fecha:</strong>
            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
        <p class="text-gray-700"><strong>⏰ Hora:</strong>
            {{ \Carbon\Carbon::parse($event->hour)->format('H:i') }}</p>
        <p class="text-gray-700"><strong>🎭 Tipo:</strong>
            <span
                class="px-3 py-1 rounded-full text-white text-sm
    {{ $event->type == 'official' ? 'bg-blue-500' : ($event->type == 'exhibition' ? 'bg-yellow-500' : 'bg-green-500') }}">
                {{ ucfirst($event->type) }}
            </span>
        </p>
    </div>

    <!-- Descripción -->
    <div class="mb-4">
        <h3 class="text-xl font-semibold text-gray-700">📖 Descripción</h3>
        <p class="text-gray-600 mt-2">{{ $event->description }}</p>
    </div>

    <!-- Tags -->
    <div class="mb-4">
        <h3 class="text-xl font-semibold text-gray-700">🏷️ Tags</h3>
        <div class="flex flex-wrap mt-2">
            @foreach (explode(',', $event->tags) as $tag)
                <span class="bg-gray-300 text-gray-700 text-sm px-3 py-1 rounded-full mr-2 mb-2">
                    #{{ trim($tag) }}
                </span>
            @endforeach
        </div>
    </div>

    <!-- Botón de Regreso -->
    <div class="mt-6 text-center">
        <a href="{{ route('events.index') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Volver a la lista de eventos
        </a>
    </div>
</div>
</div>
@endif
@empty
<div class="container-fluid">
<div class="container-fluid d-flex m-auto align-items-center justify-content-center p-3">
    <h1>¡No se ha conseguido ningún evento!</h1>
</div>
<div class="container-fluid d-flex m-auto align-items-center justify-content-center w-50">
    <img class="w-75 h-75" src="img/GG_Icon.png" alt="GG_Logo">
</div>
</div>
@endforelse
@endsection
