
<?php $__env->startSection('titulo', $titulo); ?>
<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<link href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="home">Inicio</a></li>
    <li class="breadcrumb-item active">Carreras activas</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/home";
}
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<form id="form1" method="POST" }}">
    <div class="row">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
        <div class="form-group col-lg-12">
            <label>Carreras activas:</label>
        </div>
        <div class="form-group col-lg-12">
        <?php if(isset($array_carreraactiva) and count($array_carreraactiva)==0): ?>
        	<p>No registra carreras activas.</p>
        <?php else: ?>
            <select id="lstCarreraActiva" name="lstCarreraActiva" class="form-control">
                <?php for($i = 0; $i < count($array_carreraactiva); $i++): ?>
                    <option value="<?php echo e($array_carreraactiva[$i]->fk_idplan); ?>"><?php echo e($array_carreraactiva[$i]->descplan); ?></option>
                <?php endfor; ?>
            </select>
        <?php endif; ?>
        </div> 
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>