@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($materia->idmateria) && $materia->idmateria > 0 ? $materia->idmateria : 0; ?>';
    <?php $globalId = isset($materia->idmateria) ? $materia->idmateria : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/actividad/materias">Materias</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/materia/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/actividad/materias";
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
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$materia->ncmateria or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Descripción: *</label>
                    <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="{{$materia->descmateria or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Departamento:</label>
                    <select id="lstDpto" name="lstDpto" class="form-control">
                        <option value="" disabled selected>Seleccionar</option>
                        @for ($i = 0; $i < count($array_dpto); $i++)
                            @if (isset($materia) and $array_dpto[$i]->iddepto == $materia->fk_iddepto)
                                <option selected value="{{ $array_dpto[$i]->iddepto }}">{{ $array_dpto[$i]->descdepto }}</option>
                            @else
                                <option value="{{ $array_dpto[$i]->iddepto }}">{{ $array_dpto[$i]->descdepto }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Actividad:</label>
                    <select id="lstActividad" name="lstActividad" class="form-control" required>
                        <option value="" disabled selected>Seleccionar</option>
                        @for ($i = 0; $i < count($array_actividad); $i++)
                            @if (isset($materia) and $array_actividad[$i]->idactividad == $materia->fk_idactividad)
                                <option selected value="{{ $array_actividad[$i]->idactividad }}">{{ $array_actividad[$i]->descactividad }}</option>
                            @else
                                <option value="{{ $array_actividad[$i]->idactividad }}">{{ $array_actividad[$i]->descactividad }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>Período:</label>
                    <input type="number" id="txtPeriodo" name="txtPeriodo" class="form-control" value="{{$materia->periodo or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Carga horaria en días:</label>
                    <input type="number" id="txtHsEnDias" name="txtHsEnDias" class="form-control" value="{{$materia->cargahorariaendias or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Carga horaria en horas:</label>
                    <input type="number" id="txtHsEnHs" name="txtHsEnHs" class="form-control" value="{{$materia->cargahorariaenhs or ''}}" required>
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
</script>
@endsection