@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($grupo->idgrupo) && $grupo->idgrupo > 0 ? $grupo->idgrupo : 0; ?>';
    <?php $globalId = isset($grupo->idgrupo) ? $grupo->idgrupo : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/actividad/modulos">Módulos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/modulo/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/actividad/modulos";
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
                    <label>Nombre corto: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$grupo->ncgrupo or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Descripción:</label>
                    <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="{{$grupo->descgrupo or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Plan de estudio: </label>
                    <select id="lstPlan" name="lstPlan" class="form-control">
                        <option value="" disabled selected>Seleccionar</option>
                        @for ($i = 0; $i < count($array_plan); $i++)
                            @if (isset($grupo) and $array_plan[$i]->idplan == $grupo->fk_idplan)
                                <option selected value="{{ $array_plan[$i]->idplan }}">{{ $array_plan[$i]->ncplan }}</option>
                            @else
                                <option value="{{ $array_plan[$i]->idplan }}">{{ $array_plan[$i]->ncplan }} {{ $array_plan[$i]->descplan }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
               <div class="form-group col-lg-6">
                    <label>Abre inscripción: *</label>
                    <select id="lstAbreInscripcion" name="lstAbreInscripcion" class="form-control" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="1" {{isset($grupo) && $grupo->abreinscripcion == 1? 'selected' : ''}}>Si</option>
                        <option value="0" {{isset($grupo) && $grupo->abreinscripcion == 0? 'selected' : ''}}>No</option>
                    </select>
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