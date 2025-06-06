@extends('layout')

@section('title', 'DAIA - Shop')

@section('content')
    <div class="container">
        <div id="event_shop_carousel" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators" id="list_events">
                @foreach ($events as $event)
                    <li data-target="#event_shop_carousel" data-slide-to="{{ $loop->index }}"
                        {{ $loop->first ? 'class="active"' : '' }}></li>
                @endforeach
            </ul>
            <div class="carousel-inner" id="inside_event_carousel">
                @foreach ($events as $event)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-interval="24000">
                        <a href="{{ route('events.show', $event) }}"><img src="{{ $event->event_img }}"
                                alt="{{ $event->event_name }}" width="1100" height="500"></a>
                        <div class="carousel-caption">
                            <a href="{{ $event->external_url }}" class="text-white">
                                <h3>{{ $event->event_name }}</h3>
                            </a>
                            <p>{{ $event->event_desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#event_shop_carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#event_shop_carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
@endsection
