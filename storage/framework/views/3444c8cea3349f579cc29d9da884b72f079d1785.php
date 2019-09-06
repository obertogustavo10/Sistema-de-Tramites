<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<link href="<?php echo e(asset('css/bootstrap-select.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/bootstrap-select.min.js')); ?>"></script>
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
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <?php if(isset($plandeestudio->publicado) && $plandeestudio->publicado == 1): ?>
    <li class="btn-item"><a title="Mover a borrador" href="#" class="fa fa-pencil" aria-hidden="true" onclick="planBorrador();"><span>Mover a Borrador</span></a>
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
                    <a class="nav-link" href="/actividad/plan/<?php echo e($globalId); ?>">Descripción del plan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="/actividad/plan/<?php echo e($globalId); ?>/materias">Materias</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/actividad/plan/<?php echo e($globalId); ?>/requisitos">Requisitos</a>
                  </li>
                </ul>
            </div>
        </div>
        <form id="form1" method="POST"><br>
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>" required>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Materias del plan
                            <div class="pull-right">
                                <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirAgregarMaterias()"></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="txtPublicado" name="txtPublicado"  value="<?php echo e(isset($plandeestudio->publicado) ? $plandeestudio->publicado : ''); ?>" required>
                            <table id="grilla" class="display">
                                <thead>
                                    <tr>
                                    	<th>Módulo</th>
                                        <th>Materia</th>
                                        <th>Optativa</th>
                                        <th>Nota de aprobación</th>
                                        <th>Correlativa</th>
                                        <th>Equivalencia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Agregar materia</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>Módulo:</label>
                                <select id="lstModulo" name="lstModulo" class="form-control selectpicker" data-live-search="true" onchange="abrirAltaModulo();">
                                    <option value="0">Agregar nuevo</option> 
                                    <?php for($i = 0; $i < count($array_modulo); $i++): ?>
                                        <option value="<?php echo e($array_modulo[$i]->idgrupo); ?>"><?php echo e($array_modulo[$i]->descgrupo); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <script>$("#lstModulo").val("");</script>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Materia:</label>
                                <select id="lstMateria" name="lstMateria" class="form-control selectpicker" data-live-search="true" onchange="abrirAltaMateria();">
                                    <option value="0">Agregar nuevo</option>
                                    <?php for($i = 0; $i < count($array_materia); $i++): ?>
                                        <option value="<?php echo e($array_materia[$i]->idmateria); ?>"><?php echo e($array_materia[$i]->idmateria . " - " . ucfirst(strtolower($array_materia[$i]->descmateria))); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <script>$("#lstMateria").val("");</script>
                            </div>
                        </div>            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarMateriasEnGrilla();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal modulos-->
        <div class="modal fade" id="modalAgregarModulo" tabindex="-1" role="dialog" aria-labelledby="modalAgregarModulo">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Agregar módulo</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-modulo">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Nombre corto: *</label>
                                    <input type="text" id="txtNombreModulo" name="txtNombreModulo" class="form-control" maxlength="50" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Descripción: *</label>
                                    <input type="text" id="txtDescripcionModulo" name="txtDescripcionModulo" class="form-control" maxlength="500" required>
                                </div>
                                <?php if($plandeestudio->abreinscripcion != 0): ?>
                               <div class="form-group col-lg-6">
                                    <label>El alumno se inscribe:</label>
                                    <select id="lstAbreInscripcionModulo" name="lstAbreInscripcionModulo" class="form-control" required>
                                        <option value="" disabled selected>Seleccionar</option>
                                        <option value="1">Se le asignan todas las materias del módulo</option>
                                        <option value="2">El alumno elige las materias</option>
                                    </select>
                                </div> 
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="cancelarModuloEnSelect();">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarModuloEnSelect();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal materia-->
        <div class="modal fade" id="modalAgregarMateria" tabindex="-1" role="dialog" aria-labelledby="modalAgregarMateria">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Materia</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Nombre: *</label>
                                <input type="text" id="txtNombreMateria" name="txtNombreMateria" class="form-control" required>
                                <input type="hidden" id="txtIdMateria" name="txtIdMateria" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Descripción: *</label>
                                <input type="text" id="txtDescripcionMateria" name="txtDescripcionMateria" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Departamento:</label>
                                <select id="lstDptoMateria" name="lstDptoMateria" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <?php for($i = 0; $i < count($array_dpto); $i++): ?>
                                        <?php if(isset($materia) and $array_dpto[$i]->iddepto == $materia->fk_iddepto): ?>
                                            <option selected value="<?php echo e($array_dpto[$i]->iddepto); ?>"><?php echo e($array_dpto[$i]->descdepto); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($array_dpto[$i]->iddepto); ?>"><?php echo e($array_dpto[$i]->descdepto); ?></option>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Actividad: *</label>
                                <select id="lstActividadMateria" name="lstActividadMateria" class="form-control" required>
                                    <?php for($i = 0; $i < count($array_actividad); $i++): ?>
                                        <?php if(isset($plandeestudio) and $array_actividad[$i]->idactividad == $plandeestudio->fk_idactividad): ?>
                                            <option selected value="<?php echo e($array_actividad[$i]->idactividad); ?>"><?php echo e($array_actividad[$i]->descactividad); ?></option>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Período:</label>
                                <input type="number" id="txtPeriodoMateria" name="txtPeriodoMateria" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Carga horaria en días:</label>
                                <input type="number" id="txtHsEnDiasMateria" name="txtHsEnDiasMateria" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Carga horaria en horas:</label>
                                <input type="number" id="txtHsEnHsMateria" name="txtHsEnHsMateria" class="form-control">
                            </div>         
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnCancelarAgregarMateria" type="button" style="display:none" class="btn btn-default"onclick="cancelarAgregarMateriaEnSelect();">Cancelar</button>
                        <button id="btnCancelarModificarMateria" type="button" style="display:none" class="btn btn-default"onclick="cancelarModificarMateriaEnSelect();">Cancelar</button>
                        <button id="btnAgregarMateria" style="display:none" type="button" class="btn btn-primary" onclick="agregarMateriaEnSelect();">Agregar</button>
                        <button id="btnModificarMateria" style="display:none" type="button" class="btn btn-primary" onclick="modificarMaterias();">Modificar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAgregarCorrelativa" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCorrelativaLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 900px;margin-left: -40%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Correlativas</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="hdnIdMateriaCorrelativa">
                        <div class="row">
                            <div class="form-group col-lg-5">
                                <label>No correlativas</label>
                                <select multiple="" id="lstCorrelativa_noasig" name="lstCorrelativa_noasig" class="form-control listamultiple">
                                </select>
                            </div>
                            <div class="form-group col-lg-1 botonera_list">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="fasignar();">&gt;</button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="fdesasignar();">&lt;</button>
                                </div>
                            </div>
                            <div class="form-group col-lg-5">
                                <label>Correlativas</label>
                                <select multiple="" id="lstCorrelativa_asig" name="lstCorrelativa_asig[]" class="form-control listamultiple"></select>
                            </div>
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarCorrelativasEnGrilla();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAbrirEquivalencia" tabindex="-1" role="dialog" aria-labelledby="modalAbrirEquivalenciaLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Equivalencia de la materia</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="hdnIdMateriaEquivalencia">
                        <div class="row">
                            <div class="form-group col-lg-12">
                            	<button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirAgregarEquivalencia();"></button>
                            	<table id="grillaEquivalenciaPorMateria" class="display">
	                                <thead>
	                                    <tr>
	                                    	<th>Plan</th>
	                                        <th>Materia</th>
	                                        <th></th>
	                                    </tr>
	                                </thead>
	                            </table>
                            </div>
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarEquivalencia();">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAgregarEquivalencia" tabindex="-1" role="dialog" aria-labelledby="modalAgregarEquivalenciaLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 900px;margin-left: -40%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Agregar equivalencia por materia</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="hdnIdMateriaEquivalencia">
                        <div class="row">
                            <div class="form-group col-lg-12">
                            	<label>Plan equivalente:</label>
                                <select id="lstPlanEquivalente" name="lstPlanEquivalente" class="form-control" onchange="cargaMateriasEnSelectPorPlan();">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <?php for($i = 0; $i < count($array_plan); $i++): ?>
                                    <?php if($array_plan[$i]->idplan != $plandeestudio->idplan): ?>
                                        <option value="<?php echo e($array_plan[$i]->idplan); ?>" title="<?php echo e($array_plan[$i]->descplan); ?>"><?php echo e($array_plan[$i]->idplan . " - " . $array_plan[$i]->descplan); ?></option>
                                    <?php endif; ?>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-5">
                                <label>No equivalentes</label>
                                <select multiple="" id="lstEquivalencia_noasig" name="lstEquivalencia_noasig" class="form-control listamultiple">
                                </select>
                            </div>
                            <div class="form-group col-lg-1 botonera_list">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <button type="button" class="btn btn-primary" onclick="fasignarEquivalencia();">&gt;</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <button type="button" class="btn btn-primary" onclick="fdesasignarEquivalencia();">&lt;</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-5">
                                <label>Equivalentes</label>
                                <select multiple="" id="lstEquivalencia_asig" name="lstEquivalencia_asig[]" class="form-control listamultiple"></select>
                            </div>
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarEquivalenciaEnGrilla();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    $("#form1").validate();
    cargarGrilla();
    cargarGrillaEquivalencia();

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

    <?php if(!isset($plandeestudio)): ?>
        $("#lstActividad").val("");
    <?php endif; ?>
    function cargarGrilla() {
    		var groupColumn = 0;
           	var grilla = $('#grilla').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
           /* "scrollY": "600px",
            "scrollCollapse": true,*/
            "paging": false,
            "ajax": "<?php echo e(asset('/actividad/plan/materias/cargarGrillaMateriasDelPlan?idplan='.$globalId)); ?>",
            "drawCallback": function ( settings ) {
	            var api = this.api();
	            var rows = api.rows( {page:'current'} ).nodes();
	            var last=null;
	 
	            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
	                if ( last !== group ) {
	                    $(rows).eq( i ).before(
	                        '<tr class="group" style="background-color: #ddd !important;"><td colspan="5">'+group+'</td></tr>'
	                    );
	 
	                    last = group;
	                }
	            });
	        },
            "columnDefs": [
              	{
					"targets": [0],
              		"visible": false, 
              	},
                {
                    "targets": [1],
                    "width": 500
                },
                 {
                    "targets": [2],
                    "visible": true,
                    "searchable": true,
                    "width": 60
                },
                {
                    "targets": [3],
                    "width": 120
                },
                {
                    "targets": [4],
                    "width": 100
                },
                {
                    "targets": [5],
                    "width": 60
                }
            ],
        });
        obtenerMateriasDelPlan();
    }

    function cargarGrillaEquivalencia(){
    		$('#grillaEquivalenciaPorMateria').DataTable().destroy();
			var groupColumn = 0;
           	var grilla = $('#grillaEquivalenciaPorMateria').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "drawCallback": function ( settings ) {
	            var api = this.api();
	            var rows = api.rows( {page:'current'} ).nodes();
	            var last=null;
	 
	            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
	                if ( last !== group ) {
	                    $(rows).eq( i ).before(
	                        '<tr class="group" style="background-color: #ddd !important;"><td colspan="5">'+group+'</td></tr>'
	                    );
	 
	                    last = group;
	                }
	            });
	        },
            "columnDefs": [
              	{
					"targets": [0],
                    "visible": false,
              	},
                {
                    "targets": [1]
                }
            ],
        });
    }
    function cargarGrillaEquivalenciaPorMateria(idMateria){
    	$("#hdnIdMateriaEquivalencia").val(idMateria);
    	//Cargar grilla desde input
		var grilla = $('#grillaEquivalenciaPorMateria').DataTable();
		grilla.clear();
		grilla.draw();
		jsonPlanMat = $("#txtEquivalencia_" + idMateria).val();
		if(jsonPlanMat != "" && jsonPlanMat != undefined){
			var objPlanMat = JSON.parse(jsonPlanMat);
			$.each(objPlanMat, function(index, value){
				var aId = value.split(",");
				idPlan = aId[0];
				idMateria = aId[1];
				$.ajax({
		            type: "GET",
		            url: "<?php echo e(asset('actividad/materia/obtenerTodosPorPlanAjax')); ?>",
		            async: false,
		            dataType: "json",
					data: { 
						plan: idPlan
					},
		            success: function (data) {
		            	$.each(data, function(index, item){
		            		if(idMateria == item.idmateria){
								grilla.row.add([
									$("#lstPlanEquivalente option[value=" + idPlan + "]").text(),
									item.idmateria + " - " + item.descmateria,
									"<button type='button' id='btnBorrarEquivalencia_"+ idPlan + "_" + item.idmateria + "' class='btn btn-secondary fa fa-minus-circle' onclick='eliminarEquivalencia("+idPlan+","+item.idmateria+")'></button><input type='hidden' id='hdnPlanMatEquivalencia_"+idPlan+"_"+idMateria+"' value='"+idPlan+","+idMateria+"'>"
								]).draw();
							}
						});      
		            }
		        });
			});
		}
    }
    
    function abrirAgregarMaterias() {
        $("#btnAgregarMateria").show();
        $("#btnCancelarAgregarMateria").show();
        $("#btnModificarMateria").hide();
        $("#btnCancelarModificarMateria").hide();
        $('#modalAgregar').modal('toggle');
    }

    function abrirAltaModulo() {
        if( $("#lstModulo option:selected").val() == "0"){

            $('#modalAgregar').modal('toggle');
            $('#modalAgregarModulo').modal('toggle');
        }
    }
    function abrirAltaMateria() {
        if( $("#lstMateria option:selected").val() == "0"){
            $("#txtDescripcionMateria").val("");
            $("#txtNombreMateria").val("");
            $("#txtPeriodoMateria").val("");
            $("#txtHsEnDiasMateria").val("");
            $("#txtHsEnHsMateria").val("");
            $('#modalAgregar').modal('toggle');
            $('#modalAgregarMateria').modal('toggle');
        }
    }
     function abrirEditarCorrelativa(idMateria) {
        obtenerMateriasDelPlan();
        $("#hdnIdMateriaCorrelativa").val(idMateria);
        $("#modalAgregarCorrelativa").modal('toggle');
        var correlativas = $("#txtCorrelativa_" + idMateria).val();
        $.each(correlativas.split(','), function(i, j){
            $('#lstCorrelativa_noasig option[value='+j+']').remove().appendTo('#lstCorrelativa_asig');    
        });
    }
	function abrirEditarEquivalencia(idMateria) {
		cargarGrillaEquivalenciaPorMateria(idMateria);
        $("#modalAbrirEquivalencia").modal('toggle');
    }
  	function abrirAgregarEquivalencia() {
        $("#lstPlanEquivalente").val("");
        $("#lstEquivalencia_noasig").empty();
        $("#lstEquivalencia_asig").empty();
        $("#modalAgregarEquivalencia").modal('toggle');
    }
    function guardarEquivalencia(){
        idMateria = $("#hdnIdMateriaEquivalencia").val();
		var aPlanmat = new Array();
        $("[id*='hdnPlanMatEquivalencia_").each(function (value, index) {
            aPlanmat.push(this.value);
        });
        $("#txtEquivalencia_" + idMateria).val(JSON.stringify(aPlanmat));
        if(aPlanmat.length>0)
            $("#btnEquivalencia_" + idMateria).addClass("btn-primary").removeClass("btn-secondary");
        else
            $("#btnEquivalencia_" + idMateria).addClass("btn-secondary").removeClass("btn-primary");

        $('#modalAbrirEquivalencia').modal('toggle');
    }
	function cancelarModuloEnSelect(){
        $('select[name=lstModulo]').val("-1");
        $('select[name=lstModulo]').selectpicker('refresh');
   		$('#modalAgregar').modal('toggle');
		$('#modalAgregarModulo').modal('toggle');
    }
    function cancelarAgregarMateriaEnSelect(){
        $('select[name=lstMateria]').val("-1");
        $('select[name=lstMateria]').selectpicker('refresh');
        $('#modalAgregar').modal('toggle');
        $('#modalAgregarMateria').modal('toggle');
    }
    function agregarMateriasEnGrilla() {
        var grilla = $('#grilla').DataTable();
        idGrupo = $("#lstModulo option:selected").val();
        idMateria = $("#lstMateria option:selected").val();
        grupoMateria = idGrupo + "_" + idMateria;

        <?php
        $option = "";
        for ($i = 0; $i < count($array_notas); $i++)
            $option .= "<option value='" . $array_notas[$i]->idnota . "'>". $array_notas[$i]->notaenletras ."</option>";
        ?>
        var option = "<?php echo $option; ?>";

        if($("#lstOptativa_" + idMateria).length == 0){
            grilla.row.add([
                $("#lstModulo option:selected").text() + " - <label><input type='checkbox' name='grupo[" + idGrupo + "]'> Inscribe al módulo completo</label>",
                $("#lstMateria option:selected").text(),
                "<select id='lstOptativa_"+idMateria+"' name='optativa["+grupoMateria+"]' class='form-control'><option value='1'>Si</option><option value='0' selected>No</option>",
                "<select id='lstNota_"+idMateria+"' name='nota["+grupoMateria+"]' class='form-control' required>" + option + "<option value='' disabled selected>Seleccionar</option></select>",
                "<input type='hidden' id='txtCorrelativa_"+idMateria+"' name='correlativa["+grupoMateria+"]'><button type='button' class='btn btn-secondary fa fa-pencil-square-o' onclick='abrirEditarCorrelativa("+idMateria+");'></button> <span id='divCorrelativa_"+idMateria+"'></span>",
                "<button type='button' class='btn btn-secondary fa fa-th-large' onclick='abrirEditarEquivalencia("+idMateria+");' value=''></button>",
                "<button type='button' class='btn btn-secondary fa fa-minus-circle' onclick='eliminar("+idMateria+")'></button>"
            ]).draw();
            $("#lstNota_"+idMateria).val("");
        }
        $("#lstModulo").val("");
        $('#lstModulo').selectpicker('refresh');
        $("#lstMateria").val("");
        $('#lstMateria').selectpicker('refresh');
        $('#modalAgregar').modal('toggle');
    }
    function obtenerMateriasDelPlan(){
        $("#lstCorrelativa_noasig").empty();
        $("#lstCorrelativa_asig").empty();
        $.ajax({
            type: "GET",
            url: "<?php echo e(asset('actividad/plan/materia/obtenerMateriasDelPlan')); ?>",
            data: { 
                    plan:globalId
                 },
            async: false,
            dataType: "json",
            success: function (data) {
                $.each(data, function(i, obj){
                    $('#lstCorrelativa_noasig').append($('<option>', {
                        value:obj.fk_idmateria, 
                        text: obj.fk_idmateria + " - " + obj.descmateria,
                        title: obj.fk_idmateria + " - " + obj.descmateria,
                    }));
                });
            }
        });
    }
    function agregarCorrelativasEnGrilla(){
        idMateria = $("#hdnIdMateriaCorrelativa").val();
        correlativas = "";
        $("#lstCorrelativa_asig option").each(function() {
            if(correlativas == "")
                correlativas = $(this).val();
            else
                correlativas += ", " + $(this).val();
        });
        $("#txtCorrelativa_" + idMateria).val(correlativas);
        $("#divCorrelativa_" + idMateria).html(correlativas);
        $("#hdnIdMateriaCorrelativa").val("");
        $('#modalAgregarCorrelativa').modal('toggle');
    }
    function agregarEquivalenciaEnGrilla(){
        var grilla = $('#grillaEquivalenciaPorMateria').DataTable();
        idPlan = $("#lstPlanEquivalente option:selected").val();
        descPlan = $("#lstPlanEquivalente option:selected").text();
        equivalentes = "";
        $("#lstEquivalencia_asig option").each(function() {
            grilla.row.add([
                descPlan,
                $(this).text(),
                "<button type='button' id='btnBorrarEquivalencia_"+ idPlan + "_" + $(this).val() + "' class='btn btn-secondary fa fa-minus-circle' onclick='eliminarEquivalencia("+idPlan+","+$(this).val()+")'></button><input type='hidden' id='hdnPlanMatEquivalencia_"+idPlan+"_"+$(this).val()+"' value='"+idPlan+","+$(this).val()+"'>"
            ]).draw();
        });
        $("#lstPlanEquivalente").val("");
        $('#modalAgregarEquivalencia').modal('toggle');
    }
    function eliminar(id){
        var grilla = $('#grilla').DataTable();
        $("#lstOptativa_" + id).parent().parent().addClass('borrar');
        grilla.rows('.borrar').remove().draw(false);
        $('#modalmsg').modal('toggle');
    }

    function agregarModuloEnSelect(){
		modulo = $("#txtNombreModulo").val();
		descripcion = $("#txtDescripcionModulo").val();
		abre = $("#lstAbreInscripcionModulo option:selected").val();
		if(modulo != "" && descripcion != ""){
        	$.ajax({
	            type: "GET",
	            url: "<?php echo e(asset('actividad/modulo/agregarModuloAjax')); ?>",
	            data: { 
		            	modulo: modulo,
		            	descripcion: descripcion,
		            	plan:globalId,
		            	abre:abre
	            	 },
	            async: true,
	            dataType: "json",
	            success: function (data) {
                    $("#txtNombreModulo").val("");
					$("#txtDescripcionModulo").val("");
					frecargarModulosEnSelect(data.idModulo);
	            }
	        });
	        $('#modalAgregarModulo').modal('toggle');
	        $('#modalAgregar').modal('toggle');
		} else {
			alert("Complete todos los datos");
		}
    }
    function frecargarModulosEnSelect(idModulo){
        $.ajax({
            type: "GET",
            url: "<?php echo e(asset('actividad/modulo/obtenerTodosPorPlanAjax')); ?>",
            async: true,
            dataType: "json",
            data: { 
                        plan:globalId
                     },
            success: function (data) {
                $("#lstModulo").empty();
                $('#lstModulo').append($('<option>', {
                    value: 0,
                    text: "Agregar nuevo"
                }));
                $.each(data, function (i, item) {
                    $('#lstModulo').append($('<option>', {
                        value: item.idgrupo, 
                        text: item.descgrupo
                    }));
                });
				$("#lstModulo").val(idModulo);
                $('#lstModulo').selectpicker('refresh');
            }
        });
    }
    function frecargarMateriasEnSelect(idMateria){
        $.ajax({
            type: "GET",
            url: "<?php echo e(asset('actividad/materia/obtenerTodosPorActividadDelPlanAjax')); ?>",
            async: true,
            dataType: "json",
            data: { 
                        plan: globalId
                     },
            success: function (data) {
                $("#lstMateria").empty();
                $('#lstMateria').append($('<option>', {
                    value: 0,
                    text: "Agregar nuevo"
                }));
                $.each(data, function (i, item) {
                    $('#lstMateria').append($('<option>', {
                        value: item.idmateria, 
                        text: item.idmateria + " - " + item.descmateria
                    }));
					$("#lstMateria").val(idMateria);
                    $('#lstMateria').selectpicker('refresh');
                });
            }
        });
    }
    function cargaMateriasEnSelectPorPlan(){
    	idPlan = $("#lstPlanEquivalente option:selected").val();
    	$.ajax({
            type: "GET",
            url: "<?php echo e(asset('actividad/materia/obtenerTodosPorPlanAjax')); ?>",
            async: true,
            dataType: "json",
			data: { 
				plan: idPlan
			},
            success: function (data) {
                $("#lstEquivalencia_noasig").empty();
                $.each(data, function (i, item) {
                    $('#lstEquivalencia_noasig').append($('<option>', {
                        value: item.idmateria, 
                        text: item.idmateria + " - " + item.descmateria,
                        title: item.idmateria + " - " + item.descmateria,
                    }));
                });
            }
        });
    }
    function agregarMateriaEnSelect(){
		descmateria = $("#txtDescripcionMateria").val();
		dpto = $("#lstDptoMateria option:selected").val();
		ncmateria = $("#txtNombreMateria").val();
		actividad = $("#lstActividadMateria option:selected").val();
		periodo = $("#txtPeriodoMateria").val();
		hsendias = $("#txtHsEnDiasMateria").val();
		hsenhs = $("#txtHsEnHsMateria").val();

		if(descmateria != "" && ncmateria != "" && actividad != ""){
        	$.ajax({
	            type: "GET",
	            url: "<?php echo e(asset('actividad/materia/agregarMateriaAjax')); ?>",
	            data: { 
		            	descmateria: descmateria,
		            	dpto: dpto,
		            	ncmateria:ncmateria,
		            	actividad:actividad,
		            	periodo:periodo,
		            	hsendias:hsendias,
		            	hsenhs:hsenhs
	            	 },
	            async: true,
	            dataType: "json",
	            success: function (data) {
					$("#txtDescripcionMateria").val("");
					$("#txtNombreMateria").val("");
					$("#txtPeriodoMateria").val("");
					$("#txtHsEnDiasMateria").val("");
					$("#txtHsEnHsMateria").val("");
					frecargarMateriasEnSelect(data.idMateria);
	            }
	        });
	        $('#modalAgregarMateria').modal('toggle');
	        $('#modalAgregar').modal('toggle');
		} else {
			alert("Complete todos los datos");
		}
    }
    function modificarMaterias(){
        idmateria = $("#txtIdMateria").val();
        descmateria = $("#txtDescripcionMateria").val();
        dpto = $("#lstDptoMateria option:selected").val();
        ncmateria = $("#txtNombreMateria").val();
        actividad = $("#lstActividadMateria option:selected").val();
        periodo = $("#txtPeriodoMateria").val();
        hsendias = $("#txtHsEnDiasMateria").val();
        hsenhs = $("#txtHsEnHsMateria").val();

        if(descmateria != "" && ncmateria != "" && actividad != ""){
            $.ajax({
                type: "GET",
                url: "<?php echo e(asset('actividad/materia/modificarMateriaAjax')); ?>",
                data: { 
                        idmateria: idmateria,
                        descmateria: descmateria,
                        dpto: dpto,
                        ncmateria:ncmateria,
                        actividad:actividad,
                        periodo:periodo,
                        hsendias:hsendias,
                        hsenhs:hsenhs
                     },
                async: true,
                dataType: "json",
                success: function (data) {
                    var grilla = $('#grilla').DataTable();
                    grilla.ajax.reload();
                    $("#txtIdMateria").val("");
                    $("#txtDescripcionMateria").val("");
                    $("#txtNombreMateria").val("");
                    $("#txtPeriodoMateria").val("");
                    $("#txtHsEnDiasMateria").val("");
                    $("#txtHsEnHsMateria").val("");
                }
            });
            $('#modalAgregarMateria').modal('toggle');
        } else {
            alert("Complete todos los datos");
        }
    }
    function abrirEditarMateria(idMateria){
        $.ajax({
            type: "GET",
            url: "<?php echo e(asset('actividad/materia/buscarMateria')); ?>",
            async: true,
            dataType: "json",
            data: { 
                    materia: idMateria
                },
            success: function (data) {
            $("#txtIdMateria").val(data.idmateria);
            $("#txtDescripcionMateria").val(data.descmateria);
            $("#lstDptoMateria").val(data.fk_iddepto);
            $("#txtNombreMateria").val(data.ncmateria);
            $("#lstActividadMateria").val(data.fk_idactividad);
            $("#txtPeriodoMateria").val(data.periodo);
            $("#txtHsEnDiasMateria").val(data.cargahorariaendias);
            $("#txtHsEnHsMateria").val(data.cargahorariaenhs);
            $("#btnAgregarMateria").hide();
            $("#btnCancelarAgregarMateria").hide();
            $("#btnModificarMateria").show();
            $("#btnCancelarModificarMateria").show();
            $('#modalAgregarMateria').modal('toggle');
            }
        });
    }
    function cancelarModificarMateriaEnSelect(){
        $('#modalAgregarMateria').modal('toggle');
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
    function fasignar() {
        $('#lstCorrelativa_noasig option:selected').remove().appendTo('#lstCorrelativa_asig');
        $("#lstCorrelativa_asig").val("");
    }
    function fdesasignar() {
        $('#lstCorrelativa_asig option:selected').remove().appendTo('#lstCorrelativa_noasig');
        $("#lstCorrelativa_noasig").val("");
    }
      function fasignarEquivalencia() {
        $('#lstEquivalencia_noasig option:selected').remove().appendTo('#lstEquivalencia_asig');
        $("#lstEquivalencia_asig").val("");
    }

    function fdesasignarEquivalencia() {
        $('#lstEquivalencia_asig option:selected').remove().appendTo('#lstEquivalencia_noasig');
        $("#lstEquivalencia_noasig").val("");
    }
    function eliminarEquivalencia(idPlan, idMateria){
        var grilla = $('#grillaEquivalenciaPorMateria').DataTable();
        $("#btnBorrarEquivalencia_" + idPlan + "_" + idMateria).parent().parent().addClass('borrar');
        grilla.rows('.borrar').remove().draw(false);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>