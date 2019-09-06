
<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    globalId = '<?php echo isset($plandeestudio->idplan) && $plandeestudio->idplan > 0 ? $plandeestudio->idplan : 0; ?>';
    <?php $globalId = isset($plandeestudio->idplan) ? $plandeestudio->idplan : "0"; ?>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/actividad/planes">Planes de estudio</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/plan/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a id="btnGuardar" title="Guardar borrador" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <?php if(isset($plandeestudio->publicado) && $plandeestudio->publicado == 1): ?>
    <li class="btn-item"><a id="btnBorrador" title="Mover a borrador" href="#" class="fa fa-pencil" aria-hidden="true" onclick="planBorrador();"><span>Mover a Borrador</span></a>
    </li>
    <?php else: ?>
    <li class="btn-item"><a title="Publicar plan" href="#" class="fa fa-share" aria-hidden="true" onclick="planPublicar();"><span>Publicar</span></a>
    </li>    
    <?php endif; ?>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/actividad/planes";
}

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
        <div id = "msg"></div>
        <?php
        if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" href=""/actividad/plan/<?php echo e($globalId); ?>">Descripción del plan</a>
                  </li>
                  <li class="nav-item">
                    <?php if(isset($plandeestudio)): ?>
                        <a class="nav-link" href="/actividad/plan/<?php echo e($globalId); ?>/materias">Materias</a>
                    <?php else: ?>
                        <a class="nav-link" href="#">Materias</a>
                    <?php endif; ?>
                   
                  </li>
                  <li class="nav-item">
                    <?php if(isset($plandeestudio)): ?>
                        <a class="nav-link" href="/actividad/plan/<?php echo e($globalId); ?>/requisitos">Requisitos</a>
                    <?php else: ?>
                        <a class="nav-link" href="#">Requisitos</a>
                    <?php endif; ?>
                  </li>
                </ul>
            </div>
        </div>
        <form id="form1" method="POST"><br>
            <div class="row">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>">
                <div class="form-group col-lg-12">
                    <label>Actividad a la que pertenece el plan de estudios: *</label>
                    <select id="lstActividad" name="lstActividad" class="form-control" required>
                    	<option value="" disabled selected>Seleccionar</option>
                        <?php for($i = 0; $i < count($array_actividad); $i++): ?>
                            <?php if(isset($plandeestudio) and $array_actividad[$i]->idactividad == $plandeestudio->fk_idactividad): ?>
                                <option selected value="<?php echo e($array_actividad[$i]->idactividad); ?>"><?php echo e($array_actividad[$i]->descactividad); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($array_actividad[$i]->idactividad); ?>"><?php echo e($array_actividad[$i]->descactividad); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if(isset($plandeestudio) and $plandeestudio->fk_idactividad == ""): ?>
                            <script >$("#lstActividad").prop("selectedIndex", "-1");</script>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Nombre completo del Plan de Estudios: *</label>
                    <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="<?php echo e(isset($plandeestudio->descplan) ? $plandeestudio->descplan : ''); ?>" required>
                    <input type="hidden" id="txtPublicado" name="txtPublicado"  value="<?php echo e(isset($plandeestudio->publicado) ? $plandeestudio->publicado : ''); ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Aprobado por resolución: *</label>
                    <input type="text" id="txtResolucion" name="txtResolucion" class="form-control" value="<?php echo e(isset($plandeestudio->resolucion) ? $plandeestudio->resolucion : ''); ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Nombre Corto: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="<?php echo e(isset($plandeestudio->ncplan) ? $plandeestudio->ncplan : ''); ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Duración Total del Plan:</label>
                    <input type="text" id="txtDuracion" name="txtDuracion" class="form-control" value="<?php echo e(isset($plandeestudio->duracion) ? $plandeestudio->duracion : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Plan en vigencia - Desde:</label>
                    <input type="date" id="txtVigenciaDesde" name="txtVigenciaDesde" class="form-control" value="<?php echo e(isset($plandeestudio->vigenciadesde) ? $plandeestudio->vigenciadesde : ''); ?>">
                </div>
                <div class="form-group col-lg-6">
                    <label>Plan en vigencia – Hasta (sin datos indica que está vigente actualmente):</label>
                    <input type="date" id="txtVigenciaHasta" name="txtVigenciaHasta" class="form-control" value="<?php echo e(isset($plandeestudio->vigenciahasta) ? $plandeestudio->vigenciahasta : ''); ?>">
                </div>
                <div class="form-group col-lg-12">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h6 class="card-title">Datos de la Inscripción</h6>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <h7>Período de inscripción - Desde:</h7>
                                    <input type="date" id="txtInscribeDesde" name="txtInscribeDesde" class="form-control" value="<?php echo e(isset($plandeestudio->inscribedesde) ? $plandeestudio->inscribedesde : ''); ?>">
                                </div>
                                <div class="form-group col-lg-6">
                                    <h7>Período de inscripción - Hasta (sin datos indica que la inscripción está abierta):</h7>
                                    <input type="date" id="txtInscribeHasta" name="txtInscribeHasta" class="form-control" value="<?php echo e(isset($plandeestudio->inscribehasta) ? $plandeestudio->inscribehasta : ''); ?>">
                                </div>
                                <div class="form-group col-lg-6">
                                    <h7>El alumno podrá inscribirse: *</h7>
                                     <select id="lstAbreInscripcion" name="lstAbreInscripcion" class="form-control" data-live-search="true" required>
                                        <option value="" disabled selected>Seleccionar</option>
                                        <option value="1" <?php echo e(isset($plandeestudio) &&$plandeestudio->abreinscripcion == '1'? 'selected' : ''); ?>>Eligiendo el año, módulo o materias de la actividad</option>
                                        <option value="0" <?php echo e(isset($plandeestudio) && $plandeestudio->abreinscripcion == '0'? 'selected' : ''); ?>>Sólo a la actividad completa</option>                     </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <h7>El alumno puede elegir la sede de cursada?</h7>
                                    <select id="lstSede" name="lstSede" class="form-control" required>
                                        <option value="0" <?php echo e(isset($plandeestudio) && $plandeestudio->eligesede == '0'? 'selected' : ''); ?>>No</option>
                                        <option value="1" <?php echo e(isset($plandeestudio) &&$plandeestudio->eligesede == '1'? 'selected' : ''); ?>>Sí</option>
                                     </select>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
            </div>
        </form>
</div>

<script>
    $("#form1").validate();
    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
    
    function planBorrador(){
        modificado = false;
        $("#txtPublicado").val("0");
        form1.submit();
    }
    function planPublicar(){
        modificado = false;
        $("#txtPublicado").val("1");
        form1.submit();
    }

    <?php if(!isset($plandeestudio)): ?>
        $("#lstSede").prop("selectedIndex", "0");
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>