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
    <li class="breadcrumb-item"><a href="/sistema/menu">Men&uacute;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/cliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/sistema/menu";
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
                    <label>Nombre:</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$menu->nombre or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Persona:</label>
                    <select id="lstPersona" name="lstPersona" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                        <option value="1">Persona Física</option>
                        <option value="2">Persona Jurídica</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Razón social:</label>
                    <input type="text" id="txtRazonSocial" name="txtRazonSocial" class="form-control" value="{{$menu->razonsocial or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Documento:</label>
                    <input type="text" id="txtDocumento" name="txtDocumento" class="form-control" value="{{$menu->documento or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Tipo de Documento:</label>
                    <select id="lstTipoDocumento" name="lstTipoDocumento" class="form-control" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="1">CUIT/CUIL</option>
                        <option value="2">RIF</option>
                        <option value="3">DNI</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Mail:</label>
                    <input type="text" id="txtMail" name="txtMail" class="form-control" value="{{$menu->mail or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Domicilio:</label>
                    <input type="text" id="txtDomicilio" name="txtDomicilio" class="form-control" value="{{$menu->domicilio or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Tipo de Domicilio:</label>
                    <select id="lstTipoDomicilio" name="lstTipoDomicilio" class="form-control" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="1">Real</option>
                        <option value="2">Legal</option>
                        <option value="3">Comercial</option>
                    </select>
                </div>
                 <div class="form-group col-lg-6">
                    <label>Teléfono:</label>
                    <input type="text" id="txtTel" name="txtTel" class="form-control" value="{{$menu->tel or ''}}" placeholder="00-0000-0000">
                </div>
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
