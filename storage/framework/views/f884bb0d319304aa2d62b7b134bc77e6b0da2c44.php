
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
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<br>
<form id="form1" method="POST" }}>
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
<?php if(!$plan_cd_activo): ?>
<div class="row">
	<div class="col-md-12">
		<div class="shadow alert alert-danger" role="alert">
			<h4 class="alert-heading">Atención</h4>
		  <hr>
		  	<p>No es alumno activo</p>
		</div>
	</div>
</div>
<?php else: ?>
<div class="row">
	<div class="col-md-12">
		<div class="shadow alert alert-success" role="alert">
			<h4 class="alert-heading">Atención</h4>
		  <hr>
		  	<p>Sólo podes inscribirte en aquellas materias y horarios que aún tienen <strong>vacantes disponibles</strong>.</p>
			<p>Si se ofrece para inscribirte una materia que <strong>ya tenes aprobada</strong>, <strong>ignorala, no debes inscribirte</strong>.</p>
		</div>
	</div>
	<div class="col-md-12">
	  <div class="card shadow mb-4">
	    <div class="card-header py-3">
	      <h6 class="m-0 font-weight-bold text-primary">Inscripción a materias</h6>
	    </div>
	    <div class="card-body">
    	<?php if(count($array_oferta)>0): ?>
	      <p>Selecciona el dìa y horario de la materia que deseas cursar y luego en el botón Confirmar inscripción. Una vez confirmado, en caso de querer modificar la inscripción podrás generar una nueva inscripción si así lo deseas.</p>

		<div class="table-responsive">
		    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
		    	<div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
		      <thead>
		        <tr role="row">
		        	<th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
		        	<th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" >Día y horario</th>
		        </tr>
		      </thead>
		      <tbody>
		      	<?php $__currentLoopData = $array_oferta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			      	<?php if($array_oferta[$key]["abreinscripcion"] == 2): ?>
			      	<?php $__currentLoopData = $array_oferta[$key]["materia"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idmateria=>$aMateria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			      	<tr role="row">
			          <td><?php echo e($aMateria["descmateria"]); ?></td>
			          <td>
			          	<select name="lstOferta[]" class="form-control">
			          		<option selected value="0">Seleccionar</option>
			          		<?php $__currentLoopData = $aMateria["cursada"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idcursada => $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				          		<?php ($inscripto = false); ?>;
			          			<?php $__currentLoopData = $array_oferta_yainscripta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			          				<?php if($inscripcion->idcursada == $idcursada): ?>
			          					<?php ($inscripto = true); ?>;
	          						<?php endif; ?>
			          			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	      						<?php if($inscripto == true): ?>
	      							<?php if($aMateria["cursada"][$idcursada]["sinvacante"] == "true"): ?>
		          						<option style="color:red;" selected value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
	          						<?php else: ?>
	          							<option selected value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
	          						<?php endif; ?>
	          					<?php else: ?>
	          						<?php if($aMateria["cursada"][$idcursada]["sinvacante"] == "true"): ?>
	          							<option style="color:red;" value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
	      							<?php else: ?>
	      								<option value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
	  								<?php endif; ?>
	      						<?php endif; ?>
			          		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			          	</select>
			          </td>
			        </tr>
			        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			        <?php endif; ?>
			        <?php if($array_oferta[$key]["abreinscripcion"] == 1): ?>
			      	<tr role="row">
			          <td><?php echo e($array_oferta[$key]["grupo"]); ?></td>
			          <td>
			          	<select name="lstOferta[]" class="form-control">
			          		<option selected value="0">Seleccionar</option>
			          		<?php $__currentLoopData = $array_oferta[$key]["materia"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idmateria=>$aMateria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				          		<?php $__currentLoopData = $aMateria["cursada"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idcursada => $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					          		<?php ($inscripto = false); ?>;
				          			<?php $__currentLoopData = $array_oferta_yainscripta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				          				<?php if($inscripcion->idcursada == $idcursada): ?>
				          					<?php ($inscripto = true); ?>;
		          						<?php endif; ?>
				          			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		      						<?php if($inscripto == true): ?>
		      							<?php if($aMateria["cursada"][$idcursada]["sinvacante"] == "true"): ?>
			          						<option style="color:red;" selected value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
		          						<?php else: ?>
		          							<option selected value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
		          						<?php endif; ?>
		          					<?php else: ?>
		          						<?php if($aMateria["cursada"][$idcursada]["sinvacante"] == "true"): ?>
		          							<option style="color:red;" value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
		      							<?php else: ?>
		      								<option value="<?php echo e($idcursada); ?>"><?php echo e($aMateria["cursada"][$idcursada]["dia"]); ?></option>
		  								<?php endif; ?>
		      						<?php endif; ?>
				          		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			          		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			          	</select>
			          </td>
			        </tr>
			        <?php endif; ?>
		      	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		       </tbody>
		    </table></div></div></div>
		</div>
		<br>
		<div class="offset-md-9 col-md-3">
			<input type="submit" class="btn btn-google btn-block" value="Confirmar inscripción"/>
		</div>
		<?php else: ?>
			<p>No hay materias pendientes de inscripción</p>
		<?php endif; ?>
	    </div>
	  </div>
	</div>
</div>
<?php endif; ?>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>