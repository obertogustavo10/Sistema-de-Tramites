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
    <li class="breadcrumb-item active">Carreras activas</li>
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
<form id="form1" method="POST" }}">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <div class="form-group col-lg-12">
            <label>Carreras activas:</label>
        </div>
        <div class="form-group col-lg-12">
        @if (isset($array_carreraactiva) and count($array_carreraactiva)==0)
        	<p>No registra carreras activas.</p>
        @else
            <select id="lstCarreraActiva" name="lstCarreraActiva" class="form-control">
                @for ($i = 0; $i < count($array_carreraactiva); $i++)
                    <option value="{{ $array_carreraactiva[$i]->fk_idplan }}">{{ $array_carreraactiva[$i]->descplan }}</option>
                @endfor
            </select>
        @endif
        </div> 
    </div>
</form>
@endsection