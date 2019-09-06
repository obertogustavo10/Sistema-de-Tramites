<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>Recupero de clave - {{ env('APP_NAME') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/funciones_generales.js') }}"></script>
  </head>
<body class="bg-gradient-primary">
      <div class="container">
          <?php
  if (isset($msg)) {
      echo '<div id = "msg"></div>';
      echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
  }
  ?>
      <div class="card card-login mx-auto mt-5 col-md-6">
        <div class="card-header">{{$titulo}}</div>
        <div class="card-body">
          <div class="text-center mb-4">
            <h4>Ingresa la nueva clave</h4>
          </div>
          <form name="form" class="form-signin" method="POST">
            <input type="hidden" name="_mail" value="{{ $mail }}"></input>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" name="_tokenmail" value="{{ $token }}"></input>
            @if(isset($mensaje))
              <div class="alert alert-secondary text-center" role="alert">
                {{ $mensaje }}
              </div>
            @else
         
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group form-group">
                    <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Nueva clave" data-rule-email="true" minlength="5">
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group form-group">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Repetir nueva clave" required data-rule-email="true" data-rule-equalTo="#txtClave" minlength="5">
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <button class="btn btn-primary btn-block" type="submit">Cambiar</button>
                </div>
              </div>
            
            @endif
          </form>
          <hr>
          <div class="text-center">
            <a class="small" href="{{env('APP_URL_AUTOGESTION')}}/">Volver al login</a>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
     $(this).find('#form').validate({
            rules : {
                password : {
                    minlength : 5
                },
                password_confirm : {
                    minlength : 5,
                    equalTo : "#txtClave"
                }
            }
  </script>
</html>