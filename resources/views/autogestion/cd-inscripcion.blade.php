@extends('autogestion.plantilla')
@section('titulo', $titulo)
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{env('APP_URL_AUTOGESTION')}}/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{env('APP_URL_AUTOGESTION')}}/inscripcion">Inscripción</a></li>
    <li class="breadcrumb-item"><a href="{{env('APP_URL_AUTOGESTION')}}/cd-consideraciones">Consideraciones</a></li>
    <li class="breadcrumb-item active">Inscripción</li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<br>
<form id="form1" method="POST" }}>
<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
@if(!$plan_cd_activo)
<div class="row">
	<div class="col-md-12">
		<div class="shadow alert alert-danger" role="alert">
			<h4 class="alert-heading">Atención</h4>
		  <hr>
		  	<p>No es alumno activo</p>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-md-12">
		<div class="shadow alert alert-success" role="alert">
			<h4 class="alert-heading">Atención</h4>
		  <hr>
		  	<p>Sólo podes inscribirte en aquellas materias y horarios que aún tienen <strong>vacantes disponibles</strong>.</p>
			<p>Si se ofrece para inscribirte una materia que <strong>ya tenes aprobada</strong>, <strong>ignorala, no debes inscribirte</strong>.</p>
		</div>
	</div>
	<div class="col-md-12">
	  <div class="card shadow mb-4">
	    <div class="card-header py-3">
	      <h6 class="m-0 font-weight-bold text-primary">Inscripción a materias</h6>
	    </div>
	    <div class="card-body">
    	@if(count($array_oferta)>0)
	      <p>Selecciona el dìa y horario de la materia que deseas cursar y luego en el botón Confirmar inscripción. Una vez confirmado, en caso de querer modificar la inscripción podrás generar una nueva inscripción si así lo deseas.</p>

		<div class="table-responsive">
		    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
		    	<div class="row"><div class="col-sm-12"><table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
		      <thead>
		        <tr role="row">
		        	<th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 350px;">Materia</th>
		        	<th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" >Día y horario</th>
		        </tr>
		      </thead>
		      <tbody>
		      	@foreach($array_oferta as $key=>$val)
			      	@if($array_oferta[$key]["abreinscripcion"] == 2)
			      	@foreach($array_oferta[$key]["materia"] as $idmateria=>$aMateria)
			      	<tr role="row">
			          <td>{{$aMateria["descmateria"]}}</td>
			          <td>
			          	<select name="lstOferta[]" class="form-control">
			          		<option selected value="0">Seleccionar</option>
			          		@foreach($aMateria["cursada"] as $idcursada => $dia)
				          		@php ($inscripto = false);
			          			@foreach($array_oferta_yainscripta as $inscripcion)
			          				@if($inscripcion->idcursada == $idcursada)
			          					@php ($inscripto = true);
	          						@endif
			          			@endforeach
	      						@if($inscripto == true)
	      							@if($aMateria["cursada"][$idcursada]["sinvacante"] == "true")
		          						<option style="color:red;" selected value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
	          						@else
	          							<option selected value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
	          						@endif
	          					@else
	          						@if($aMateria["cursada"][$idcursada]["sinvacante"] == "true")
	          							<option style="color:red;" value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
	      							@else
	      								<option value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
	  								@endif
	      						@endif
			          		@endforeach
			          	</select>
			          </td>
			        </tr>
			        @endforeach
			        @endif
			        @if($array_oferta[$key]["abreinscripcion"] == 1)
			      	<tr role="row">
			          <td>{{$array_oferta[$key]["grupo"]}}</td>
			          <td>
			          	<select name="lstOferta[]" class="form-control">
			          		<option selected value="0">Seleccionar</option>
			          		@foreach($array_oferta[$key]["materia"] as $idmateria=>$aMateria)
				          		@foreach($aMateria["cursada"] as $idcursada => $dia)
					          		@php ($inscripto = false);
				          			@foreach($array_oferta_yainscripta as $inscripcion)
				          				@if($inscripcion->idcursada == $idcursada)
				          					@php ($inscripto = true);
		          						@endif
				          			@endforeach
		      						@if($inscripto == true)
		      							@if($aMateria["cursada"][$idcursada]["sinvacante"] == "true")
			          						<option style="color:red;" selected value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
		          						@else
		          							<option selected value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
		          						@endif
		          					@else
		          						@if($aMateria["cursada"][$idcursada]["sinvacante"] == "true")
		          							<option style="color:red;" value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
		      							@else
		      								<option value="{{ $idcursada }}">{{$aMateria["cursada"][$idcursada]["dia"]}}</option>
		  								@endif
		      						@endif
				          		@endforeach
			          		@endforeach
			          	</select>
			          </td>
			        </tr>
			        @endif
		      	@endforeach
		       </tbody>
		    </table></div></div></div>
		</div>
		<br>
		<div class="offset-md-9 col-md-3">
			<input type="submit" class="btn btn-google btn-block" value="Confirmar inscripción"/>
		</div>
		@else
			<p>No hay materias pendientes de inscripción</p>
		@endif
	    </div>
	  </div>
	</div>
</div>
@endif
</form>
@endsection