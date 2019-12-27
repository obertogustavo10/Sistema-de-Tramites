<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<br>
<div class="col-lg-12">
    <div id = "msg-error" class="alert alert-danger">
        <p><strong>&#161;Error&#33;</strong></p><?php echo e($mensaje); ?> </p><p>Err: <?php echo e($codigo); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>