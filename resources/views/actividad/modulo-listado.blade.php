@extends('plantilla')

@section('titulo', "Listado de módulos")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item">Actividad</li>
    <li class="breadcrumb-item active">Módulos</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/modulo/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/actividad/modulos");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Nombre corto</th>
            <th>Descripción Plan</th>
            <th>Nombre Plan</th>
        </tr>
    </thead>
</table> 
<script>
    var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "bInfo": true,
        "bSearchable": true,
        "pageLength": 25,
        "ajax": "{{ route('modulo.cargarGrilla') }}"
    });
</script>
@endsection