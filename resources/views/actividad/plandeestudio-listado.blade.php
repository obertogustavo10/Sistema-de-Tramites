@extends('plantilla')

@section('titulo', "Planes de estudio")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item">Actividad</li>
    <li class="breadcrumb-item active">Planes de estudio</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/plan/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/actividad/planes");'><span>Recargar</span></a></li>
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
            <th>Actividad</th>
            <th>Nombre del Plan</th>
            <th>Nombre corto</th>
            <th>Vigencia desde</th>
            <th>Vigencia hasta</th>
        </tr>
    </thead>
</table> 
<script>
    var col_actividad = 0;
    var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "bInfo": true,
        "bSearchable": true,
        "pageLength": 25,
        "ajax": "{{ route('plandeestudio.cargarGrilla') }}",
        "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
     
                api.column(col_actividad, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group" style="background-color: #ddd !important;"><td colspan="5">'+group+'</td></tr>'
                        );
     
                        last = group;
                    }
                });
            },
        "columnDefs": [
            {
                "targets": [0],
                "width": 500,
                "visible": false
            },
            {
                "targets": [1],
                "width": 200
            },
             {
                "targets": [2],
                "width": 60
            },
            {
                "targets": [3],
                "width": 90,
                "searchable": false
            },
            {
                "targets": [4],
                "width": 90,
                "searchable": false
            },
        ],
    });

</script>
@endsection