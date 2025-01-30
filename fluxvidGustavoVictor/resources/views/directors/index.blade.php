@extends('layout')

@section('title', 'Listado de directores')

@section('welcome')
    <h1>Listado de directores</h1>
    <div class="directors">
        @forelse($directors as $director)
            <div class="director">
                <div>
                    <a href="{{ route('directors.show', $director) }}">
                        {{ $director->name }}
                    </a>
                </div>
                <div>{{ $director->birthday }}</div>
                <div>{{ $director->nationality }}</div>
                <h4>Películas del director {{ $director->name }}</h4>
                @forelse($director->movies as $movie)
                    <div class="movie">
                        <div class="mTitle">
                            <span>
                                <a href="{{ route('movies.show', $movie) }}">
                                    {{ $movie->title }}
                                </a>
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
            <div>---------------------------------------------------------</div>
            <br><br>
        @empty
            <div class="director">
                <div class="empty">No hay ningún director que mostrar</div>
            </div>
        @endforelse
    </div>

    {{ $directors->links() }}
@endsection
