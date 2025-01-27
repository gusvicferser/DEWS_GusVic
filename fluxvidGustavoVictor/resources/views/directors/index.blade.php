@extends('layout')

@section('title', 'Listado de directores')

@section('welcome')
    <h1>Listado de directores</h1>
    <div class="directors">
        @forelse($directors as $director)
            <div class="director">
                <div>
                    <a
                        href="{{ route('directors.show', $director) }}">
                            {{ $director->name }}
                        </a>
                    </div>
                <div>{{ $director->birthday }}</div>
                <div>{{ $director->nationality }}</div>
            </div>
            <br>
        @empty
            <div class="director">
                <div class="empty">No hay ningún director que mostrar</div>
            </div>
        @endforelse
    </div>

    {{ $directors->links() }}
@endsection
