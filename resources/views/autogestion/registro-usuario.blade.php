<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>{{ $titulo }} -  {{ env('APP_NAME') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
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
  <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Nuevo registro</h1>
                  </div>
                     	<?php
	          if (isset($msg)) {
	              echo '<div id = "msg"></div>';
	              echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
	          }
	        ?>
                   <form name="fr" class="form-signin" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
       		<div class="form-group">
				<div class="form-row">
				    <div class="col-md-6">
				      <div class="form-label-group">
				        <input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Nombre" required="required" autofocus="autofocus" />
				      </div>
				    </div>
				    <div class="col-md-6">
				      <div class="form-label-group">
				        <input type="text" id="txtApellido" name="txtApellido" class="form-control" placeholder="Apellido" required="required" />
				      </div>
				    </div>
			  </div>
			</div>
			<div class="form-group">
			  <div class="form-row">
			    <div class="col-md-6">
			      <div class="form-label-group">
			         <select id="lstTipoDoc" name="lstTipoDoc" class="form-control" required placeholder="Tipo de documento">
		                <option value="" disabled selected>Seleccionar</option>
		                @for ($i = 0; $i < count($array_tipodocumento); $i++)
	                        <option value="{{ $array_tipodocumento[$i]->idtidoc }}">{{ $array_tipodocumento[$i]->desctidoc }}</option>
		                @endfor
		            </select>
			      </div>
			    </div>
			    <div class="col-md-6">
			      <div class="form-label-group">
			        <input type="text" id="txtDNI" name="txtDNI" class="form-control" placeholder="Documento" required="required" />
			      </div>
			    </div>
			  </div>
			</div>
			<div class="form-group">
			  <div class="form-row">
			    <div class="col-md-12">
			      <div class="form-label-group">
			        <input type="text" id="txtCelular" name="txtCelular" class="form-control" placeholder="Celular" required="required">
			      </div>
			    </div>
			  </div>
			</div>
			<div class="form-group">
			  <div class="form-label-group">
			    <input type="email" id="txtEmail" name="txtEmail" class="form-control" placeholder="Correo electrónico" required="required">
			  </div>
			</div>
			<div class="form-group">
			  <div class="form-row">
			    <div class="col-md-6">
			      <div class="form-label-group">
			        <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Clave" required="required" minlength="5">
			      </div>
			    </div>
			    <div class="col-md-6">
			      <div class="form-label-group">
			        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirmar clave" required="required" minlength="5">
			      </div>
			    </div>
			  </div>
			</div>
			<button class="btn btn-primary btn-block" type="submit">Registrarse</button>
          </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{env('APP_URL_AUTOGESTION')}}/">Volver al login</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{env('APP_URL_AUTOGESTION')}}/recupero-clave">Recuperar clave</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</body>
</html>