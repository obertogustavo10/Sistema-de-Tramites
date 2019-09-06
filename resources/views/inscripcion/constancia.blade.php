@extends('plantilla')
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
    <li class="breadcrumb-item">Legajo</li>
    <li class="breadcrumb-item"><a href="/legajo/alumnos">Alumnos</a></li>
    <li class="breadcrumb-item active">Constancias de Inscripción</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/legajo/alumnos";
}
</script>
@endsection
@section('contenido')
<form id="form1" method="POST">
<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
  <div class="row">
    <div class="form-group col-lg-2">
      <label>Tipo de documento: *</label>
    </div>
    <div class="form-group col-lg-4">
        <select id="lstTipoDocumento" name="lstTipoDocumento" class="form-control" disabled>
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
        <input onchange="fValidarNroDocumento();" type="text" id="txtNroDocumento" name="txtNroDocumento" class="form-control" disabled value="{{$legajo->documento or ''}}">
    </div>
    <div class="form-group col-lg-2">
        <label>Nombre: *</label>
    </div>
    <div class="form-group col-lg-4">
        <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="{{$legajo->nombre or ''}}" disabled>
    </div>
    <div class="form-group col-lg-2">
        <label>Apellido: *</label>
    </div>
    <div class="form-group col-lg-4">
        <input type="text" class="form-control" id="txtApellido" name="txtApellido" value="{{$legajo->apellido or ''}}" disabled>
    </div>
  </div>

    <div class="row">
    <div class="col-md-12">
      <div class="card mb-3 mt-3">
        <div class="card-header">
          Último comprobante de inscripción válido
        </div>
        <div class="card-body">
        @if(!isset($array_comprobantes))
            <p>No tiene carreras inscriptas.</p>
        @else
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
              <thead>
                <tr role="row">
                    <th tabindex="0" width="30%" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Plan inscripto</th>
                    <th width="20%" aria-controls="dataTable" rowspan="1" colspan="1" >Acción</th>
                </tr>
              </thead>
              <tbody>
                @foreach($array_comprobantes as $comprobante)
                    <tr role="row">
                      <td>{{$comprobante->descplan}} - Res. {{$comprobante->resolucion}}</td>
                      <td><a target="_blank" class="btn btn-secondary btn-block" title="Descargar" style="cursor: pointer" href="/cd-inscripcion/comprobante/{{$comprobante->idformu}}">Descargar</a></td>
                    </tr>
                @endforeach
               </tbody>
            </table></div></div></div>
        </div>
        @endif
        </div>
    </div>
    </div>
</form>
@endsection