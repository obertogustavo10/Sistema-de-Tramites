

<?php $__env->startSection('titulo', "Nuevo Trámite"); ?>

<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>

<div class="container">
<?php $__currentLoopData = $tramites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tramite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card w-75">
        <div class="card-body">
            <h5 class="card-title"><?php echo e($tramite['nombre']); ?></h5>
            <p class="card-text"><?php echo e($tramite['descripcion']); ?></p>
            <a href="<?php echo e($tramite['url']); ?>" class="btn btn-primary">Iniciar Trámite</a>
        </div>
    </div>
</div>