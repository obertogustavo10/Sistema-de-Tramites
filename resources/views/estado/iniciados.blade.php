@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Men&uacute;</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/sistema/menu/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/sistema/menu");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<div id = "msg"></div>
<?php
if (isset($msg)) {
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Razon Social</th>
            <th>Documento</th>
            <th>Estado</th>
            <th>Fecha de Inicio</th>
            <th>Rectificativa</th>
            <th>Accion</th>
        </tr>
    </thead>
</table> 
<div id="modalRechazar" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rechazar trámite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea name="txtMensajeRechazo" id="txtMensajeRechazo" cols="30" style="height: 115px !important;" class="form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="fProcesarRechazo()">Rechazar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        "order": [[ 2, "asc" ]],
	    "ajax": "{{ route('tramitesiniciados.cargarGrilla') }}"
	});

    function fTramiteProcesar(idTramite){
        $.ajax({
	            type: "GET",
	            url: "{{ asset('tramite/tramiteProcesar') }}",
	            data: { id:idTramite },
	            async: true,
	            dataType: "json",
	            success: function (respuesta){
                    $("#grilla").DataTable().ajax.reload();
	                msgShow(respuesta.MSG, respuesta.ESTADO);
	            }
        });
    }
    
    function fTramiteFinalizar(idTramite){
        $.ajax({
	            type: "GET",
	            url: "{{ asset('tramite/tramiteFinalizar') }}",
	            data: { id:idTramite },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
                    $("#grilla").DataTable().ajax.reload()
	                 msgShow(respuesta.MSG, respuesta.ESTADO);
	            }
	    });
    }

    function fTramiteAnular(idTramite){
        $.ajax({
	            type: "GET",
	            url: "{{ asset('tramite/tramiteAnular') }}",
	            data: { id:idTramite },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
                    $("#grilla").DataTable().ajax.reload()
	                 msgShow(respuesta.MSG, respuesta.ESTADO);
	            }
	    });
    }

    function fTramiteRechazar(){
        $("#modalRechazar").modal('toggle');
    }

    function fProcesarRechazo(){
        mensaje = $("#txtMensajeRechazo").val();
        $.ajax({
	            type: "GET",
	            url: "{{ asset('tramite/tramiteRechazar') }}",
	            data: { 
                    id:idTramite,
                    mensaje:mensaje
                },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
                    $("#grilla").DataTable().ajax.reload()
	                 msgShow(respuesta.MSG, respuesta.ESTADO);
	            }
	    });
    }
	
</script>
@endsection