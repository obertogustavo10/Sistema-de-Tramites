<?php $__env->startSection('titulo', "Calculo de Utilidades"); ?>
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
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>" required>
                <div class="form-group col-lg-6">
                    <label>Nombre y Apellido: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" required value="<?php echo e(isset($calculoUtilidades->nombre) ? $calculoUtilidades->nombre : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>No. Cedula de Identidad: *</label>
                    <input class="form-control" type="number" placeholder="" name="txtCedula"required id="txtCantidad" value="<?php echo e(isset($calculoUtilidades->no_cedula) ? $calculoUtilidades->no_cedula : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Cargo que ocupa en la empresa: *</label>
                    <input class="form-control" type="text" placeholder="" name="txtCargo"required id="txtNombre" value="<?php echo e(isset($calculoUtilidades->cargo_empresa) ? $calculoUtilidades->cargo_empresa : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha de Ingreso: *</label>
                    <input class="form-control" type="date" placeholder="" name="txtFecha"required id="txtFecha" value="<?php echo e(isset($calculoUtilidades->fecha_ingreso) ? $calculoUtilidades->fecha_ingreso : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Dias a Bonificar:</label>
                    <input class="form-control" type="number" placeholder="" name="txtBonificar"required id="txtCantidad" value="<?php echo e(isset($calculoUtilidades->dias_bonificar) ? $calculoUtilidades->dias_bonificar : ''); ?>">
                </div>
                 <div class="form-group col-lg-6">
                    <label>Nombre del Solicitante:</label>
                    <input class="form-control" type="text" placeholder="" name="txtNombreSolicitante"required id="txtNombre" value="<?php echo e(isset($calculoUtilidades->nombre_solicitante) ? $calculoUtilidades->nombre_solicitante : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Desea calculo a ultimo salario:</label>
                    <select id="lstEstado" name="lstUltimo_Salario" class="form-control" required value="<?php echo e(isset($calculoUtilidades->calculo_ultimosalario) ? $calculoUtilidades->calculo_ultimosalario : ''); ?>">
                <option value="" disabled selected>Seleccionar</option>
                <option value="1" <?php echo e(isset($grupo) && $grupo->activo == 1? 'selected' : ''); ?>>Si</option>
                <option value="0" <?php echo e(isset($grupo) &&$grupo->activo == 0? 'selected' : ''); ?>>No</option>
            </select>
                </div>
                 <div class="form-group col-lg-6">
                    <label>Desea calculo a salario promedio:</label>
                   <select id="lstEstado" name="lstSalario_Promedio" class="form-control" required value="<?php echo e(isset($calculoUtilidades->calculo_salariopromedio) ? $calculoUtilidades->calculo_salariopromedio : ''); ?>">
                <option value="" disabled selected>Seleccionar</option>
                <option value="1" <?php echo e(isset($grupo) && $grupo->activo == 1? 'selected' : ''); ?>>Si</option>
                <option value="0" <?php echo e(isset($grupo) &&$grupo->activo == 0? 'selected' : ''); ?>>No</option>
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