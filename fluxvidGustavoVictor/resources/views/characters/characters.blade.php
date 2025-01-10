<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Characters</title>
</head>

<body>
    {{-- Div para el contenedor--}}
    <div class="container">

        {{-- For each para cada personaje --}}
        @foreach ($characters as $character)
        {{-- Al comenzar el if si es divisible por cero le dejamos entrar --}}
                @if ($loop->index % 3 == 0)
                {{-- Si es la primera iteración no cerramos el div --}}
                @unless ($loop->first)
    </div>
                @endunless
                {{-- Para todo lo demás, que serán múltiplos de 3, una nueva línea --}}
                <div class="line">
            @endif

            {{-- Un span para cada personaje --}}
            <div class="character">
                {{-- For each para mostrar todas las características --}}
                <img src="{{ $character['img'] }}" alt="{{ $character['img'] }}">
                @foreach ($character as $key => $property)
                    <div id="{{ $key . substr($character['name'], 0, 3) }}">
                        {{-- Si la propiedad es la imagen, ponemos una img --}}
                        @unless ($key == 'img')
                            {{ $property }}
                        @endunless
                    </div>
                @endforeach
                </div>
            {{-- En la última iteración, cerramos la última línea de 'line' --}}
            @if ($loop->last)
            </div>
    @endif
    @endforeach
    </span>
</body>

</html>
