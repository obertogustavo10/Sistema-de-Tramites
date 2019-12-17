
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
<form class="form" method="post">
        <div class="row">
            <div class="col-sm-12">
                <label for="txtNombreMadre">Nombre de la Madre/Tutora:</label>
                <input type="text" name="txtNombreMadre" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="txtNombrePadre">Nombre del Padre/Tutor:</label>
                <input type="text" name="txtNombrePadre" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="txtNombreMenor">Nombre del/la Menor:</label>
                <input type="text" name="txtNombreMenor" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="lstAcomp">Viaja:</label>
                <select name="lstAcomp">    
                    <option disabled select>Seleccionar</option>
                    <option value="">Solo/a</option>
                    <option value="">Acompañada/o del Padre, Madre y/o Tutor/a </option>
                </select>           
            </div>
        </div>
        <div class="row">
            <div col-sm-12>
                <label for="lstPais">Viaja a:</label>
                <select name="lstPais">
                    <optgroup label="País">
                        <option>Todos los paises del mundo</option>
                        <optgroup>
                            <option  disabled selected>Seleccionar pais</option>
                            <option>Argentina</option>
                            <option>Brasil</option>
                        </optgroup>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="txtTiempo">Hasta:</label>
                <select name="txtTiempo">
                    <optgroup>
                        <option>Hasta la mayoría de edad</option>
                    </optgroup>
                </select>
                <select>
                    <optgroup>
                            <option  disabled selected>Fecha</option>
                            <option label="Definir fecha" for="fecha"><input type="text" name="fecha"></option>
                    </optgroup>
                </select>
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