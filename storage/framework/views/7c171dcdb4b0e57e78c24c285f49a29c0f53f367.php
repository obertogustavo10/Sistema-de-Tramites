<?php $__env->startSection('titulo', ""); ?>

<?php $__env->startSection('scripts'); ?>
<!-- <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script> -->

<link href="<?php echo e(asset('fullcalendar/core/main.css')); ?>" rel='stylesheet' />
<link href="<?php echo e(asset('fullcalendar/daygrid/main.css')); ?>" rel='stylesheet' />
<link href="<?php echo e(asset('fullcalendar/timegrid/main.css')); ?>" rel='stylesheet' />
<link href="<?php echo e(asset('fullcalendar/list/main.css')); ?>" rel='stylesheet' />

    <script src="<?php echo e(asset('fullcalendar/core/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/daygrid/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/timegrid/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/list/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/interaction/main.js')); ?>"></script>

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>

<!-- Modal para el Calendario-->
                <div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
                </div>

<div class="container">
    <div class="row">
        <div id="calendar" class="calendar">
        </div>
    </div>
</div>

<script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid', 'interaction', 'timeGrid', 'list' ],
          
          header:{
              left:'prev,next today, BtnEvento',
              center:'title',
              right:'dayGridMonth, timeGridWeek, timeGridDay'

          },

          customButtons:{

              BtnEvento:{
                  text:"Nuevo Evento",
                  click:function(){
                      $("#eventoModal").modal('toggle');
                  }
              }

          },

          dateClick:function(info) {
              $("#eventoModal").modal('toggle');
          },

          events:{
            url: 'app/Http/Controllers/ControladorCalendario.php',
            method: 'POST'
          }
        });

        calendar.getOption('locale','Es');

        calendar.render();
      });

    </script>
<script type="text/javascript">  
        $('#startdate').datepicker({ 
            autoclose: true,   
            format: 'yyyy-mm-dd'  
         });
         $('#enddate').datepicker({ 
            autoclose: true,   
            format: 'yyyy-mm-dd'
         }); 
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>