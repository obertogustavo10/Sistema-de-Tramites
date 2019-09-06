
<?php $__env->startSection('titulo', "Datos del usuario"); ?>
<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('css/datatables.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
<script>
    globalId = '<?php echo isset($usuario->idusuario) && $usuario->idusuario > 0 ? $usuario->idusuario : 0; ?>';
    <?php $globalId = isset($usuario->idusuario) ? $usuario->idusuario : "0"; ?>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/usuarios/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/usuarios";
}
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="row">
    <div id = "msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
</div>
<form id="form1" method="POST" }}">
    <div class="row">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo e($globalId); ?>" required>
        <div class="form-group col-lg-2">
            <label>Usuario: *</label>
        </div>
       <div class="form-group col-lg-4">
            <input type="text" id="txtUsuario" name="txtUsuario" class="form-control" value="<?php echo e(isset($usuario->usuario) ? $usuario->usuario : ''); ?>" required>
            <input type="hidden" id="txtLegajo" name="txtLegajo" value="<?php echo e(isset($usuario->fk_legajo_id) ? $usuario->fk_legajo_id : ''); ?>" required>
        </div>
        <div class="form-group col-lg-2">
            <label>Nombre:</label>
       </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="<?php echo e(isset($usuario->nombre) ? $usuario->nombre : ''); ?>">
        </div>
        <div class="form-group col-lg-2">
            <label>Apellido:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="<?php echo e(isset($usuario->apellido) ? $usuario->apellido : ''); ?>">
        </div>
        <div class="form-group col-lg-2">
            <label>Email: *</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="email" id="txtEmail" name="txtEmail" class="form-control" required value="<?php echo e(isset($usuario->mail) ? $usuario->mail : ''); ?>">
        </div>
        <div class="form-group col-lg-2">
            <label>Intentos de bloqueo:</label>
        </div>
        <div class="form-group col-lg-4">
            <input value="0" type="number" id="txtBloqueo" name="txtBloqueo" class="form-control" value="<?php echo e(isset($usuario->cantidad_bloqueo) ? $usuario->cantidad_bloqueo : ''); ?>">
        </div>
        <div class="form-group col-lg-2">
            <label>Activo: *</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstEstado" name="lstEstado" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                <option value="1" <?php echo e(isset($usuario) && $usuario->activo == 1? 'selected' : ''); ?>>Si</option>
                <option value="0" <?php echo e(isset($usuario) && $usuario->activo == 0? 'selected' : ''); ?>>No</option>
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label>Área predeterminada: *</label>
        </div>
        <div class="form-group col-lg-4">
            <select id="lstArea" name="lstArea" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                <?php for($i = 0; $i < count($array_area); $i++): ?>
                    <?php if(isset($usuario) and $array_area[$i]->idarea == $usuario->areapredeterminada): ?>
                        <option selected value="<?php echo e($array_area[$i]->idarea); ?>"><?php echo e($array_area[$i]->ncarea); ?></option>
                    <?php else: ?>

                        <option value="<?php echo e($array_area[$i]->idarea); ?>"><?php echo e($array_area[$i]->ncarea); ?></option>
                    <?php endif; ?>
                <?php endfor; ?>

            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Permisos asignados
                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirAgregarPatentes()"></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="grilla" class="display">
                        <thead>
                            <tr>
                                <th>familia_id</th>
                                <th>Permiso</th>
                                <?php $__currentLoopData = $array_grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($grupo->ncarea); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Permisos del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <table id="grillaPermisos" class="display">
                        <thead>
                            <tr>
                                <th>familia_id</th>
                                <th></th>
                                <th>Nombre</th>
                                <th>Descripci&oacute;n</th>
                            </tr>
                        </thead>
                    </table> 
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarPatentesGrilla();">Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarGrupos" tabindex="-1" role="dialog" aria-labelledby="modalAgregarGruposLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Grupos del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <table id="grillaTodosLosGrupos" class="display">
                        <thead>
                            <tr>
                                <th>grupo_id</th>
                                <th></th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                    </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarGruposGrilla();">Agregar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#form1").validate();
    cargarGrillaPermisos();
    cargarGrilla();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function cargarGrilla() {
           var grilla = $('#grilla').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "paging": false,
            "ajax": "<?php echo e(asset('usuarios/cargarGrillaFamiliasDelUsuario?us='.$globalId)); ?>",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                 {
                    "targets": [1],
                    "visible": true,
                    "searchable": true,
                    "width": 200
                }
                <?php ($pos = 2); ?>
                <?php $__currentLoopData = $array_grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                ,
                {
                    "targets": [<?php (print_r($pos)); ?>],
                    "visible": true,
                    "searchable": true,
                    "width": 30,
                    "className": "dt-head-center"
                }
                <?php ($pos++); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]
        });
    }
    function cargarGrillaPermisos() {
        var grilla = $('#grillaPermisos').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": true,
            "bInfo": true,
            "bSearchable": true,
            "pageLength": 10,
            "ajax": "<?php echo e(asset('usuarios/cargarGrillaFamiliaDisponibles?fam='.$globalId)); ?>",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ]
        });
    }

    function abrirAgregarPatentes() {
        $('#modalAgregar').modal('toggle');
    }
 
    function agregarPatentesGrilla() {
        var grilla = $('#grilla').DataTable();
        var grillaPermisos = $('#grillaPermisos').DataTable();
        var pos = 0;

        $('#grillaPermisos input[type=checkbox]').each(function () {
            if (this.checked) {
                id = grillaPermisos.row(pos).data()[0];

                if ($("[name*='chk_Familia_" + id + "']").length == 0) {
                    //Si no esta lo agrega
                    grilla.row.add([
                        id,
                        grillaPermisos.row(pos).data()[2]
                        <?php ($pos = 2); ?>

                        <?php $__currentLoopData = $array_grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            ,
                            "<input id='chk_Familia_" + id + "_<?php echo e($grupo->idarea); ?>' name='chk_Familia_" +  id + "_<?php echo e($grupo->idarea); ?>' type='checkbox' class='form-control' />"
                            <?php ($pos++); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    ]).draw();
                }
            }
            pos++;
        });
        $('#modalAgregar').modal('toggle');
    }
 
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>