@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($menu->idmenu) && $menu->idmenu > 0 ? $menu->idmenu : 0; ?>';
    <?php $globalId = isset($menu->idmenu) ? $menu->idmenu : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/tramite/nuevo">Trámites</a></li>
    <li class="breadcrumb-item active">Nuevo Calculo de Vacaciones</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/tramite/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/Tramites/iniciados";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
        <div id = "msg"></div>
        <?php
        if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
        }
        ?>
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre y Apellido del Trabajador: *</label>
                    <input type="text" id="txtNombre" name="txtNombreTrabajador" class="form-control" 
                    value="{{$calculoVacaciones->nombreyapellidodeltrabajor or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>No. Cedula de Identidad del Trabajador: *</label>
                    <input class="form-control" type="text" placeholder="" name="txtCedula" id="txtCedula"
                    value="{{$calculoVacaciones->numerodeceduladeidentidad or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Cargo que ocupa en la empresa: *</label>
                    <input class="form-control" type="text" placeholder="" name="txtCargo" id="txtCargo"
                    value="{{$calculoVacaciones->cargoqueocupaenlaempresa or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha de Ingreso: *</label>
                    <input class="form-control" type="date" placeholder="" name="txtFechaIngreso" id="txtFechaIngreso"
                    value="{{$calculoVacaciones->fechadeingreso or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha de Salida de Vacaciones: *</label>
                    <input class="form-control" type="date" placeholder="" name="txtFechaSalida" id="txtFechaSalida"
                    value="{{$calculoVacaciones->fechadesalidadevacaciones or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Ultimo Salario Devengado: *</label>
                    <input class="form-control" type="text" placeholder="" name="txtUltimoSalario" id="txtUltimoSalario"
                    value="{{$calculoVacaciones->ultimosalariodevengado or ''}}" required>
                </div>
                 <div class="form-group col-lg-6">
                    <label>Nombre del Solicitante: *</label>
                    <input class="form-control" type="text" placeholder="" name="txtNombreSolicitante" id="txtNombreSolicitante"
                    value="{{$calculoVacaciones->nombredelsolicitante or ''}}" required>
                </div>
            </div>
        </form>
</div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">¿Deseas eliminar el registro actual?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
          </div>
        </div>
      </div>
    </div>
<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('sistema/menu/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }

</script>
@endsection