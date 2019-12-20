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
    <div class="row m-auto p-3">
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
    </div>
    <?php $__currentLoopData = $tramites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tramite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
    <div class="row m-auto p-3">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($tramite['nombre']); ?></h5>
                <p class="card-text"><?php echo e($tramite['descripcion']); ?></p>
                <a href="<?php echo e($tramite['url']); ?>" class="btn btn-primary float-right">Iniciar Trámite</a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>