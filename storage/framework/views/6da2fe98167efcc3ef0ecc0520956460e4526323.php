<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>">

    <title>Recupero de clave - <?php echo e(env('APP_NAME')); ?></title>

    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet" type="text/css">
  </head>
<body class="bg-gradient-primary">
      <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Recuperar clave</div>
        <div class="card-body">
          <div class="text-center mb-4">
            <h4>¿Olvidaste la clave?</h4>
            <p>Ingresa la dirección de correo con la que te registraste y te enviaremos las instrucciones para cambiar la clave.</p>
          </div>
          <form name="fr" class="form-signin" method="POST">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
            <?php if(isset($mensaje)): ?>
              <div class="alert alert-secondary text-center" role="alert">
                <?php echo e($mensaje); ?>

              </div>
            <?php else: ?>
            <div class="form-group">
              <div class="form-label-group">
                  <input type="email" id="txtMail" name="txtMail" class="form-control" placeholder="Dirección de correo" required="required" autofocus="autofocus">
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Recuperar</button>
            <?php endif; ?>
          </form>
          <hr>
                  <div class="text-center">
                    <a class="small" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/">Volver al login</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/recupero-clave">Recuperar clave</a>
                  </div>
        </div>
      </div>
    </div>
  </body>
</html>