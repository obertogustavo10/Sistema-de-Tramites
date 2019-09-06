
<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>"></script>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/sb-admin-charts.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item">Seguimiento</li>
    <li class="breadcrumb-item active">Inscripciones</a></li>

</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/previoinscripcion/ofertadecursada/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/previoinscripcion/ofertadecursada";
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
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
                <div class="form-group col-lg-4">
                    <label>Plan de estudio</label>
                    <select id="lstPlan" name="lstPlan" class="form-control selectpicker" data-live-search="true" onchange="fObtenerPeriodoDeInscripcion();">
                        <?php if(isset($plan)): ?>
							<option value="" disabled>Seleccionar</option>
                        <?php else: ?>
							<option value="" disabled selected>Seleccionar</option>
                        <?php endif; ?>
                        <?php for($i = 0; $i < count($array_plan); $i++): ?>
                            <?php if(isset($plan) and $array_plan[$i]->idplan == $plan->idplan): ?>
                                <option selected value="<?php echo e($array_plan[$i]->idplan); ?>"><?php echo e($array_plan[$i]->descplan); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($array_plan[$i]->idplan); ?>"><?php echo e($array_plan[$i]->descplan); ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </div>
                 <div id="divTitulo" class="form-group col-lg-4">
                    <label>Período desde</label>
                    <input type="date" id="txtDesde" name="txtDesde" class="form-control" onchange="fObtenerPeriodoDeInscripcion();">
                </div>
                <div class="form-group col-lg-4">
                    <label>Período hasta</label>
                    <input type="date" id="txtHasta" name="txtHasta" class="form-control" onchange="fObtenerPeriodoDeInscripcion();">
                </div>
            </div>
            <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-4 mb-4">
              <div class="card border-left-primary">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Alumnos inscriptos</div>
                      <div id="divAlumnosActivos" class="h5 mb-0 text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-4 mb-4">
              <div class="card border-left-success">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Inscripciones a cursos</div>
                      <div id="divInscriptos" class="h5 mb-0 text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-4 mb-4">
              <div class="card border-left-info">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Ocupación de cupos</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div id="divOcupacion" class="h5 mb-0 mr-3 text-gray-800">0</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div id="divProgressOcupacion" class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-percent fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="text-secondary">Inscipciones por día</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="myAreaChart" width="668" height="320" class="chartjs-render-monitor" style="display: block; width: 668px; height: 320px;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                                                <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">Día y horario</th>
                                                <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 80px;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="3" class="text-center">Seleccione un plan de estudio</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
<!--<script src="<?php echo e(asset('js/vendor/chart-area-demo.js')); ?>"></script>-->
<script>
    var pos = 0;
    var d = new Date();
    var fechaInicio = d.getFullYear() + "-01-01";
    var fechaActual =  d.getFullYear() + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
    $("#form1").validate();
    $("#txtDesde").val(fechaInicio);
    $("#txtHasta").val(fechaActual);

    function fObtenerPeriodoDeInscripcion(){
        modificado = false;
        idPlan = $("#lstPlan option:selected").val();
        fechaDesde = $("#txtDesde").val();
        fechaHasta = $("#txtHasta").val();
        if(idPlan > 0){
            $.ajax({
                type: "GET",
                url: "<?php echo e(asset('seguimiento/obtenerInscripciones')); ?>",
                data: { 
                        idPlan: idPlan,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta,
                     },
                async: true,
                dataType: "json",
                success: function (data) {
                    if(data) {
                        $("#divAlumnosActivos").html(data.alumnos_activos);
                        $("#divInscriptos").html(data.cant_inscriptos);
                        $("#divOcupacion").html(data.cupo_ocupado);
                        $("#divProgressOcupacion").css("width", data.cupo_ocupado);

                        //Carga los periodos de inscripcion para el plan
                        html = "";
                        $("#dataTable_wrapper tbody").empty();
                        if(data.array_oferta.length == 0){
                            html = '<tr><td colspan="3" class="text-center">Sin datos</td></tr>';
                        }
                        $.each(data.array_oferta, function (key, val) {
                            if(data.array_oferta[key]["abreinscripcion"] == 2){
                                $.each(data.array_oferta[key]["materia"], function (idmateria, aMateria) {
                                    html += '<tr role="row">';
                                    html += '<td>'+aMateria["descmateria"]+'</td>';
                                    html += '<td>';
                                    html += '<select name="lstOferta[]" class="form-control" id="lstMateria_'+idmateria+'">';
                                    html += '<option selected value="0">Seleccionar</option>';
                                            $.each(aMateria["cursada"], function (idcursada, dia) {
                                                html += '<option value="'+idcursada+'">'+aMateria["cursada"][idcursada]["dia"]+'</option>';
                                            });
                                    html += '</select></td><td><button type="button" class="btn btn-secondary fa fa-users" title="Ver Inscriptos" onclick="fAbrirInscriptos('+idmateria+');"></button> <button type="button" class="btn btn-secondary fa fa-file-text-o" title="Ver Acta" onclick="fAbrirActas('+idmateria+');"></button></td></tr>';
                                });
                            }
                            if(data.array_oferta[key]["abreinscripcion"] == 1){
                                html += '<tr role="row">';
                                html += '<td>'+data.array_oferta[key]["descgrupo"]+'</td>';
                                
                                $.each(data.array_oferta[key]["materia"], function (idmateria, aMateria) {
                                    html += '<td><select name="lstOferta[]" class="form-control" id="lstMateria_'+idmateria+'">';        
                                    html += '<option selected value="0">Seleccionar</option>';
                                    $.each(aMateria["cursada"], function (idcursada, dia) {
                                        html += '<option value="'+idcursada+'">'+aMateria["cursada"][idcursada]["dia"]+'</option>';
                                    });
                                    html += '</select></td><td><button type="button" class="btn btn-secondary fa fa-users" title="Ver Inscriptos" onclick="fAbrirInscriptos('+idmateria+');"></button> <button type="button" class="btn btn-secondary fa fa-file-text-o" title="Ver Acta" onclick="fAbrirActas('+idmateria+');"></button></td>';
                                    //break;
                                });
                                html += '</tr>';

                                
                            }
                        });
                        $("#dataTable_wrapper tbody").append(html);
                    }
                }
            });
        }
    }

    function fAbrirInscriptos(idMateria){
        modificado = false;
        oferta = $("#lstMateria_" + idMateria + " option:selected").val();
        if(oferta > 0)
            window.open("/seguimiento/inscriptos/"+oferta, '_self');
        else 
            msgShow("Debe seleccionar una día y horario de cursada", MSG_ERROR);
    }

    function fAbrirActas(idMateria){
        modificado = false;
        oferta = $("#lstMateria_" + idMateria + " option:selected").val();
        
        if(oferta > 0)
            window.open("/seguimiento/acta/"+oferta, '_self');
        else
            msgShow("Debe seleccionar un día y horario de cursada", MSG_ERROR);
    }

    <?php if(isset($plan_seleccionado)): ?>
        $("#lstPlan").val("<?php echo e($plan_seleccionado); ?>");
        $('#lstPlan').selectpicker('refresh');
        fObtenerPeriodoDeInscripcion();
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>