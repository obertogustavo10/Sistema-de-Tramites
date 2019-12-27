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
    <li class="breadcrumb-item"><a href="/tramite/nuevo">Nuevo trámite</a></li>
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
        <form id="form1" method="POST">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>" required>
            <div class="row">
                <div class="col-sm-4">
                    <label for="tipoDePoder">Tipo de Poder</label>
                    <select class="form-control" name="tipoDePoder" id="tipoDePoder">
                        <option selected disabled>Seleccionar</option>
                        <option value="1">Venta</option>
                        <option value="2">Adminitracion y Disposicion</option>
                        <option value="3">Judicial</option>
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
                    <label for="nombrePoderdante">Nombre Completo</label>
                    <input type="text" class="form-control" name="nombrePoderdante" id="nombrePoderdante" value="<?php echo e(isset($poderEspecial->nombrepoderdante) ? $poderEspecial->nombrepoderdante : ''); ?>">
                </div>
                <div class="col">
                    <label for="fechaPoderdante">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fechaPoderdante" id="fechaPoderdante" value="<?php echo e(isset($poderEspecial->fechapoderdante) ? $poderEspecial->fechapoderdante : ''); ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label for="cuilPoderdante">CUIL</label>
                    <input type="cuilPoderdante" class="form-control" name="cuilPoderdante" id="cuilPoderdante" value="<?php echo e(isset($poderEspecial->cuilpoderdante) ? $poderEspecial->cuilpoderdante : ''); ?>">
                </div>
                <div class="col">
                    <label for="domicilioPoderdante">Domicilio</label>
                    <input type="text" class="form-control" name="domicilioPoderdante" id="domicilioPoderdante" placeholder="25 de Mayo 437, Ramos Mejia, La Matanza, Provincia de Buenos Aires" value="<?php echo e(isset($poderEspecial->domiciliopoderdante) ? $poderEspecial->domiciliopoderdante : ''); ?>">
                </div>
            </div>
            <div class="row mt-3 ">
                <div class="col">
                    <label for="estadoCivilPoderdante">Estado Civil</label>
                    <select class="form-control" name="estadoCivilPoderdante" id="estadoCivilPoderdante" value="<?php echo e(isset($poderEspecial->estadocivilpoderdante) ? $poderEspecial->estadocivilpoderdante : ''); ?>">
                        <option selected disabled>Seleccionar</option>
                        <option value="1">Casado</option>
                        <option value="2">Soltero</option>
                        <option value="3">Viudo</option>
                    </select>
                </div>
                <div class="col">
                    <label for="nombreConyugePoderdante">Nombre de su Conyuge*</label>(En el caso de ser Casado)
                    <input type="text" class="form-control" name="nombreConyugePoderdante" id="nombreConyugePoderdante" value="<?php echo e(isset($poderEspecial->conyugepoderdante) ? $poderEspecial->conyugepoderdante : ''); ?>" >
                </div>
            </div>
            <div class="row justify-content-end">   
                <div class="col-sm-6 ">
                    <label for="nombreMadrePoderdante">Nombre de su Madre*</label>(En el caso de ser Soltero)
                    <input type="text" class="form-control" name="nombreMadrePoderdante" id="nombreMadrePoderdante" value="<?php echo e(isset($poderEspecial->madrepoderdante) ? $poderEspecial->madrepoderdante : ''); ?>">
                </div>
            </div>
            <div class="row justify-content-end">   
                <div class="col-sm-6 ">
                    <label for="nombrePadrePoderdante">Nombre de su Padre*</label>(En el caso de ser Soltero)
                    <input type="text" class="form-control" name="nombrePadrePoderdante" id="nombrePadrePoderdante" value="<?php echo e(isset($poderEspecial->padrepoderdante) ? $poderEspecial->padrepoderdante : ''); ?>">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <h3>Datos del Apoderado</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="nombreApoderado">Nombre Completo</label>
                    <input type="text" class="form-control" name="nombreApoderado" id="nombreApoderado" value="<?php echo e(isset($poderEspecial->nombreapoderado) ? $poderEspecial->nombreapoderado : ''); ?>">
                </div>
                <div class="col">
                    <label for="fechaApoderado">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fechaApoderado" id="fechaApoderado" value="<?php echo e(isset($poderEspecial->fechaapoderado) ? $poderEspecial->fechaapoderado : ''); ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label for="cuilApoderado">CUIL</label>
                    <input type="cuilApoderado" class="form-control" name="cuilApoderado" id="cuilApoderado" value="<?php echo e(isset($poderEspecial->cuilapoderado) ? $poderEspecial->cuilapoderado : ''); ?>">
                </div>
                <div class="col">
                    <label for="domicilioApoderado">Domicilio</label>
                    <input type="text" class="form-control" name="domicilioApoderado" id="domicilioApoderado" placeholder="25 de Mayo 437, Ramos Mejia, La Matanza, Provincia de Buenos Aires" value="<?php echo e(isset($poderEspecial->domicilioapoderado) ? $poderEspecial->domicilioapoderado : ''); ?>">
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="estadoCivilApoderado">Estado Civil</label>
                    <select class="form-control" name="estadoCivilApoderado" id="estadoCivilApoderado" value="<?php echo e(isset($poderEspecial->estadocivilapoderado) ? $poderEspecial->estadocivilapoderado : ''); ?>">
                        <option selected disabled>Seleccionar</option>
                        <option value="1">Casado</option>
                        <option value="2">Soltero</option>
                        <option value="3">Viudo</option>
                    </select>
                </div>
                <div class="col">
                    <label for="nombreConyugeApoderado">Nombre de su Conyuge*</label>(En el caso de ser Casado)
                    <input type="text" class="form-control" name="nombreConyugeApoderado" id="nombreConyugeApoderado" value="<?php echo e(isset($poderEspecial->conyugeapoderado) ? $poderEspecial->conyugeapoderado : ''); ?>">
                </div>
            </div>
            <div class="row justify-content-end">   
                <div class="col-sm-6 ">
                    <label for="nombreMadreApoderado">Nombre de su Madre*</label>(En el caso de ser Soltero)
                    <input type="text" class="form-control" name="nombreMadreApoderado" id="nombreMadreApoderado" value="<?php echo e(isset($poderEspecial->madreapoderado) ? $poderEspecial->madreapoderado : ''); ?>">
                </div>
            </div>
            <div class="row justify-content-end mb-3">   
                <div class="col-sm-6 ">
                    <label for="nombrePadreApoderado">Nombre de su Padre*</label>(En el caso de ser Soltero)
                    <input type="text" class="form-control" name="nombrePadreApoderado" id="nombrePadreApoderado" value="<?php echo e(isset($poderEspecial->padreapoderado) ? $poderEspecial->padreapoderado : ''); ?>">
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