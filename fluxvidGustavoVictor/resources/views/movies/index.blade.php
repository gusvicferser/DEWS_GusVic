@extends('layout')

@section('title', 'Listado de películas')

@section('welcome')
    <h1>Listado de películas</h1>
    <div class="movies">
        @forelse($movies as $movie)
            <div class="movie">
                <div class="mTitle">
                    <span>
                        <a href="{{ route('movies.show', $movie) }}">
                            {{ $movie->title }}
                        </a>
                    </span>
                    <span>
                        (
                        <a href="{{ route('directors.show', $movie->director)}}">
                            {{ $movie->director->name }}
                        </a>
                        )
                    </span>
                    </div>
                <div class="mYear">{{ $movie->year }}</div>
                <div class="mPlot">{{ $movie->plot }}</div>
                <div class="mRating">{{ $movie->rating }}</div>
            </div>
            <br>
        @empty
            <div class="movie">
                <div class="empty">No hay ninguna película que mostrar</div>
            </div>
        @endforelse
    </div>

    {{ $movies->links() }}
@endsection
