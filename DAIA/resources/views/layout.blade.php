<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('styles')
    <title>@yield('title')</title>
</head>
<body>
    @include('partials.navbar')

    @yield('welcome')

    @yield('content')

    @include('partials.footer')

    @yield('script')
</body>
</html>
