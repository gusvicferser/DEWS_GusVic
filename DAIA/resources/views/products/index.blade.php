@extends('layout')

@section('title', 'DAIA - Shop')

@section('content')
    <div class="container">
        <div id="product_shop_carousel" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators" id="list_products">
                @foreach ($products as $product)
                    <li data-target="#product_shop_carousel" data-slide-to="{{ $loop->index }}"
                        {{ $loop->first ? 'class="active"' : '' }}></li>
                @endforeach
            </ul>
            <div class="carousel-inner" id="inside_product_carousel">
                @foreach ($products as $product)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-interval="24000">
                        <a href="{{route('products.show', $product)}}"><img src="{{ $product->prod_img }}" alt="{{ $product->prod_name }}" width="1100" height="500"></a>
                        <div class="carousel-caption">
                            <h3>{{ $product->prod_name }}</h3>
                            <p>{{ $product->prod_desc }}</p>
                            <h2>{{ $product->prod_price }}</h2>
                            <p>En stock: {{ $product->prod_stock }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#product_shop_carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#product_shop_carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
@endsection
