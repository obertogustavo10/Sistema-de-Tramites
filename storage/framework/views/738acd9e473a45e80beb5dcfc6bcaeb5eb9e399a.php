<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    globalId = '<?php echo isset($menu->idmenu) && $menu->idmenu > 0 ? $menu->idmenu : 0; ?>';
    <?php $globalId = isset($menu->idmenu) ? $menu->idmenu : "0"; ?>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
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
        <form id="datosPoder" method="POST">
            <div class="row">
                <div class="col-sm-4">
                    <h3><label for="tipoDePoder">Tipo de Poder</label></h3>
                    <select class="form-control" name="tipoDePoder" id="tipoDePoder">
                        <option selected value="1">Venta</option>
                        <option selected value="2">Adminitracion y Disposicion</option>
                        <option selected value="3">Judicial</option>
                        <option selected=""></option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <h3>Datos del Poderdante</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5><label for="nombrePoderdante">Nombre Completo</label></h5>
                    <input type="text" class="form-control" name="nombrePoderdante" id="nombrePoderdante">
                </div>
                <div class="col">
                    <h5><label for="fechaPoderdante">Fecha de Nacimiento</label></h5>
                    <input type="date" class="form-control" name="fechaPoderdante" id="fechaPoderdante">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <h5><label for="cuilPoderdante">CUIL</label></h5>
                    <input type="cuilPoderdante" class="form-control" name="cuilPoderdante" id="cuilPoderdante">
                </div>
                <div class="col">
                    <h5><label for="domicilioPoderdante">Domicilio</label></h5>
                    <input type="text" class="form-control" name="domicilioPoderdante" id="domicilioPoderdante" placeholder="25 de Mayo 437, Ramos Mejia, La Matanza, Provincia de Buenos Aires">
                </div>
            </div>
            <div class="row mt-3 ">
                <div class="col">
                    <h5><label for="estadoCivilPoderdante">Estado Civil</label></h5>
                    <select class="form-control" name="estadoCivilPoderdante" id="estadoCivilPoderdante">
                        <option selected value="1">Casado</option>
                        <option selected value="2">Soltero</option>
                        <option selected value="3">Viudo</option>
                        <option selected=""></option>
                    </select>
                </div>
                <div class="col">
                    <h5><label for="nombreConyugePoderdante">Nombre de su Conyuge*</label>(En el caso de ser Casado)</h5>
                    <input type="text" class="form-control" name="nombreConyugePoderdante" id="nombreConyugePoderdante" >
                </div>
            </div>
            <div class="row justify-content-end">   
                <div class="col-sm-6 ">
                    <h5><label for="nombreMadrePoderdante">Nombre de su Madre*</label>(En el caso de ser Soltero)</h5>
                    <input type="text" class="form-control" name="nombreMadrePoderdante" id="nombreMadrePoderdante" >
                </div>
            </div>
            <div class="row justify-content-end">   
                <div class="col-sm-6 ">
                    <h5><label for="nombrePadrePoderdante">Nombre de su Padre*</label>(En el caso de ser Soltero)</h5>
                    <input type="text" class="form-control" name="nombrePadrePoderdante" id="nombrePadrePoderdante" >
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <h3>Datos del Apoderado</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5><label for="nombreApoderado">Nombre Completo</label></h5>
                    <input type="text" class="form-control" name="nombreApoderado" id="nombreApoderado">
                </div>
                <div class="col">
                    <h5><label for="fechaApoderado">Fecha de Nacimiento</label></h5>
                    <input type="date" class="form-control" name="fechaApoderado" id="fechaApoderado">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <h5><label for="cuilApoderado">CUIL</label></h5>
                    <input type="cuilApoderado" class="form-control" name="cuilApoderado" id="cuilApoderado">
                </div>
                <div class="col">
                    <h5><label for="domicilioApoderado">Domicilio</label></h5>
                    <input type="text" class="form-control" name="domicilioApoderado" id="domicilioApoderado" placeholder="25 de Mayo 437, Ramos Mejia, La Matanza, Provincia de Buenos Aires">
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col">
                    <h5><label for="estadoCivilApoderado">Estado Civil</label></h5>
                    <select class="form-control" name="estadoCivilApoderado" id="estadoCivilApoderado">
                        <option disabled="" selected=""></option>
                        <option selected value="1">Casado</option>
                        <option selected value="2">Soltero</option>
                        <option selected value="3">Viudo</option>
                        <option  selected=""></option>
                    </select>
                </div>
                <div class="col">
                    <h5><label for="nombreConyugeApoderado">Nombre de su Conyuge*</label>(En el caso de ser Casado)</h5>
                    <input type="text" class="form-control" name="nombreConyugeApoderado" id="nombreConyugeApoderado" >
                </div>
            </div>
            <div class="row justify-content-end">   
                <div class="col-sm-6 ">
                    <h5><label for="nombreMadreApoderado">Nombre de su Madre*</label>(En el caso de ser Soltero)</h5>
                    <input type="text" class="form-control" name="nombreMadreApoderado" id="nombreMadreApoderado" >
                </div>
            </div>
            <div class="row justify-content-end mb-3">   
                <div class="col-sm-6 ">
                    <h5><label for="nombrePadreApoderado">Nombre de su Padre*</label>(En el caso de ser Soltero)</h5>
                    <input type="text" class="form-control" name="nombrePadreApoderado" id="nombrePadreApoderado" >
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
            url: "<?php echo e(asset('sistema/menu/eliminar')); ?>",
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>