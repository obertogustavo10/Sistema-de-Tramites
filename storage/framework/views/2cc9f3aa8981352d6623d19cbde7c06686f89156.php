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
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Formulario de contacto</h1>
                  </div>
                     	<?php
	          if (isset($msg)) {
	              echo '<div id = "msg"></div>';
	              echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
	          }
	        ?>
                   <form name="form1" class="form-signin" method="POST">
    
		
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
    <div class="row">
        <div class="form-group col-lg-6">
            <label>Nombre:</label>
            <input type="text" name="txtNombre" class="form-control" required>
        </div>
        <div class="form-group col-lg-6">
            <label>Apellido:</label>
            <input type="text" name="txtApellido" class="form-control" required>
        </div>
        <div class="form-group col-lg-6">
            <label>Tipo de documento:</label>
            <select id="lstTipoDoc" name="lstTipoDoc" class="form-control" required placeholder="Tipo de documento">
                <option value="" disabled selected>Seleccionar</option>
                <?php for($i = 0; $i < count($array_tipodocumento); $i++): ?>
                      <option value="<?php echo e($array_tipodocumento[$i]->idtidoc); ?>"><?php echo e($array_tipodocumento[$i]->desctidoc); ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label>Documento:</label>
            <input type="text" name="txtDocumento"class="form-control" required>
        </div>
        <div class="form-group col-lg-12">
            <label>Correo electrónico:</label>
            <input type="mail" name="txtCorreo" class="form-control" required>
        </div>
        <div class="form-group col-lg-12">
            <label>Mensaje:</label>
        </div>
        <div class="form-group col-lg-12">
          <textarea id="txtMensaje" name="txtMensaje" class="form-control" style="height: 100px !important;" maxlength="500" required></textarea>
        </div> 
      </div>
 		<button class="btn btn-primary btn-block" type="submit">Enviar mensaje</button>
          </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?php echo e(env('APP_URL_AUTOGESTION')); ?>/">Volver al login</a>
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