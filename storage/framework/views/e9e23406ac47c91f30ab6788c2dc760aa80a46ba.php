<?php $__env->startSection('titulo', "Tipo de Cliente"); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    globalId = '<?php echo isset($menu->idmenu) && $menu->idmenu > 0 ? $menu->idmenu : 0; ?>';
    <?php $globalId = isset($menu->idmenu) ? $menu->idmenu : "0"; ?>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/home">Configuración</a></li>
    <li class="breadcrumb-item"><a href="/configuracion/tipodeclientes">Tipos de Clientes</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/configuracion/tipodecliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/configuracion/tipodeclientes";
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
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="<?php echo e(isset($tipocliente->nombre) ? $tipocliente->nombre : ''); ?>" required>
                </div>
            </div>    
        </form>        
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