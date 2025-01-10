<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Characters</title>
</head>

<body>
    <div class="container">
        @foreach ($characters as $character)
            @if ($loop->index % 3 == 0 || $loop->index == 0)
                <div class="line">
            @endif

            <span class="character">
                @foreach ($character as $key => $property)
                    <div id="{{ $key . substr($character['name'], 0, 3) }}">
                        @if ($key == 'img')
                            <img src="{{ $property }}" alt="{{ $property }}">
                        @else
                            {{ $key . ':' . $property }}
                        @endif
                    </div>
                @endforeach
                </span>

            @if ($loop->index % 3 == 0 || $loop->index == 1)
    </div>
    @else
    @continue
    @endif
    @endforeach
    </div>
</body>

</html>
