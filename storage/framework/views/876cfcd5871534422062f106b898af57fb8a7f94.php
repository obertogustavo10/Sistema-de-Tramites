
<?php $__env->startSection('titulo', "$titulo"); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="card shadow mb-4">
  <div class="card-body pt-4" style="font-size: 0.9em;">
  <form id="form1" method="POST">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
    <div class="row">
        <div class="form-group col-lg-6">
            <label>Nombre:</label>
            <input type="text" class="form-control" value="<?php echo e(Session::get('usuarioalu_nombre')); ?>" disabled>
        </div>
        <div class="form-group col-lg-6">
            <label>Documento:</label>
            <input type="text" class="form-control" value="<?php echo e(Session::get('usuarioalu')); ?>" disabled>
        </div>
        <div class="form-group col-lg-12">
            <label>Asunto:</label>
        </div>
        <div class="form-group col-lg-12">
            <select id="lstAsunto" name="lstAsunto" class="form-control" required>
              <option disabled selected>Seleccionar</option>
              <option value="Programación Web Full Stack">Programación Web Full Stack</option>
              <option value="Programación Wordpres">Programación Wordpres</option>
              <option value="Marketing Digital">Marketing Digital</option>
            </select>
        </div>
        <div class="form-group col-lg-12">
            <label>Mensaje:</label>
        </div>
        <div class="form-group col-lg-12">
          <textarea id="txtMensaje" name="txtMensaje" class="form-control" style="height: 100px !important;" maxlength="1000" required></textarea>
        </div> 
        <div class="form-group col-md-2 offset-md-10">
          <input type="submit" id="btnEnviar" name="btnEnviar" value="Enviar mensaje" class="btn btn-success">
        </div>
      </div>
  </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('autogestion.plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>