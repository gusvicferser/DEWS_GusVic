@extends('layout')

@section('title', 'DAIA Account')

@section('content')
    <!-- Container -->
    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <div class="">

                        <h1>Bienvenido a DAIA</h1>
                    </div>

                    <div class="">
                        <form method="post" action="{{ route('user.destroy', Auth::user())}}">
                            @csrf
                            @method('delete')
                            <input id="destroy_user" name="destroy_user" class="" placeholder="Usuario" type="submit"
                                value="Borrar cuenta">
                            <br>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
