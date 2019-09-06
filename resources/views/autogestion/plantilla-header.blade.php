<!DOCTYPE html>
<html lang="es">
<head>
    <title>Sistema de autogestión de alumnos de posgrado - Facultad de Medicina UBA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $titulo }} -  {{ env('APP_NAME') }}</title>
  <link rel="icon" href="{{ asset('images/favicon.png') }}">
  <link href="{{ asset('css/normalize.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/autogestion.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('js/sb-admin.min.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.js') }}"></script>
  <script src="{{ asset('js/localization/messages_es.js') }}"></script>
  <script src="{{ asset('js/funciones_generales.js') }}"></script>
  @yield('scripts')
  </head>
  <body>
<div class="d-flex flex-column flex-md-row align-items-center p-2 px-md-4 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">UBA Posgrado</h5>
    <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="https://getbootstrap.com/docs/4.2/examples/pricing/#">Oferta académica</a>
    <a class="p-2 text-white" href="{{env('APP_URL_AUTOGESTION')}}/contactos">Contactos</a>
  </nav>
  <div class="dropdown">
  <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ Session::get("usuario_nombre") }}
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Cambiar clave</a>
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalSalir">Cerrar sesión</a>
  </div>
</div>
</div>
<div class="modal fade" id="modalSalir" tabindex="-1" role="dialog" aria-labelledby="modalSalirLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalSalirLabel">Salir del sistema?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Seleccciona "Cerrar sesi&oacute;n" si deseas terminar la sesi&oacute;n actual.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="/logout">Cerrar sesi&oacute;n</a>
          </div>
        </div>
      </div>
    </div>
<div class="container">