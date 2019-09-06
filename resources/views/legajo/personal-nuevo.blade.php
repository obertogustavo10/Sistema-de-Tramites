@extends('plantilla')
@section('titulo', "Datos del personal")
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($legajo->idpersonal) && $legajo->idpersonal > 0 ? $legajo->idpersonal : 0; ?>';
    <?php $globalId = isset($legajo->idpersonal) ? $legajo->idpersonal : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item">Legajo</li>
    <li class="breadcrumb-item"><a href="/legajo/personal">Personal</a></li>
    <li class="breadcrumb-item active">Datos personales</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/legajo/personal/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/legajo/personal";
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
<div class="row">
    <div id = "msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="#">Datos personales</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Estudios cursados</a>
          </li>
        </ul>
    </div>
</div>

<br>
<form id="form1" method="POST" }}">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
        <div class="form-group col-lg-2">
            <label>Tipo de documento: *</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstTipoDocumento" name="lstTipoDocumento" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                @for ($i = 0; $i < count($array_tipodocumento); $i++)
                    @if (isset($legajo) and $array_tipodocumento[$i]->idtidoc == $legajo->fk_idtidoc)
                        <option selected value="{{ $array_tipodocumento[$i]->idtidoc }}">{{ $array_tipodocumento[$i]->desctidoc }}</option>
                    @else
                        <option value="{{ $array_tipodocumento[$i]->idtidoc }}">{{ $array_tipodocumento[$i]->desctidoc }}</option>
                    @endif
                @endfor
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label>Nro de documento: *</label>
        </div>
        <div class="form-group col-lg-4">
            <input required onchange="fValidarNroDocumento();" type="text" id="txtNroDocumento" name="txtNroDocumento" class="form-control" value="{{$legajo->documento or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Nombre: *</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="{{$legajo->nombre or ''}}" required>
        </div>
        <div class="form-group col-lg-2">
            <label>Apellido: *</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" class="form-control" id="txtApellido" name="txtApellido" value="{{$legajo->apellido or ''}}" required>
        </div>
        <div class="form-group col-lg-2">
            <label>Email:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="email" id="txtEmail" name="txtEmail" class="form-control" required value="{{$legajo->email or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Celular:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtCelular" name="txtCelular" class="form-control" required value="{{$legajo->celular or ''}}" required>
        </div>
        <div class="form-group col-lg-2">
            <label>Teléfono particular:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtTelParticular" name="txtTelParticular" class="form-control" required value="{{$legajo->telparticular or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Teléfono laboral:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtTelLaboral" name="txtTelLaboral" class="form-control" required value="{{$legajo->tellaboral or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Nro de Legajo:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtNroLegajo" name="txtNroLegajo" class="form-control" value="{{$legajo->nro_legajo or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Sexo:</label>
        </div>
        <div class="form-group col-lg-4">
             <select id="lstSexo" name="lstSexo" class="form-control">
                <option value="M" {{isset($legajo) && $legajo->sexo == 'M'? 'selected' : ''}}>Masculino</option>
                <option value="F" {{isset($legajo) &&$legajo->sexo == 'F'? 'selected' : ''}}>Femenino</option>
             </select>
        </div>
        <div class="form-group col-lg-2">
            <label>Fecha de Nacimiento:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="date" id="txtFechaNacimiento" name="txtFechaNacimiento" class="form-control" placeholder="Formato DD-MM-AAAA" value="{{$legajo->fechanacimiento or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>País de nacimiento:</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstPaisNacimiento" name="lstPaisNacimiento" class="form-control selectpicker" data-live-search="true">
                @for ($i = 0; $i < count($array_pais); $i++)
                    @if (isset($legajo) and $array_pais[$i]->idpais == $legajo->fk_idpais)
                        <option selected value="{{ $array_pais[$i]->idpais }}">{{ $array_pais[$i]->descpais }}</option>
                    @else
                        <option value="{{ $array_pais[$i]->idpais }}">{{ $array_pais[$i]->descpais }}</option>
                    @endif
                @endfor
                @if (isset($legajo) and $legajo->fk_idpais == "")
                    <script >$("#lstPaisNacimiento").val("");</script>
                @endif
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label>Nacionalidad:</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstPaisNacionalidad" name="lstPaisNacionalidad" class="form-control selectpicker" data-live-search="true">
                <option value="" disabled selected>Seleccionar</option>
                @for ($i = 0; $i < count($array_pais); $i++)
                    @if (isset($legajo) and $array_pais[$i]->idpais == $legajo->fk_nacionalidad)
                        <option selected value="{{ $array_pais[$i]->idpais }}">{{ $array_pais[$i]->nacionalidad }}</option>
                    @else
                        <option value="{{ $array_pais[$i]->idpais }}">{{ $array_pais[$i]->nacionalidad }}</option>
                    @endif
                @endfor
                @if (isset($legajo) and $legajo->fk_nacionalidad == "")
                    <script >$("#lstPaisNacionalidad").val("");</script>
                @endif
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label>CUIT:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtCuit" name="txtCuit" class="form-control" required value="{{$legajo->cuit or ''}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Situación impositiva:</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstSituacionImpositiva" name="lstSituacionImpositiva" class="form-control">
                <option value="" disabled selected>Seleccionar</option>
                @for ($i = 0; $i < count($array_situacionimpositiva); $i++)
                    @if (isset($legajo) and $array_situacionimpositiva[$i]->idiva == $legajo->fk_idiva)
                        <option selected value="{{ $array_situacionimpositiva[$i]->idiva }}">{{ $array_situacionimpositiva[$i]->desciva }}</option>
                    @else
                        <option value="{{ $array_situacionimpositiva[$i]->idiva }}">{{ $array_situacionimpositiva[$i]->desciva }}</option>
                    @endif
                @endfor
                @if (isset($legajo) and $legajo->fk_idiva == "")
                    <script >$("#lstSituacionImpositiva").val("");</script>
                @endif
            </select>
        </div>
    </div>
</form>
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
    cargarProvincias();
    function fValidarNroDocumento(){
        nro_documento = $("#txtNroDocumento").val();
         $.ajax({
            type: "GET",
            url: "{{ asset('legajo/validarNroDocumento') }}",
            data: { nro_documento:nro_documento, legajo:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if(data == true){
                    $("#txtNroDocumento").empty();
                    msgShow("El número de documento ya existe", "danger");    
                } else {
                    $("#msg").hide();
                }
                
            }
        });
    }

    function cargarProvincias(){
        pais = $("#lstPais option:selected").val();
        $.ajax({
            type: "GET",
            url: "{{ asset('publico/pais/buscarProvincia') }}",
            data: { pais:pais },
            async: true,
            dataType: "json",
            success: function (data) {
                $("#lstProvincia").empty();
                $.each(data, function (i, item) {
                    $('#lstProvincia').append($('<option>', {
                        value: item.id, 
                        text: item.nombre
                    }));
                });
            }
        });
    }

    @if(isset($legajo) == false)
        $("#lstArea").val("");
        $("#lstSexo").val("");
        $("#lstTipoDocumento").val("");
        $("#lstPaisNacimiento").val("");
        $("#lstSituacionImpositiva").val("");
        $("#lstEstado").val("");
    @endif
</script>
@endsection