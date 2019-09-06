@extends('autogestion.plantilla')
@section('titulo', $titulo)
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{env('APP_URL_AUTOGESTION')}}/home">Inicio</a></li>
    <li class="breadcrumb-item">Inscripción</li>
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
<div class="row">
	<div class="col-md-12">
		<a class="btn btn-secondary py-5" href="{{env('APP_URL_AUTOGESTION')}}/cd-consideraciones/">Programador Web Fullstack</a>
		<a class="btn btn-secondary py-5" href="{{env('APP_URL_AUTOGESTION')}}/cd-consideraciones/">Marketing Digital</a>
		<a class="btn btn-secondary py-5" href="{{env('APP_URL_AUTOGESTION')}}/cd-consideraciones/">Programador Wordpress</a>
	</div>
</div>
@endsection