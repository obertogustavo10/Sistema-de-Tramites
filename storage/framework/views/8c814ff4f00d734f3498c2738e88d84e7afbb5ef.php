
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
    <li class="breadcrumb-item active">Constancias de Inscripción</li>
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
<form id="form1" method="POST">
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
	<div class="col-md-12">
		<div class="shadow alert alert-info" role="alert">
		  A continuación podés descargar el último comprobante de inscripción válido.
		</div>
	</div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-success">Constancias de Inscripción</h6>
        </div>
        <div class="card-body">
        <?php if(!isset($array_comprobantes)): ?>
            <p>No tiene carreras inscriptas.</p>
        <?php else: ?>
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" width="30%" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Plan inscripto</th>
                    <th width="20%" aria-controls="dataTable" rowspan="1" colspan="1" >Acción</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $array_comprobantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comprobante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr role="row">
                      <td><?php echo e($comprobante->descplan); ?> - Res. <?php echo e($comprobante->resolucion); ?></td>
                      <td><a target="_blank" class="btn btn-success btn-block" title="Descargar" style="cursor: pointer" href="cd-inscripcion/comprobante/<?php echo e($comprobante->idformu); ?>">Descargar</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table></div></div></div>
        </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>