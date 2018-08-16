<section id="duplicar" class="nodisplay" style="background: rgba(42, 40, 51, 0.6); width:100%; height:100%; position: absolute; z-index: 6;padding:2em">
  <div class="noMaterialStyles row" style="position:relative; padding:2em; background:#FFF">
    <b class="col s4 m3 l3">Fecha a duplicar: (AÑO-MES-DIA)</b>
    <input type="text" class="datepicker limitdate noMaterialStyles col s4 m3 l3" ng-model="fecha_duplicar" ng-init=""  >
    <button type="button" class="btn mini-btn" ng-click="duplicar('<?= site_url('reporte/addvalid') ?>', $event)">Duplicar reporte</button>
    <button type="button" class="btn mini-btn red" ng-click="formDuplicar()">Cerrar</button>
  </div>
</section>

<script type="text/javascript">
  $( '.datepicker.limitdate' ).datepicker(
    {
      minDate:'-30D',
      maxDate: '+20D',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    }
  )
</script>
