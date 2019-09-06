@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($actividad->idactividad) && $actividad->idactividad > 0 ? $actividad->idactividad : 0; ?>';
    <?php $globalId = isset($actividad->idactividad) ? $actividad->idactividad : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/actividad/actividades">Actividades</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/actividad/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/actividad/actividades";
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
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$actividad->descactividad or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Nombre corto: *</label>
                    <input type="text" id="txtIdentificador" name="txtIdentificador" class="form-control" value="{{$actividad->ncactividad or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Coordinador</label>
                    <select id="lstCoordinador" name="lstCoordinador" class="form-control selectpicker" data-live-search="true">
                        <option value="">-</option>
                        @for ($i = 0; $i < count($array_personal); $i++)
                            @if (isset($actividad) and $array_personal[$i]->idpersonal == $actividad->coordinador)
                                <option selected value="{{ $array_personal[$i]->idpersonal }}">{{ $array_personal[$i]->nombre }} {{ $array_personal[$i]->apellido }}</option>
                            @else
                                <option value="{{ $array_personal[$i]->idpersonal }}">{{ $array_personal[$i]->nombre }} {{ $array_personal[$i]->apellido }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                 <div class="form-group col-lg-2">
                    <label>Otorga título</label>
                    <select id="lstTitulo" name="lstTitulo" class="form-control" onchange="fotorgaTitulo();">
                        <option value="1" {{isset($actividad) && $actividad->titulo_que_otorga != ""? 'selected' : ''}}>Si</option>
                        <option value="0" {{isset($actividad) && $actividad->titulo_que_otorga == ""? 'selected' : ''}}>No</option>
                    </select>
                </div>
                 <div id="divTitulo" class="form-group col-lg-4" style="display: none;">
                    <label>Título</label>
                    <input type="text" id="txtTitulo" name="txtTitulo" class="form-control" value="{{$actividad->titulo_que_otorga or ''}}">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Sede donde se dicta la actividad
                            <div class="pull-right">
                                <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirSedeActividad()"></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="grilla" class="display">
                                <thead>
                                    <tr>
                                        <th>Sede</th>
                                        <th>Subsede</th>
                                        <th>Departamento</th>
                                        <th>Director</th>
                                        <th>subdirector</th>
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
                        <h5 class="modal-title" id="modalBuscarLabel">Sede para la actividad</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Sede: *</label>
                                <select id="lstSede" name="lstSede" class="form-control selectpicker" data-live-search="true" onchange="abrirAltaSede();">
                                    <option value="0">Agregar nuevo</option> 
                                    @for ($i = 0; $i < count($array_sede); $i++)
                                        <option value="{{ $array_sede[$i]->idsede }}">{{ $array_sede[$i]->descsede }}</option>
                                    @endfor
                                </select>
                                <script>$("#lstModulo").prop("selectedIndex", "-1");</script>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Subsede:</label>
                                <select id="lstSubSede" name="lstSubSede" class="form-control selectpicker" data-live-search="true" onchange="abrirAltaSede();">
                                    <option value="0">Agregar nuevo</option>
                                    @for ($i = 0; $i < count($array_sede); $i++)
                                        <option value="{{ $array_sede[$i]->idsede }}">{{ $array_sede[$i]->descsede }}</option>
                                    @endfor
                                </select>
                                <script>$("#lstSubSede").prop("selectedIndex", "-1");</script>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Departamento:</label>
                                <select id="lstDpto" name="lstDpto" class="form-control selectpicker" data-live-search="true">
                                </select>
                                <script>$("#lstDpto").prop("selectedIndex", "-1");</script>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Director:</label>
                                <select id="lstDirector" name="lstDirector" class="form-control selectpicker" data-live-search="true">
                                    @for ($i = 0; $i < count($array_personal); $i++)
                                        <option value="{{ $array_personal[$i]->idpersonal }}">{{ $array_personal[$i]->nombre . " " . $array_personal[$i]->apellido }}</option>
                                    @endfor
                                </select>
                                <script>$("#lstDirector").prop("selectedIndex", "-1");</script>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Subdirector:</label>
                                <select id="lstSubDirector" name="lstSubDirector" class="form-control selectpicker" data-live-search="true">
                                    @for ($i = 0; $i < count($array_personal); $i++)
                                        <option value="{{ $array_personal[$i]->idpersonal }}">{{ $array_personal[$i]->nombre . " " . $array_personal[$i]->apellido }}</option>
                                    @endfor
                                </select>
                                <script>$("#lstSubDirector").prop("selectedIndex", "-1");</script>
                            </div>
                        </div>            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnAgregarSedeAct" type="button" class="btn btn-primary" onclick="agregarSedeActividadEnGrilla();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAgregarSede" tabindex="-1" role="dialog" aria-labelledby="modalAgregarSedeLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Agregar Sede</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Descripción: *</label>
                                <input type="text" id="txtSedeNombre" name="txtSedeNombre" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nombre corto: *</label>
                                <input type="text" id="txtSedeCodigo" name="txtSedeCodigo" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Domicilio: </label>
                                <input type="text" id="txtSedeDomicilio" name="txtSedeDomicilio" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>URL Web:</label>
                                <input type="text" id="txtSedeWeb" name="txtSedeWeb" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Teléfono:</label>
                                <input type="text" id="txtSedeTelefono" name="txtSedeTelefono" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Contacto:</label>
                                <input type="text" id="txtSedeContacto" name="txtSedeContacto" class="form-control">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Comentarios:</label>
                                <textarea type="text" id="txtSedeComentario" name="txtSedeComentario" class="form-control"></textarea>
                            </div>
                        </div>         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarSedeEnSelect();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAgregarSubSede" tabindex="-1" role="dialog" aria-labelledby="modalAgregarSubSedeLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Agregar Subsede</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Descripción: *</label>
                                <input type="text" id="txtSubSedeNombre" name="txtSubSedeNombre" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nombre corto: *</label>
                                <input type="text" id="txtSubSedeCodigo" name="txtSubSedeCodigo" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Domicilio:</label>
                                <input type="text" id="txtSubSedeDomicilio" name="txtSubSedeDomicilio" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>URL Web:</label>
                                <input type="text" id="txtSubSedeWeb" name="txtSubSedeWeb" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Teléfono:</label>
                                <input type="text" id="txtSubSedeTelefono" name="txtSubSedeTelefono" class="form-control">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Contacto:</label>
                                <input type="text" id="txtSubSedeContacto" name="txtSubSedeContacto" class="form-control">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Comentarios:</label>
                                <textarea type="text" id="txtSubSedeComentario" name="txtSubSedeComentario" class="form-control"></textarea>
                            </div>
                        </div>         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarSubSedeEnSelect();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
</div>
<script>
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
           	var grilla = $('#grilla').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "paging": false,
            "ajax": "{{ asset('/actividad/actividad/cargarGrillaSedeActividad?idactividad='.$globalId) }}",
            "columnDefs": [
             	{
                    "targets": [0],
                    "width": 600
                },
                {
                    "targets": [1],
                    "width": 600
                },
                {
                    "targets": [2],
                    "width": 600
                },
                {
                    "targets": [3],
                    "width": 500
                },
                {
                    "targets": [4],
                    "width": 500
                },
                {
                    "targets": [5],
                    "width": 500
                }
            ],
        });
    }

    function fotorgaTitulo(){
        if($("#lstTitulo").val() == "1")
            $("#divTitulo").show();
        else {
            $("#divTitulo").hide();
            $("#txtTitulo").val("");
        }
    }

    function abrirSedeActividad(){
        $("#lstSede").prop("selectedIndex", "-1");
        $('#lstSede').selectpicker('refresh');
        $("#lstSubSede").prop("selectedIndex", "-1");
        $('#lstSubSede').selectpicker('refresh');
        $("#lstDpto").prop("selectedIndex", "-1");
        $('#lstDpto').selectpicker('refresh');
        $("#lstDirector").prop("selectedIndex", "-1");
        $('#lstDirector').selectpicker('refresh');
        $("#lstSubDirector").prop("selectedIndex", "-1");
        $('#lstSubDirector').selectpicker('refresh');
        $('#modalAgregar').modal('toggle');
    }

    function abrirAltaSede(){
        if($("#lstSede option:selected").val() == "0"){
            $('#modalAgregarSede').modal('toggle');
        }
    }

    function agregarSedeEnSelect(){
        descripcion = $("#txtSedeNombre").val();
        nombre = $("#txtSedeCodigo").val();
        domicilio = $("#txtSedeDomicilio").val();
        url = $("#txtSedeWeb").val();
        telefono = $("#txtSedeTelefono").val();
        contacto = $("#txtSedeContacto").val();
        comentario = $("#txtSedeComentario").val();
        if(descripcion != "" && nombre != ""){
            $.ajax({
                type: "GET",
                url: "{{ asset('publico/sede/agregarSedeAjax') }}",
                data: { 
                        descripcion: descripcion,
                        nombre: nombre,
                        domicilio:domicilio,
                        url:url,
                        telefono:telefono,
                        contacto:contacto,
                        comentario:comentario
                     },
                async: true,
                dataType: "json",
                success: function (data) {
                    $("#lstSede").prop("selectedIndex", "-1");
                    $('#lstSede').selectpicker('refresh');
                    $("#lstSubSede").prop("selectedIndex", "-1");
                    $('#lstSubSede').selectpicker('refresh');
                    $("#lstDpto").prop("selectedIndex", "-1");
                    $('#lstDpto').selectpicker('refresh');
                    $("#lstDirector").prop("selectedIndex", "-1");
                    $('#lstDirector').selectpicker('refresh');
                    $("#lstSubDirector").prop("selectedIndex", "-1");
                    $('#lstSubDirector').selectpicker('refresh');
                    frecargarSedeEnSelect(data.idSede);
                }
            });
            $('#modalAgregarSede').modal('toggle');
        } else {
            alert("Complete todos los datos");
        }
    }

    function frecargarSedeEnSelect(idSede){
        $.ajax({
            type: "GET",
            url: "{{ asset('publico/sede/obtenerTodos') }}",
            async: true,
            dataType: "json",
            success: function (data) {
                $("#lstSede").empty();
                $("#lstSubSede").empty();
                $.each(data, function (i, item) {
                    $('#lstSede').append($('<option>', {
                        value: item.idsede, 
                        text: item.descsede
                    }));
                    $('#lstSubSede').append($('<option>', {
                        value: item.idsede, 
                        text: item.descsede
                    }));
                });
                $("#lstSede").val(idSede);
                $('#lstSede').selectpicker('refresh');
                $("#lstSubSede").val(idSede);
                $('#lstSubSede').selectpicker('refresh');
            }
        });
    }

    function abrirAltaSubSede(){
        if($("#lstSubSede option:selected").val() == "0"){
            $('#modalAgregarSubSede').modal('toggle');
        }
    }

    function abrirAltaDpto(){
        if($("#lstDpto option:selected").val() == "0"){
            $('#modalAgregar').modal('toggle');
        }
    }

    function agregarSedeActividadEnGrilla(){
    	var grilla = $('#grilla').DataTable();
        idSede = $("#lstSede option:selected").val();
        grilla.row.add([
            $("#lstSede option:selected").text() + "<input type='hidden' name='txtSede[]' value='" + $("#lstSede option:selected").val() + "'>",
            $("#lstSubSede option:selected").text() + "<input type='hidden' name='txtSubSede[]' value='" + $("#lstSede option:selected").val() + "'>",
            $("#lstDpto option:selected").text() + "<input type='hidden' name='txtDpto[]' value='" + $("#lstDpto option:selected").val() + "'>",
            $("#lstDirector option:selected").text() + "<input type='hidden' name='txtDirector[]' value='" + $("#lstDirector option:selected").val() + "'>",
            $("#lstSubDirector option:selected").text() + "<input type='hidden' name='txtSubDirector[]' value='" + $("#lstSubDirector option:selected").val() + "'>",
            "<button type='button' class='btn btn-secondary fa fa-minus-circle' value='"+idSede+"' onclick='eliminar(this)'></button>"
        ]).draw();

        $('#modalAgregar').modal('toggle');
    }

    function abrirEditar(idsedeactividad){
    	idsede = $("[name='txtSede[" + idsedeactividad + "]']" ).val();
    	if(!idsede) idsede = "-1";

    	idsubsede = $("[name='txtSubSede[" + idsedeactividad + "]']" ).val();
		if(!idsubsede) idsubsede = "-1";

		dpto = $("[name='txtDpto[" + idsedeactividad + "]']" ).val();
		if(!dpto) dpto = "-1";

		director = $("[name='txtDirector[" + idsedeactividad + "]']" ).val();
		if(!director) director = "-1";

		subdirector = $("[name='txtSubDirector[" + idsedeactividad + "]']" ).val();
		if(!subdirector) subdirector = "-1";

		$("#lstSede").val(idsede);
		$('#lstSede').selectpicker('refresh');
		$("#lstSubSede").val(idsubsede);
		$('#lstSubSede').selectpicker('refresh');
		$("#lstDpto").val(dpto);
		$('#lstDpto').selectpicker('refresh');
		$("#lstDirector").val(director);
		$('#lstDirector').selectpicker('refresh');
		$("#lstSubDirector").val(subdirector);
		$('#lstSubDirector').selectpicker('refresh');
		$('#modalAgregar').modal('toggle');
    }
    function eliminar(obj){
        var grilla = $('#grilla').DataTable();
        $(obj).parent().parent().addClass('borrar');
        grilla.rows('.borrar').remove().draw(false);
        $('#modalmsg').modal('toggle');
    }

    $("#lstSede").prop("selectedIndex", "-1");
    $('#lstSede').selectpicker('refresh');
    $("#lstSubSede").prop("selectedIndex", "-1");
    $('#lstSubSede').selectpicker('refresh');
    $("#lstDpto").prop("selectedIndex", "-1");
    $('#lstDpto').selectpicker('refresh');
    $("#lstDirector").prop("selectedIndex", "-1");
    $('#lstDirector').selectpicker('refresh');
    $("#lstSubDirector").prop("selectedIndex", "-1");
    $('#lstSubDirector').selectpicker('refresh');
    @if(!isset($actividad))

    @else
        @if($actividad->titulo_que_otorga != "")
            $("#divTitulo").show();
        @endif
    @endif
</script>
@endsection