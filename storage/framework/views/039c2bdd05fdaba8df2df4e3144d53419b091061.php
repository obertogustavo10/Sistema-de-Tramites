
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('titulo', "Bienvenido"); ?>
<?php $__env->startSection('contenido'); ?>
	<div class="text-center">
			
	</div>	
<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>