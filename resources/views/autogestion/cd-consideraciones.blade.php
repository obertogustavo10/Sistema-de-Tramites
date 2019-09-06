@extends('autogestion.plantilla')
@section('titulo', "Carrera docente")
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{env('APP_URL_AUTOGESTION')}}/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{env('APP_URL_AUTOGESTION')}}/inscripcion">Inscripción</a></li>
    <li class="breadcrumb-item active">Consideraciones</li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
@if(!$plan_cd_activo)
<div class="row">
	<div class="col-md-12">
		<div class="shadow alert alert-danger" role="alert">
			<h4 class="alert-heading">Atención</h4>
		  <hr>
		  	<p>No es alumno activo de Carrera Docente.</p>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-md-12">
		<div class="shadow alert alert-success" role="alert">
		  <h4 class="alert-heading">Consideraciones previas (leer atentamente)</h4>
		  <hr>
			<p>La inscripción por Internet no garantiza su asignación definitiva, considere que la misma es una declaración jurada que debe cotejarse con su situación académica (correlatividades) obrante en esta Facultad.</p>

			<p>Una vez finalizada la inscripción PODRÁ MODIFICARSE LOS DATOS INGRESADOS. La inscripción válida siempre será la última gererada, las anteriores quedan anuladas.</p>

			<p>Recuerde que la inscripción le genera una deuda que se deberá abonar en cualquier condición (Aprobado, Reprobado o Ausente) excepto que el alumno solicite la baja de la materia antes de la tercera clase.</p>

			<p>Si al momento de finalizar la inscripción no pudo imprimir la CONSTANCIA DE INSCRIPCIÓN, vuelva a ingresar al sistema. El sistema le permitirá imprimir su constancia.</p>

			<p>El sistema admitirá solamente UNA INSCRIPCIÓN POR ASPIRANTE.</p>

			<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onclick="location.href='{{env('APP_URL_AUTOGESTION')}}/cd-inscripcion'">Comenzar inscripción</button>
		</div>
	</div>
</div>
@endif
@endsection