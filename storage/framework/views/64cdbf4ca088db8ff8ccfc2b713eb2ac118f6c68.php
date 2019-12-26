<?php $__env->startSection('titulo', "$titulo"); ?>

<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Men&uacute;</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/sistema/menu/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/sistema/menu");'><span>Recargar</span></a></li>
</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
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
<script>
	var dataTable = $('#grilla').DataTable({
	    "processing": true,
        "serverSide": true,
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25,
        "order": [[ 2, "asc" ]],
	    "ajax": "<?php echo e(route('tramitesiniciados.cargarGrilla')); ?>"
	});

    function fTramiteProcesar(idTramite){
        $.ajax({
	            type: "GET",
	            url: "<?php echo e(asset('tramite/tramiteProcesar')); ?>",
	            data: { id:idTramite },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
	                 msgShow(respuesta.MSG, respuesta.ESTADO);
	            }
        });
    }
    
    function fTramiteFinalizar(idTramite){
        $.ajax({
	            type: "GET",
	            url: "<?php echo e(asset('tramite/tramiteFinalizar')); ?>",
	            data: { id:idTramite },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
	                 msgShow(respuesta.MSG, respuesta.ESTADO);
	            }
	    });
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>