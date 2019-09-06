
<?php $__env->startSection('titulo', $titulo); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/home">Inicio</a></li>
    <li class="breadcrumb-item">Inscripción</li>
</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<br>
<form id="form1" method="POST" }}>
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
<div class="row">
	<div class="col-md-12">
		<a class="btn btn-secondary py-5" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/cd-consideraciones/">Programador Web Fullstack</a>
		<a class="btn btn-secondary py-5" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/cd-consideraciones/">Marketing Digital</a>
		<a class="btn btn-secondary py-5" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/cd-consideraciones/">Programador Wordpress</a>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>