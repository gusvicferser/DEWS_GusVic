@extends('layout')

@section('title', 'DAIA')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">

                <div class="d-flex align-items-center justify-items-center">
                    <video src="storage/video/throwing.mp4" id="video_amazing">Lanza los dados de nuevo, Sam</video>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col">

                    <div id="event_carousel" class="carousel slide" data-ride="carousel">
                        <ul class="carousel-indicators" id="list_events">
                        </ul>
                        <div class="carousel-inner" id="inside_event_carousel">
                        </div>
                        <a class="carousel-control-prev" href="#event_carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#event_carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col">

                    <div id="product_carousel" class="carousel slide" data-ride="carousel">
                        <ul class="carousel-indicators" id="list_products">
                        </ul>
                        <div class="carousel-inner" id="inside_product_carousel">
                        </div>
                        <a class="carousel-control-prev" href="#product_carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#product_carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="storage/js/index.js"></script>
@endsection
