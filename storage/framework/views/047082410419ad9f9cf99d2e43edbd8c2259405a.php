
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
    <li class="breadcrumb-item active">Historia académica</li>
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
        <div class="form-group col-lg-12">
            <label>Plan:</label>
        </div>
        <div class="form-group col-lg-12">
        <?php if(isset($array_carrera) and count($array_carrera)==0): ?>
            <p>No registra carreras activas.</p>
        <?php else: ?>
            <select id="lstPlan" name="lstPlan" class="form-control" onchange="this.form.submit()">
                <?php for($i = 0; $i < count($array_carrera); $i++): ?>
                    <?php if($idPlan == $array_carrera[$i]->fk_idplan): ?>
                        <option value="<?php echo e($array_carrera[$i]->fk_idplan); ?>" selected><?php echo e($array_carrera[$i]->descplan); ?> - Estado: (<?php echo e(ucwords(strtolower($array_carrera[$i]->descestadoalu))); ?>)</option>
                    <?php else: ?>
                        <option value="<?php echo e($array_carrera[$i]->fk_idplan); ?>"><?php echo e($array_carrera[$i]->descplan); ?> - Estado: (<?php echo e(ucwords(strtolower($array_carrera[$i]->descestadoalu))); ?>)</option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>
        <?php endif; ?>
        </div> 
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="font-weight-bold">Porcentaje de aprobación <span class="float-right"><?php echo e($porcentaje_aprobacion); ?>%</span></h4>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?php echo e($porcentaje_aprobacion); ?>%" aria-valuenow="<?php echo e($porcentaje_aprobacion); ?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-success">Materias inscriptas actualmente</h6>
        </div>
        <div class="card-body">
        <?php if(!isset($array_materia_encurso)): ?>
            <p>No tiene materias inscriptas.</p>
        <?php else: ?>
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" width="30%" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="20%" aria-controls="dataTable" rowspan="1" colspan="1" >Horario</th>
                    <th width="20%" aria-controls="dataTable" rowspan="1" colspan="1" >Profesor</th>
                    <th aria-controls="dataTable" rowspan="1" colspan="1" >Sede</th>
                    <th aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $array_materia_encurso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr role="row">
                      <td><?php echo e($materia->descmateria); ?></td>
                      <td><?php echo e($materia->descdia . " de " . $materia->horainiciocursada . " a " . $materia->horafincursada); ?></td>
                      <td><?php echo e(isset($materia->apellido)?$materia->apellido . " " . $materia->nombre:""); ?></td>
                      <td><?php echo e(isset($materia->descsede)?$materia->descsede:""); ?></td>
                      <td><?php echo e(isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""); ?> hs.</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table></div></div></div>
        </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Materias aprobadas</h6>
        </div>
        <div class="card-body">
        <?php if(!isset($array_materias_aprobadas)): ?>
            <p>No tiene historia académica para el plan seleccionado.</p>
        <?php else: ?>
        <div class="shadow alert alert-warning" role="alert">
          <p>Si tenés aprobada “Historia de la Medicina” y aparece como pendiente “Historia de las Ciencias” ignóralo, en breve actualizaremos la Historia académica.</p>
        </div>
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Nota</th>
                    <th width="10%" aria-controls="dataTable" rowspan="1" colspan="1" >Fecha acta</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Libro</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Folio</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Exime</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $array_materias_aprobadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($materia->nota_alumno): ?>
                    <tr role="row">
                      <td><?php echo e($materia->descmateria); ?></td>
                      <td><?php echo e(isset($materia->notaenletras)?$materia->notaenletras:""); ?></td>
                      <td><?php echo e(isset($materia->fechaacta)?date_format(date_create($materia->fechaacta), 'd/m/Y'):""); ?></td>
                      <td><?php echo e(isset($materia->libro)?$materia->libro:""); ?></td>
                      <td><?php echo e(isset($materia->folio)?$materia->folio:""); ?></td>
                      <td><?php echo e(isset($materia->resolucionexime) && $materia->resolucionexime != ""? "Res. " . $materia->resolucionexime:""); ?></br>
                      <?php echo e(isset($materia->expedienteexime) && $materia->expedienteexime != ""? "Exp. " . $materia->expedienteexime:""); ?></br>
                      <?php echo e(isset($materia->fecharesolexime) && $materia->fecharesolexime != ""?date_format(date_create($materia->fecharesolexime), 'd/m/Y'):""); ?></td>
                      <td><?php echo e(isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""); ?> hs.</td>
                    </tr>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table></div></div></div>
        </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Materias que restan aprobar</h6>
        </div>
        <div class="card-body">
        <?php if(!isset($array_materias_restanaprobar)): ?>
            <p>No tiene historia académica para el plan seleccionado.</p>
        <?php else: ?>
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $array_materias_restanaprobar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr role="row">
                    <td><?php echo e($materia->descmateria); ?></td>
                    <td><?php echo e(isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""); ?> hs.</td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table></div></div></div>
        </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Materias ausentes/desaprobadas/no informadas</h6>
        </div>
        <div class="card-body">
        <?php if(!isset($array_materias_ausentesdesaprobadas)): ?>
            <p>No tiene historia académica para el plan seleccionado.</p>
        <?php else: ?>
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Nota</th>
                    <th width="10%" aria-controls="dataTable" rowspan="1" colspan="1" >Fecha acta</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Libro</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Folio</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Exime</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $array_materias_ausentesdesaprobadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($materia->nota_alumno): ?>
                    <tr role="row">
                      <td><?php echo e($materia->descmateria); ?></td>
                      <td><?php echo e(isset($materia->notaenletras)?$materia->notaenletras:""); ?></td>
                      <td><?php echo e(isset($materia->fechaacta)?date_format(date_create($materia->fechaacta), 'd/m/Y'):""); ?></td>
                      <td><?php echo e(isset($materia->libro)?$materia->libro:""); ?></td>
                      <td><?php echo e(isset($materia->folio)?$materia->folio:""); ?></td>
                      <td><?php echo e(isset($materia->resolucionexime) && $materia->resolucionexime != ""? "Res. " . $materia->resolucionexime:""); ?></br>
                      <?php echo e(isset($materia->expedienteexime) && $materia->expedienteexime != ""? "Exp. " . $materia->expedienteexime:""); ?></br>
                      <?php echo e(isset($materia->fecharesolexime) && $materia->fecharesolexime != ""?date_format(date_create($materia->fecharesolexime), 'd/m/Y'):""); ?></td>
                      <td><?php echo e(isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""); ?> hs.</td>
                    </tr>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
          </div></div></div>
        </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>