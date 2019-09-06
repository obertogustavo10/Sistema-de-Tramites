@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($plan->idplan) && $plan->idplan > 0 ? $plan->idplan : 0; ?>';
    <?php $globalId = isset($plan->idplan) ? $plan->idplan : "0"; ?>
    globalMateria = null;

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/previoinscripcion/ofertadecursada">Previo a inscripción</a></li>
    <li class="breadcrumb-item active">Oferta de cursada</a></li>

</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/previoinscripcion/ofertadecursada/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/previoinscripcion/ofertadecursada";
}
</script>
@endsection
@section('contenido')
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
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Plan de estudio disponible</label>
                    <select id="lstPlan" name="lstPlan" class="form-control selectpicker" data-live-search="true" onchange="fObtenerDatosDelPlan();">
                        @if (isset($plan))
							<option value="" disabled>Seleccionar</option>
                        @else
							<option value="" disabled selected>Seleccionar</option>
                        @endif
                        @for ($i = 0; $i < count($array_plan); $i++)
                            @if (isset($plan) and $array_plan[$i]->idplan == $plan->idplan)
                                <option selected value="{{ $array_plan[$i]->idplan }}">{{ $array_plan[$i]->descplan }}</option>
                            @else
                                <option value="{{ $array_plan[$i]->idplan }}">{{ $array_plan[$i]->descplan }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                 <div id="divTitulo" class="form-group col-lg-6">
                    <label>Resolución</label>
                    <input type="text" id="txtResolucion" name="txtResolucion" class="form-control" readonly="">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Materias
                            <div class="pull-right">
                                <button id="btnExpand" type="button" class="btn btn-secondary fa fa-expand" onclick="fexpandirContraer()"></button>
                                <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="fabrirMateria()"></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="grilla" class="display">
                                <thead>
                                    <tr>
                                        <th>Materia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Materia ofertada</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>Materia/módulo del plan: *</label>
                                <input type="text" id="hdnPosMateria" />
                                <select id="lstMateria" class="form-control selectpicker" data-live-search="true">
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Docente: *</label>
                                <select id="lstDocente" class="form-control selectpicker" data-live-search="true">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @for ($i = 0; $i < count($array_personal); $i++)
                                        <option value="{{ $array_personal[$i]->idpersonal }}">{{ $array_personal[$i]->nombre . " " . $array_personal[$i]->apellido }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Día de la semana: *</label>
                                <select id="lstDia" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @for ($i = 0; $i < count($array_dia); $i++)
                                        <option value="{{ $array_dia[$i]->iddia }}">{{ $array_dia[$i]->descdia }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Hora inicio: *</label><br>
                                <select type="text" id="lstHrIni" class="form-control fecha-hora-min">
                                    @for ($i = 0; $i < 24; $i++)
                                    	@if($i < 10)
                                        	<option value="{{ $i }}">0{{ $i }}</option>
                                        @else
                                        	<option value="{{ $i }}">{{ $i }}</option>
                                    	@endif
                                    @endfor
                                </select> -
                                <select type="text" id="lstMinIni" class="form-control fecha-hora-min">
                                    @for ($i = 0; $i < 60; $i++)
                                        @if($i < 10)
                                        	<option value="0{{ $i }}">0{{ $i }}</option>
                                        @else
                                        	<option value="{{ $i }}">{{ $i }}</option>
                                    	@endif
                                    @endfor
                                </select>
                                <script>
									$("#lstHrIni").prop("selectedIndex", "0");
									$("#lstMinIni").prop("selectedIndex", "0");
								</script>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Hora fin: *</label><br>
                                <select type="text" id="lstHrFin" class="form-control fecha-hora-min">
                                    @for ($i = 0; $i < 24; $i++)
                                    	@if($i < 10)
                                        	<option value="{{ $i }}">0{{ $i }}</option>
                                        @else
                                        	<option value="{{ $i }}">{{ $i }}</option>
                                    	@endif
                                    @endfor
                                </select> -
                                <select type="text" id="lstMinFin" class="form-control fecha-hora-min">
                                    @for ($i = 0; $i < 60; $i++)
                                        @if($i < 10)
                                        	<option value="0{{ $i }}">0{{ $i }}</option>
                                        @else
                                        	<option value="{{ $i }}">{{ $i }}</option>
                                    	@endif
                                    @endfor
                                </select>
								<script>
									$("#lstMinFin").prop("selectedIndex", "00");
									$("#lstMinFin").prop("selectedIndex", "00");
								</script>                                
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Vacantes: *</label>
                                <input type="number" id="txtVacante" class="form-control"/>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Habilitado: *</label>
                                <select id="lstHabilitado" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
									<option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Fecha Inicio de cursada: *</label>
                                <input type="date" id="txtFechaIniCur" class="form-control"/>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Fecha fin de cursada: *</label>
                                <input type="date" id="txtFechaFinCur" class="form-control"/>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Lugar de cursada: *</label>
                                <select id="lstCursada" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @for ($i = 0; $i < count($array_sede); $i++)
                                        <option value="{{ $array_sede[$i]->idsede }}">{{ $array_sede[$i]->descsede }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Comentario:</label>
                                <textarea id="txtComentario" class="form-control"></textarea>
                            </div>
                        </div>            
                    </div>
                    <div class="modal-footer">
                        <button id="btnAgregarSedeAct" type="button" class="btn btn-warning" onclick="eliminarMateriaEnGrilla();">Eliminar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnAgregarSedeAct" type="button" class="btn btn-success" onclick="agregarMateriaEnGrilla();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
</div>
<script>
    var pos = 0;

    $("#form1").validate();
	cargarGrilla();

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
    function cargarGrilla() {
        idPlan = $("#lstPlan option:selected").val();
        var grilla = $('#grilla').DataTable();
        grilla.destroy();
       	var grilla = $('#grilla').DataTable({
         	"processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "paging": false,
            "ajax": "{{ asset('/previoinscripcion/ofertadecursada/cargarGrillaOfertaPorPlan?idplan=') }}" + idPlan,
            "columnDefs": [
             	{
                    "targets": [0],
                    "width": 600
                },
                {
                    "targets": [1],
                    "width": 10
                }
            ],
        });
    }

    function fObtenerDatosDelPlan(){
    	fBorrarFormularioMateria();
        idPlan = $("#lstPlan option:selected").val();
        if(idPlan > 0){
            $.ajax({
                type: "GET",
                url: "{{ asset('actividad/plan/obtenerPlan') }}",
                data: { 
                        idPlan: idPlan,
                     },
                async: true,
                dataType: "json",
                success: function (data) {
                	if(data) {
                        globalMateria = data.materias;

                		$("#txtResolucion").val(data.plan.resolucion);
                		cargarGrilla();

                		//Carga las materias del plan
                		$("#lstMateria option").remove();
                		$.each(data.materias, function (i, item) {
                            if(item.abreinscripcion == 2){
                                $('#lstMateria').append($('<option>', {
                                    value: i, 
                                    text: item.materia[0].descmateria
                                }));    
                            }
                            if(item.abreinscripcion == 1){
                                $('#lstMateria').append($('<option>', {
                                    value: i,
                                    text: item.modulo
                                }));    
                            }
		                    
		                });
		                $('#lstMateria').selectpicker('refresh');
                	} else {
						$("#txtResolucion").val('');
                	}
                }
            });
        }
    }

    function fabrirMateria(){
    	if($("#lstPlan").val() != null){
    		$("#msg").hide();
	    	fBorrarFormularioMateria();
	        $('#modalAgregar').modal('toggle');
    	} else {
			msgShow("Seleccione un plan para continuar", "danger");
    	}
    }

    function fexpandirContraer(){
        $('.data-toggle').trigger('click');
        var element = document.getElementById("btnExpand");
        element.classList.toggle("fa-expand");
        element.classList.toggle("fa-compress");
    }

    function fBorrarFormularioMateria(){
        $("#hdnPosMateria").val("");
		$("#lstMateria").val("");
		$('#lstMateria').selectpicker('refresh');
		$("#lstDia").val("");
		$("#lstDocente").val("");
		$('#lstDocente').selectpicker('refresh');
		$("#lstHrIni").val("");
		$("#lstMinIni").val("");
		$("#lstHrFin").val("");
		$("#lstMinFin").val("");
		$("#txtVacante").val("");
		$("#lstHabilitado").val("");
		$("#txtFechaIniCur").val("");
		$("#txtFechaFinCur").val("");
		$("#lstCursada").val("");
		$("#txtComentario").val("");
    }
    function agregarMateriaEnGrilla(){
    	if($("#lstMateria").val() != null && $("#lstDocente option:selected").val() != "" && $("#lstDia").val() != "" && $("#lstHrIni").val() != "" && $("#lstMinIni").val() != "" && $("#lstHrFin").val() != "" && $("#lstMinFin").val() != "" && $("#txtVacante").val() != "" && $("#txtFechaIniCur").val() != "" && $("#txtFechaFinCur").val() != "" && $("#lstHabilitado option:selected").val() != "" && $("#lstCursada").val() != ""){
    	var grilla = $('#grilla').DataTable();
        //idMateria = $("#lstMateria option:selected").val();
        idPosMateria = $("#hdnPosMateria").val();

        if(idPosMateria != ""){
            $("#txtMateria_" + idPosMateria).parent().parent().addClass('borrar');
            grilla.rows('.borrar').remove().draw(false);
        } else {
            idPosMateria = "D_" + pos;
            pos++;
        }
        seleccion = $("#lstMateria option:selected").val();
        idMateria = "";
        idModulo = globalMateria[seleccion].idModulo;
        $.each(globalMateria[seleccion].materia, function(i, item){
            idMateria += item.idmateria + ",";
        });




        //Obtiene el modulo y materia


        grilla.row.add([
            "<a class='data-toggle' data-toggle='collapse' href='#collapse"+idPosMateria+"' role='button' aria-expanded='false' aria-controls='collapse"+idPosMateria+"'>[+]</a> " + $("#lstMateria option:selected").text() + " - " + $("#lstDocente option:selected").text() + " - " + $("#lstDia option:selected").text() + " de " + $("#lstHrIni option:selected").text() + ":" +  $("#lstMinIni option:selected").text() + " a " + $("#lstHrFin option:selected").text() + ":" +  $("#lstMinFin option:selected").text() + " hs." + "<input type='text' id='txtModulo_"+idPosMateria+"' name='txtModulo_["+idPosMateria+"]' value='"+idModulo+"'><input type='text' id='txtMateria_"+idPosMateria+"' name='txtMateria["+idPosMateria+"]' value='"+idMateria+"'><input type='hidden' id='txtMateria_"+idPosMateria+"' name='txtMateria["+idPosMateria+"]' value='" + $("#lstMateria option:selected").val() + "'><div class='collapse' id='collapse"+idPosMateria+"'><label>Horario:</label> " +
            $("#lstDia option:selected").text() + " de " + $("#lstHrIni option:selected").text() + ":" +  $("#lstMinIni option:selected").text() + " a " + $("#lstHrFin option:selected").text() + ":" +  $("#lstMinFin option:selected").text() + " hs." + "<input type='hidden' name='hdnDia["+idPosMateria+"]' value='" + $("#lstDia option:selected").val() + "'><input type='hidden' name='hdnHrIni["+idPosMateria+"]' value='" + $("#lstHrIni option:selected").val() + "'><input type='hidden' name='hdnMinIni["+idPosMateria+"]' value='" + $("#lstMinIni option:selected").val() + "'><input type='hidden' name='hdnHrFin["+idPosMateria+"]' value='" + $("#lstHrFin option:selected").val() + "'><input type='hidden' name='hdnMinFin["+idPosMateria+"]' value='" + $("#lstMinFin option:selected").val() + "'>" + "<br><label>Docente:</label> " +
            $("#lstDocente option:selected").text() + "<input type='hidden' name='hdnDocente["+idPosMateria+"]' value='" + $("#lstDocente option:selected").val() + "'>" + "<br><label>Lugar de cursada:</label> " +
            $("#lstCursada option:selected").text() + "<input type='hidden' name='hdnLugarCursada["+idPosMateria+"]' value='" + $("#lstCursada option:selected").val() + "'>" + "<br><label>Vacantes:</label> " +
            $("#txtVacante").val() + "<input type='hidden' name='hdnVacante["+idPosMateria+"]' value='" + $("#txtVacante").val() + "'>" +
            "<br><label>Período de cursada:</label> " + $("#txtFechaIniCur").val() + " a " + $("#txtFechaFinCur").val() + "<input type='hidden' name='hdnFechaIniCursada["+idPosMateria+"]' value='" + $("#txtFechaIniCur").val() + "'><input type='hidden' name='hdnFechaFinCursada["+idPosMateria+"]' value='" + $("#txtFechaFinCur").val() + "'>" + "<br><label>Habilitado:</label> " +
            $("#lstHabilitado option:selected").text() + "<input type='hidden' name='hdnHabilitado["+idPosMateria+"]' value='" + $("#lstHabilitado option:selected").val() + "'><br><label>Comentario:</label> " + $("#txtComentario").val() + "<input type='hidden' name='hdnComentario["+idPosMateria+"]' value='" + $("#txtComentario").val() + "'></div>",
            "<button type='button' class='btn btn-secondary fa fa-pencil' value='"+idPosMateria+"' onclick='abrirEditarMateria(\""+idPosMateria+"\")'></button>"
        ]).draw();
        $('#modalAgregar').modal('toggle');
        $("#msg").hide();
    	} else {
			alert("Complete los campos obligatorios para guardar.");
    	}
    }

    function abrirEditarMateria(idPosMateria){
    	idMateria = $("[name='txtMateria[" + idPosMateria + "]']" ).val();
        idDia = $("[name='hdnDia[" + idPosMateria + "]']" ).val();
    	if(!idDia) idDia = "";
    	idDocente = $("[name='hdnDocente[" + idPosMateria + "]']" ).val();
    	if(!idDocente) idDocente = "";
		idHrIni = $("[name='hdnHrIni[" + idPosMateria + "]']" ).val();
    	if(!idHrIni) idHrIni = "";
    	idMinIni = $("[name='hdnMinIni[" + idPosMateria + "]']" ).val();
    	if(!idMinIni) idMinIni = "";
    	idHrFin = $("[name='hdnHrFin[" + idPosMateria + "]']" ).val();
    	if(!idHrFin) idHrFin = "";
    	idMinFin = $("[name='hdnMinFin[" + idPosMateria + "]']" ).val();
    	if(!idMinFin) idMinFin = "";
    	vacante = $("[name='hdnVacante[" + idPosMateria + "]']" ).val();
    	if(!vacante) vacante = "";
    	habilitado = $("[name='hdnHabilitado[" + idPosMateria + "]']" ).val();
    	if(!habilitado) habilitado = "";
    	fechaIniCursada = $("[name='hdnFechaIniCursada[" + idPosMateria + "]']" ).val();
    	if(!fechaIniCursada) fechaIniCursada = "";
    	fechaFinCursada = $("[name='hdnFechaFinCursada[" + idPosMateria + "]']" ).val();
    	if(!fechaFinCursada) fechaFinCursada = "";
    	lugar = $("[name='hdnLugarCursada[" + idPosMateria + "]']" ).val();
    	if(!lugar) lugar = "";
    	comentario = $("[name='hdnComentario[" + idPosMateria + "]']" ).val();
    	if(!comentario) comentario = "";

        $("#hdnPosMateria").val(idPosMateria);
		$("#lstMateria").val(idMateria);
		$('#lstMateria').selectpicker('refresh');
		$("#lstDia").val(idDia);
		$("#lstDocente").val(idDocente);
		$('#lstDocente').selectpicker('refresh');
		$("#lstHrIni").val(idHrIni);
		$("#lstMinIni").val(idMinIni);
		$("#lstHrFin").val(idHrFin);
		$("#lstMinFin").val(idMinFin);
		$("#txtVacante").val(vacante);
		$("#lstHabilitado").val(habilitado);
		$("#txtFechaIniCur").val(fechaIniCursada);
		$("#txtFechaFinCur").val(fechaFinCursada);
		$("#lstCursada").val(lugar);
		$("#txtComentario").val(comentario);
		$('#modalAgregar').modal('toggle');
    }
    function eliminarMateriaEnGrilla(){
        idMateria = $("#lstMateria option:selected").val();
        var grilla = $('#grilla').DataTable();
        $("#txtMateria_" + idMateria).parent().parent().addClass('borrar');
        grilla.rows('.borrar').remove().draw(false);
        $('#modalAgregar').modal('toggle');
    }

    @if (isset($plan))
    	fObtenerDatosDelPlan();
    @endif
</script>
@endsection