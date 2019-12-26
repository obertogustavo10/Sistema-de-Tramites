<?php $__env->startSection('titulo', "Listado del Formularios"); ?>

<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/home">Configuración</a></li>
    <li class="breadcrumb-item active">Formularios</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/configuracion/formulario/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/configuracion/formularios");'><span>Recargar</span></a></li>
</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>URL</th>
        </tr>
    </thead>
</table> 
<script>
	var dataTable = $('#grilla').DataTable({
	    "processing": true,
        "serverSide": true,
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25,
        "order": [[ 2, "asc" ]],
	    "ajax": "<?php echo e(route('formulario.cargarGrilla')); ?>"
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>