
<?php $__env->startSection('titulo', $titulo); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/inscripcion">Inscripción</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/cd-consideraciones">Consideraciones</a></li>
    <li class="breadcrumb-item active">Inscripción</li>
</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<br>
<form id="form1" method="POST" }}">
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
<div class="row">
	<div class="col-md-12">
	  <div class="card shadow mb-4">
	    <div class="card-header py-3">
	      <h6 class="m-0 font-weight-bold text-primary">Inscripción exitosa</h6>
	    </div>
	    <div class="card-body">
      		<p>Inscripción procesada correctamente, haga clic en el botón de a continuación para descargar el comprobante, se ha enviado una copia a su correo.</p>
			<div class="col-md-4">
				<a target="_blank" class="btn btn-success btn-block" title="Descargar Constancia de inscripción" style="cursor: pointer" href="cd-inscripcion/comprobante/<?php echo e($idformu); ?>">Descargar Constancia de inscripción</a>
			</div>
	    </div>
	  </div>
	</div>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>