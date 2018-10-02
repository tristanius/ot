<?php
if (isset($frentes) && sizeof($frentes) > 0 ) {
?>
<div class="noMaterialStyles regularForm card-panel padding1ex" ng-init='initRecursosFilters(); initFrentes(<?= json_encode($frentes) ?>)'>
  <b>SELECCIONA FRENTE:</b>

  <?php foreach ($frentes as $key => $f): ?>
      <?php $f->usuario = json_decode($f->usuario); ?>
      <button class="btn mini-btn  {{myfrente == <?= $f->idfrente_ot ?> ?'teal darken-4':'light-blue darken-3';}}"
        ng-click="myfrente = <?= $f->idfrente_ot ?>; changeFrente(myfrente, rd, '#showRecursos')"
        <?php if ( isset($f->usuario) ): ?>
        ng-disabled="(log.idusuario != <?= $f->usuario->idusuario ?> && (!validPriv(45) && !validPriv(46)) )"
        <?php endif; ?>
        > <?= ($key+1).". ".$f->nombre ?>
      </button>
  <?php endforeach; ?>

</div>
<?php $this->load->view('reportes/form/frentes/duplicar', array() );  ?>

<?php
}
?>
<section style="padding:1ex" class="card-panel"  ng-init="initItemsPlaneados('<?= site_url('ot/items_planeados/'.$ot->idOT) ?>')">

  <?php if (isset($frentes) && sizeof($frentes) > 0 ): ?>
    <h5 style="color:#14931d" >Frente de trabajo: {{ getFrente(myfrente) }} </h5>
  <?php endif ?>

  <style media="screen">
    tr.newrow{
      background: #E0FFFB;
    }
    tr.newrow:hover{
      background: #E0E7FF;
    }
  </style>

  <div class="ventanasAdd font12" ng-init="getRecursosByOT('<?= site_url('reporte/getRecursosByOT/'.$ot->idOT) ?>')">
    <?php $this->load->view('reportes/form/finders/personaOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/finders/equipoOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/finders/actividadesOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/finders/materialesOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/finders/subcontratosOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/finders/otrosOT', array('ot'=>$ot) ); ?>
  </div>

  <div ng-if="rd.info.estado == 'ABIERTO' <?= (isset($frentes) && sizeof($frentes) > 0 )?'&& myfrente':''; ?>">
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#personalOT')" data-icon="&#xe047;" > Personal</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#equipoOT')" data-icon="&#xe042;"> Equipos</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#actividadOT')" data-icon="k"> Actividades</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#materialOT')" data-icon="5"> Material</button>
    <button type="button" class="btn orange lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#subcontratosOT')" data-icon="&"> Sub-Contratos</button>
    <button type="button" class="btn orange lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#otrosOT')" data-icon="&"> Otros</button>
  </div>

  <div id="showRecursos" <?= (isset($frentes) && sizeof($frentes) > 0 )?'ng-if="myfrente"':''; ?>>
    <h5 class="center-align">Listados de recursos, cantidades y tiempos: </h5>

    <h5>Personal:</h5>
    <?php $this->load->view('reportes/form/rec/personalReporte', array('ot'=>$ot, 'estados_labor'=>$estados_labor) ); ?>
    <hr>

    <h5>Equipo:</h5>
    <?php $this->load->view('reportes/form/rec/equipoReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Actividad:</h5>
    <?php $this->load->view('reportes/form/rec/actividadesReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Material:</h5>
    <?php $this->load->view('reportes/form/rec/materialReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Subcontratos:</h5>
    <?php $this->load->view('reportes/form/rec/subcontratosReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Otros:</h5>
    <?php $this->load->view('reportes/form/rec/otrosReporte', array('ot'=>$ot) ); ?>


    <?php $this->load->view('reportes/form/asociar_item'); ?>
  </div>

</section>
