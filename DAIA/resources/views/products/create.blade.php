@extends('layout')

@section('title', 'Index')

@section('welcome')
    <div class="container-fluid d-flex justify-content-center login">
        <div class="login-form d-flex flex-column align-items-center justify-content-center text-center papyrus mt-lg-6rem">
            <h1 id="loginMsg" class="login-text text-secondary">Es hora de registrar un producto:</h1>
            <form method="post" enctype="multipart/form-data" action="{{ route('products.store') }}">
                @csrf
                <br>
                <label class="form-label" for="user_name">Nombre del evento</label>
                <br>

                <input id="prod_name" name="prod_name" class="login-form__input" placeholder="Nombre del producto"
                    type="text" value="{{ old('prod_name') }}">
                @if ($errors->has('prod_name'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('prod_name') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>

                @endif
                <br>
                <label class="form-label" for="product_desc">Descripción</label>
                <br>
                <input id="product_desc" name="product_desc" class="login-form__input" placeholder="Tremenda descripción"
                    type="text" value="{{ old('product_desc') }}">
                <br>
                <label class="form-label" for="prod_img">Foto o imagen para patrocinar el producto</label>
                <br>
                <input id="prod_img" name="prod_img" class="login-form__input" placeholder="Fotico" type="file">

                <input id="prod_price" name="prod_name" class="login-form__input" placeholder="Nombre del producto"
                    type="text" value="{{ old('prod_name') }}">
                @if ($errors->has('prod_name'))
                    <div class="login-form__span-error">
                        @foreach ($errors->get('prod_name') as $error)
                            <div> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="d-grid mt-3 gap-2 col-8 mx-auto">
                    <input id="btnSubmit" type="submit" class="paper btn btn-lg btn-secondary px-4rem mb-3"
                        value="Regístrate">
                </div>
            </form>
        </div>
    </div>
@endsection
