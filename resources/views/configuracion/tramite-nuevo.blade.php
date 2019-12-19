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
@foreach ($tramites as $tramite)
    <div class="card w-75">
        <div class="card-body">
            <h5 class="card-title">{{ $tramite['nombre'] }}</h5>
            <p class="card-text">{{ $tramite['descripcion'] }}</p>
            <a href="{{ $tramite['url'] }}" class="btn btn-primary">Iniciar Trámite</a>
        </div>
    </div>
</div>
<script>
	var dataTable = $('#grilla').DataTable({
	    "processing": true,
        "serverSide": true,
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25,
        "order": [[ 0, "asc" ]],
	    "ajax": "{{ route('formulario.cargarGrilla') }}"
	});
</script>
@endsection