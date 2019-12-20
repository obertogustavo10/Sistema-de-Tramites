@extends('plantilla')

@section('titulo', "Nuevo Trámite")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>

<div class="container">
    <div class="row m-auto p-3">
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
    </div>
    @foreach ($tramites as $tramite)   
    <div class="row m-auto p-3">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">{{ $tramite['nombre'] }}</h5>
                <p class="card-text">{{ $tramite['descripcion'] }}</p>
                <a href="{{ $tramite['url'] }}" class="btn btn-primary float-right">Iniciar Trámite</a>
            </div>
        </div>
    </div>
    @endforeach
</div>    

@endsection