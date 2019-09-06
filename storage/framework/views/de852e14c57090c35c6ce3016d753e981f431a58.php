<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>">
    <title><?php echo e($titulo); ?> -  <?php echo e(env('APP_NAME')); ?></title>
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/funciones_generales.js')); ?>"></script>
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
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Ingreso al sistema</h1>
                  </div>
                   <form name="fr" class="form-signin" method="POST" action="/">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="txtUsuario" name="txtUsuario" aria-describedby="emailHelp" placeholder="Nro documento">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtClave" name="txtClave" placeholder="Clave">
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit">Ingresar</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/nuevo-registro">Nuevo registro</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/recupero-clave">Recuperar clave</a>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 d-none d-lg-block pt-4">
                
                <div class="alert alert-success mb-4" role="alert">
                  <h4 class="alert-heading">Sistema de autogestión</h4>
                  <br>
                  <p>Este es el sistema de autogesión de alumnos de DePC Suite.</p>
                  <hr>
                  <p class="mb-0">Si es la primera vez que ingresas al sistema debes registrarte como nuevo usuario, desde la opción "Nuevo registro".</p>
                  <hr>
                  <p class="mb-0">Si tenes inconvenientes para acceder al sistema podes contactarnos haciendo <a href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/contacto">click aquí</a></p>
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