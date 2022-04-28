@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Menu') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <a class="btn btn-dark" href="autores">Registro Autores</a>
                    <a class="btn btn-dark" href="libros">Registro Libros</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection