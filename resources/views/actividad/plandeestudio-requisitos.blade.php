@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>

<script>
    globalId = '<?php echo isset($plandeestudio->idplan) && $plandeestudio->idplan > 0 ? $plandeestudio->idplan : 0; ?>';
    <?php $globalId = isset($plandeestudio->idplan) ? $plandeestudio->idplan : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/actividad/planes">Planes de estudio</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/actividad/plan/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if(isset($plandeestudio->publicado) && $plandeestudio->publicado == 1)
    <li class="btn-item"><a title="Mover a borrador" href="#" class="fa fa-pencil" aria-hidden="true" onclick="planBorrador();"><span>Mover a Borrador</span></a>
    </li>
    @else
    <li class="btn-item"><a title="Publicar plan" href="#" class="fa fa-share" aria-hidden="true" onclick="planPublicar();"><span>Publicar</span></a>
    </li>    
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/actividad/planes";
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
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link" href="/actividad/plan/{{ $globalId }}">Descripción del plan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/actividad/plan/{{ $globalId }}/materias">Materias</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="/actividad/plan/{{ $globalId }}/requisitos">Requisitos</a>
                  </li>
                </ul>
            </div>
        </div>
        <form id="form1" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Requisitos del plan
                            <div class="pull-right">
                                <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirAgregarRequisitos()"></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="txtPublicado" name="txtPublicado"  value="{{$plandeestudio->publicado or ''}}" required>
                            <table id="grilla" class="display">
                                <thead>
                                    <tr>
                                        <th>Requisito</th>
                                        <th>Descripción</th>
                                        <th>Descripción para la Web</th>
                                        <th>Tipo</th>
                                        <th>Obligatorio</th>
                                        <th>Fecha tope</th>
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
                <div class="modal-content" style="width: 800px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBuscarLabel">Listado de requisitos</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <table id="grillaRequisitos" class="display">
                                <thead>
                                    <tr>
                                        <th>idrequisito</th>
                                        <th></th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                            </table> 
            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agregarRequisitosEnGrilla();">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    $("#form1").validate();
    cargarGrilla();
    cargarGrillaRequisitosDisponibles();

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
    @if(!isset($plandeestudio))
        $("#lstActividad").prop("selectedIndex", "-1");
    @endif
    
    function cargarGrilla() {
           var grilla = $('#grilla').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "paging": false,
            "ajax": "{{ asset('/actividad/plan/requisito/cargarGrillaRequisitosDelPlan?idplan='.$globalId) }}",
            "columnDefs": [
                {
                    "targets": [0],
                    "width": 20
                },
                 {
                    "targets": [1],
                    "width": 280
                },
                {
                    "targets": [2],
                    "width": 280
                },
                {
                    "targets": [3],
                    "width": 180
                },
                {
                    "targets": [4],
                    "width": 40
                },
                   {
                    "targets": [5],
                    "width": 10
                }
            ]
        });
    }

    function cargarGrillaRequisitosDisponibles() {
        var grilla = $('#grillaRequisitos').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": true,
            "bInfo": true,
            "bSearchable": true,
            "pageLength": 10,
            "ajax": "{{ asset('/actividad/plan/requisito/cargarGrillaRequisitosDisponibles?idplan='.$globalId) }}",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false,
                    "orderable": false
                },
                {
                    "targets": [1],
                    "searchable": false,
                    "orderable": false
                },
                {
                    "targets": [2],
                    "orderable": false
                },
                {
                    "targets": [3],
                    "orderable": false
                }
            ]
        });
    }

    function abrirAgregarRequisitos() {
        $('#modalAgregar').modal('toggle');
    }

    function agregarRequisitosEnGrilla() {
        var grilla = $('#grilla').DataTable();
        var grillaRequisitos = $('#grillaRequisitos').DataTable();
        var pos = 0;

        $('#grillaRequisitos input[type=checkbox]').each(function () {
            if (this.checked) {
                id = grillaRequisitos.row(pos).data()[0];

                if ($("[name*='chk_Familia_" + id + "']").length == 0) {
                    //Si no esta lo agrega
                    grilla.row.add([
                        grillaRequisitos.row(pos).data()[3],
                        grillaRequisitos.row(pos).data()[2],
                        "<textarea name='descripcionweb[" +  id + "]' class='form-control' style='height: 6rem !important' />",
                        "<select required id='tiporequisito_" + id + "' name='tiporequisito[" + id + "]' class='form-control'><option value='' disabled selected>Seleccionar</option><option value='0'>Previo</option><option value='1'>De cursada</option><option value='2'>Posterior</option>",
                        "<select required id='obligatorio_" +  id + "' name='obligatorio[" +  id + "]' type='checkbox' class='form-control' /><option value='' disabled selected>Seleccionar</option><option value='1'>Si</option><option value='0'>No</option></select>",
                        "<input type='date' name='fecha[" +  id + "]' class='form-control' />",
                        "<button type='button' class='btn btn-secondary fa fa-minus-circle' onclick='eliminarRequisito(" +  id + ")'></button>"
                    ]).draw();
                }
            }
            pos++;
        });
        $('#modalAgregar').modal('toggle');
    }
    function eliminarRequisito(id){
        var grilla = $('#grilla').DataTable();
        $("#obligatorio_" + id).parent().parent().addClass('borrar');
        grilla.rows('.borrar').remove().draw(false);
        $('#modalmsg').modal('toggle');
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
</script>
@endsection