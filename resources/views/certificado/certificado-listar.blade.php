@extends('plantilla')

@section('titulo', "Listado de alumnos")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item">Legajo</li>
    <li class="breadcrumb-item active">Alumnos</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" onclick="abrirAgregarCertificado();" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/certificados");'><span>Recargar</span></a></li>
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
            <th>Certificado</th>
            <th>Nro documento</th>
            <th>Nombre y apellido</th>
            <th>Fecha de aprobación</th>
            <th>Nota</th>
        </tr>
    </thead>
</table> 

<!-- Modal -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:750px;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Domicilio</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                     <div class="form-group col-lg-2">
                        <label>Alumno:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select id="lstAlumno" name="lstAlumno" class="form-control selectpicker" data-live-search="true">
                            <option value="" disabled selected>Seleccionar</option>
                            @for ($i = 0; $i < count($array_alumno); $i++)
                                <option value="{{ $array_alumno[$i]->idalumno }}">{{ $array_alumno[$i]->nombre }} {{ $array_alumno[$i]->apellido }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Calificación:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select id="lstCalificacion" name="lstCalificacion" class="form-control">
                            <option value="11">Aprobado</option>
                            <option value="12">Reprobado</option>
                            <option value="13">Ausente</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Fecha de aprobaciòón:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="date" name="txtFecha" id="txtFecha" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarCertificadoGrilla();">Agregar</button>
            </div>
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
	    "ajax": "{{ route('certificado.cargarGrilla') }}"
	});

    function abrirAgregarCertificado() {
        $('#modalAgregar').modal('toggle');
    }

    function agregarCertificadoGrilla(){
         idAlumno = $("#lstAlumno option:selected").val();
         fecha = $("#txtFecha").val();
         calificacion = $("#lstCalificacion option:selected").val();
         $.ajax({
            type: "GET",
            url: "{{ asset('certificado/guardar') }}",
            data: { 
                idAlumno:idAlumno, 
                fecha:fecha, 
                calificacion:calificacion 
            },
            async: true,
            dataType: "json",
            success: function (data) {
                if(data.ESTADO == "success"){
                    msgShow("Certificado agregado", "success");    
                } else {
                    msgShow("Error al agregar el certificado", "danger");   
                }
                $('#modalAgregar').modal('toggle');
            }
        });
    }
</script>
@endsection