@extends('layout')

@section('title', '404')

@section('welcome')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center justify-items-center">
                    <video src="storage/video/throwing.mp4" id="video404">Lanza los dados de nuevo, Sam</video>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Opciones para el vídeo:
        const video = document.getElementById('video404');

        video.muted = true;
        video.play();
        video.loop = true;
        video.controls = false;
        video.addEventListener('contextmenu', (el) => {
            el.preventDefault();
            return false;
        });
    </script>
@endsection
