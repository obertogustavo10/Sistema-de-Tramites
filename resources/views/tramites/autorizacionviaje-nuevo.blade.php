
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
    <li class="breadcrumb-item"><a href="/tramite/nuevo">Nuevo Trámite</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/sistema/menu/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
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
                    <label for="txtNombreMadre">Nombre de la Madre/Tutora:</label>
                    <input type="text" id="txtNombreMadre" name="txtNombreMadre" class="form-control" value="{{$autorizacionViaje->txtNombreMadre or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtNombrePadre">Nombre del Padre/Tutor:</label>
                    <input type="text" id="txtNombrePadre" name="txtNombrePadre" class="form-control" value="{{$autorizacionViaje->txtNombrePadre or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtNombreMenor">Nombre del/la Menor:</label>
                    <input type="text" id="txtNombreMenor" name="txtNombreMenor" class="form-control" value="{{$autorizacionViaje->txtNombreMenor or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                </select>
                    <label for="lstAcomp">Viaja:</label>
                    <select id="lstAcomp" name="lstAcomp" class="form-control" value="{{$autorizacionViaje->lstAcomp or ''}}" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="1">Solo/a</option>
                        <option value="2">Acompañada/o del Padre, Madre y/o Tutor/a </option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="lstPais">Viaja a:</label>
                    <select id="lstPais" name="lstPais" class="form-control" value="{{$autorizacionViaje->lstPais or ''}}" required>
                        <optgroup label="País">
                            <option value="1">Todos los paises del mundo</option>
                            <optgroup label="Seleccionar País">
                                <option value="2">Argentina</option>
                                <option value="3">Brasil</option>
                            </optgroup>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="txtTiempo">Hasta:</label>
                    <select name="txtTiempo" label="fecha" class="form-control" value="{{$autorizacionViaje->txtTiempo or ''}}" required>
                        <option value="1">Hasta la mayoría de edad</option>
                        <option value="2">Definir fecha</option><input type="text" name="fecha"></option>    
                    </select>
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
