@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($sede->idsede) && $sede->idsede > 0 ? $sede->idsede : 0; ?>';
    <?php $globalId = isset($sede->idsede) ? $sede->idsede : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/publico/sedes">Sedes</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/publico/sede/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/publico/sedes";
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
                    <label>Descripción: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$sede->descsede or ''}}" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Nombre corto:</label>
                    <input type="text" id="txtCodigo" name="txtCodigo" class="form-control" value="{{$sede->ncsede or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Domicilio:</label>
                    <input type="text" id="txtDomicilio" name="txtDomicilio" class="form-control" value="{{$sede->domicilio or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>URL Web:</label>
                    <input type="text" id="txtWeb" name="txtWeb" class="form-control" value="{{$sede->urlweb or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Teléfono:</label>
                    <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" value="{{$sede->telefono or ''}}">
                </div>
                <div class="form-group col-lg-6">
                    <label>Contacto:</label>
                    <input type="text" id="txtContacto" name="txtContacto" class="form-control" value="{{$sede->contacto or ''}}">
                </div>
                <div class="form-group col-lg-12">
                    <label>Comentarios:</label>
                    <textarea type="text" id="txtComentario" name="txtComentario" class="form-control">{{$sede->comentarios or ''}}</textarea>
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