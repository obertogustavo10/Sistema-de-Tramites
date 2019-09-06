@extends('autogestion.plantilla')
@section('titulo', $titulo)
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="home">Inicio</a></li>
    <li class="breadcrumb-item active">Historia académica</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="{{env('APP_URL_AUTOGESTION')}}/home";
}
</script>
@endsection
@section('contenido')
<form id="form1" method="POST">
<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <div class="form-group col-lg-12">
            <label>Plan:</label>
        </div>
        <div class="form-group col-lg-12">
        @if (isset($array_carrera) and count($array_carrera)==0)
            <p>No registra carreras activas.</p>
        @else
            <select id="lstPlan" name="lstPlan" class="form-control" onchange="this.form.submit()">
                @for ($i = 0; $i < count($array_carrera); $i++)
                    @if($idPlan == $array_carrera[$i]->fk_idplan)
                        <option value="{{ $array_carrera[$i]->fk_idplan }}" selected>{{ $array_carrera[$i]->descplan }} - Estado: ({{ ucwords(strtolower($array_carrera[$i]->descestadoalu)) }})</option>
                    @else
                        <option value="{{ $array_carrera[$i]->fk_idplan }}">{{ $array_carrera[$i]->descplan }} - Estado: ({{ ucwords(strtolower($array_carrera[$i]->descestadoalu)) }})</option>
                    @endif
                @endfor
            </select>
        @endif
        </div> 
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="font-weight-bold">Porcentaje de aprobación <span class="float-right">{{$porcentaje_aprobacion}}%</span></h4>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$porcentaje_aprobacion}}%" aria-valuenow="{{$porcentaje_aprobacion}}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-success">Materias inscriptas actualmente</h6>
        </div>
        <div class="card-body">
        @if(!isset($array_materia_encurso))
            <p>No tiene materias inscriptas.</p>
        @else
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" width="30%" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="20%" aria-controls="dataTable" rowspan="1" colspan="1" >Horario</th>
                    <th width="20%" aria-controls="dataTable" rowspan="1" colspan="1" >Profesor</th>
                    <th aria-controls="dataTable" rowspan="1" colspan="1" >Sede</th>
                    <th aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                @foreach($array_materia_encurso as $materia)
                    <tr role="row">
                      <td>{{$materia->descmateria}}</td>
                      <td>{{$materia->descdia . " de " . $materia->horainiciocursada . " a " . $materia->horafincursada}}</td>
                      <td>{{isset($materia->apellido)?$materia->apellido . " " . $materia->nombre:""}}</td>
                      <td>{{isset($materia->descsede)?$materia->descsede:""}}</td>
                      <td>{{isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""}} hs.</td>
                    </tr>
                @endforeach
               </tbody>
            </table></div></div></div>
        </div>
        @endif
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Materias aprobadas</h6>
        </div>
        <div class="card-body">
        @if(!isset($array_materias_aprobadas))
            <p>No tiene historia académica para el plan seleccionado.</p>
        @else
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Nota</th>
                    <th width="10%"" aria-controls="dataTable" rowspan="1" colspan="1" >Fecha acta</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Libro</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Folio</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Exime</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                @foreach($array_materias_aprobadas as $materia)
                  @if($materia->nota_alumno)
                    <tr role="row">
                      <td>{{$materia->descmateria}}</td>
                      <td>{{isset($materia->nota_descalumno)?$materia->nota_descalumno:""}}</td>
                      <td>{{isset($materia->fechaacta)?date_format(date_create($materia->fechaacta), 'd/m/Y'):""}}</td>
                      <td>{{isset($materia->libro)?$materia->libro:""}}</td>
                      <td>{{isset($materia->folio)?$materia->folio:""}}</td>
                      <td>{{isset($materia->resolucionexime)? "Res. " . $materia->resolucionexime:""}}</br>
                      {{isset($materia->expedienteexime)? "Exp. " . $materia->expedienteexime:""}}</br>
                      {{isset($materia->fecharesolexime)?date_format(date_create($materia->fecharesolexime), 'd/m/Y'):""}}</td>
                      <td>{{isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""}} hs.</td>
                    </tr>
                @endif
                @endforeach
               </tbody>
            </table></div></div></div>
        </div>
        @endif
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Materias que restan aprobar</h6>
        </div>
        <div class="card-body">
        @if(!isset($array_materias_restanaprobar))
            <p>No tiene historia académica para el plan seleccionado.</p>
        @else
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                @foreach($array_materias_restanaprobar as $materia)
                  <tr role="row">
                    <td>{{$materia->descmateria}}</td>
                    <td>{{isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""}} hs.</td>
                  </tr>
                @endforeach
               </tbody>
            </table></div></div></div>
        </div>
        @endif
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Materias ausentes/desaprobadas</h6>
        </div>
        <div class="card-body">
        @if(!isset($array_materias_ausentesdesaprobadas))
            <p>No tiene historia académica para el plan seleccionado.</p>
        @else
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Nota</th>
                    <th width="10%"" aria-controls="dataTable" rowspan="1" colspan="1" >Fecha acta</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Libro</th>
                    <th width="8%" aria-controls="dataTable" rowspan="1" colspan="1" >Folio</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Exime</th>
                    <th width="7%" aria-controls="dataTable" rowspan="1" colspan="1" >Carga horaria</th>
                </tr>
              </thead>
              <tbody>
                @foreach($array_materias_ausentesdesaprobadas as $materia)
                  @if($materia->nota_alumno)
                    <tr role="row">
                      <td>{{$materia->descmateria}}</td>
                      <td>{{isset($materia->nota_descalumno)?$materia->nota_descalumno:""}}</td>
                      <td>{{isset($materia->fechaacta)?date_format(date_create($materia->fechaacta), 'd/m/Y'):""}}</td>
                      <td>{{isset($materia->libro)?$materia->libro:""}}</td>
                      <td>{{isset($materia->folio)?$materia->folio:""}}</td>
                      <td>{{isset($materia->resolucionexime)? "Res. " . $materia->resolucionexime:""}}</br>
                      {{isset($materia->expedienteexime)? "Exp. " . $materia->expedienteexime:""}}</br>
                      {{isset($materia->fecharesolexime)?date_format(date_create($materia->fecharesolexime), 'd/m/Y'):""}}</td>
                      <td>{{isset($materia->cargahorariaenhs)?$materia->cargahorariaenhs:""}} hs.</td>
                    </tr>
                @endif
                @endforeach
               </tbody>
            </table></div></div></div>
        </div>
        @endif
        </div>
      </div>
    </div>
    @if(isset($fecha_materia))
    <div class="col-md-12">
    Fecha de última materia: {{ ($fecha_materia)?date_format(date_create($fecha_materia), 'd/m/Y'):""}}
    </div>
    @endif
</form>
@endsection