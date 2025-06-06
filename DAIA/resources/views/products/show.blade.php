@extends('layout')

@section('title', 'DAIA')

@section('content')
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <img src="{{$product->prod_img}}" alt="{{$product->prod_name}}">
            <h1 class="display-4 font-weight-normal">{{ $product->prod_name }}</h1>
            <p class="lead font-weight-normal">{{ $product->prod_desc }}</p>
            <button> Pronto... en sus pantallas...</button>
            <h2 class="display-5 font-weight-big">{{ $product->prod_price }}</h2>

        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
@endsection
