@extends('plantilla')

@section('titulo', $titulo)

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($cursada->idcursada) && $cursada->idcursada > 0 ? $cursada->idcursada : 0; ?>';
    <?php $globalId = isset($cursada->idcursada) ? $cursada->idcursada : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item">Seguimiento</li>
    <li class="breadcrumb-item"><a href="/seguimiento/inscripciones">Inscripciones</a></li>
    <li class="breadcrumb-item active">Inscriptos</a></li>

</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/seguimiento/inscriptos/" + globalId);'><span>Recargar</span></a></li>
    <li class="btn-item"><a title="Imprimir listado" href="#" class="fa fa-print" aria-hidden="true" onclick='window.location.replace("/");'><span>Imprimir listado</span></a></li>
    <li class="btn-item"><a title="Actas" href="#" class="fa fa-file-text-o" aria-hidden="true" onclick='window.location.replace("/");'><span>Actas</span></a></li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-3 mb-4">
              <div class="card border-left-primary">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Alumnos inscriptos</div>
                      <div id="divAlumnosActivos" class="h6 mb-0 text-gray-800">{{$cant_inscriptos}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-3 mb-4">
              <div class="card border-left-success">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Día y Horario</div>
                      <div id="divInscriptos" class="h6 mb-0 text-gray-800">{{ $cursada->descdia }} de {{ $cursada->horainiciocursada }} a {{ $cursada->horafincursada }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clock-o fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="card border-left-info">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Docente</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div id="divOcupacion" class="h6 mb-0 mr-3 text-gray-800">{{ $cursada->apellido }} {{ $cursada->nombre }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-3 mb-4">
              <div class="card border-left-info">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Sede</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div id="divOcupacion" class="h6 mb-0 mr-3 text-gray-800">{{ $cursada->descsede }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-university fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <table id="grilla" class="display">
            <thead>
                <tr>
                    <th>Nro documento</th>
                    <th>Nombre y apellido</th>
                    <th>Email</th>
                    <th>Nota</th>
                </tr>
            </thead>
        </table> 
<script>
    var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "bInfo": true,
        "bSearchable": true,
        "pageLength": 50,
        "order": [[ 0, "asc" ]],
        "ajax": "{{ asset('/seguimiento/inscriptos/cargarGrilla?oferta='.$globalId) }}"
    });
    function fAccion(idAlumno, documento){
        modificado = false;
        accion = $("#lstAccion_"+documento).val();
        if(accion == "simular-login"){
            window.open("{{ env('APP_URL_AUTOGESTION') }}/sistema/simular-login/" + documento, '_blank');    
        }if(accion == "constancia-inscripcion"){
            window.open("/inscripcion/constancia/" + idAlumno, '_self');    
        }
        $("#lstAccion_"+documento).prop("selectedIndex", "");
    }
</script>
@endsection