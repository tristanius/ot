<div id="ot-recursos" class="nodisplay">

  <h5> Orden de trabajo : <span ng-bind="consulta.nombre_ot"></span>  </h5>
  <button type="button" ng-click="clickeableLink('<?=  site_url('ot/resumenOT') ?>/'+consulta.idOT, $event, 'Resumen OT '+consulta.nombre_ot);">Ver resumen de cant. de la Orden</button>

  <hr>

  <h5 color="gray-text darken-3">Recursos de la orden de trabajo</h5>
  <div id="tabsRecursosOT" ng-init="initTabs('#tabsRecursosOT')">
    <ul>
      <li><a href="#tabs-1">Personal</a></li>
      <li><a href="#tabs-2">Equipos</a></li>
      <!--<li><a href="#tabs-3">Material</a></li>-->
      <li><a href="#tabs-4">Otros</a></li>
    </ul>
    <div id="tabs-1">
      <?php $this->load->view('recursos/vista_recursos/personal'); ?>
    </div>
    <div id="tabs-2">
      <?php $this->load->view('recursos/vista_recursos/equipos'); ?>
    </div>
    <!--
    <div id="tabs-3">
      <?php $this->load->view('recursos/vista_recursos/material'); ?>
    </div>  -->
    <div id="tabs-4">
      <?php $this->load->view('recursos/vista_recursos/otros'); ?>
    </div>
  </div>

  <?php $this->load->view('recursos/vista_recursos/form_unidad_negocio'); ?>
</div>

<script type="text/javascript">

$(document).ready(function(){
  // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
  $('.modal').modal();
});

</script>
