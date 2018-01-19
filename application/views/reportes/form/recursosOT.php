<?php
if (isset($frentes) && sizeof($frentes) > 0 ) {
?>
<div class="noMaterialStyles regularForm card-panel padding1ex" ng-init='initRecursosFilters(); initFrentes(<?= json_encode($frentes) ?>)'>
  <b>SELECCIONA TU FRENTE DE TRABAJO:</b>
  <select style="border:1px solid red;" ng-model="myfrente" ng-change="changeFrente(myfrente)" style="font-weight: bold;">
    <?php foreach ($frentes as $key => $f): ?>
      <?php $f->usuario = json_decode($f->usuario); ?>
      <option value="<?= $f->idfrente_ot ?>" ng-disabled="(log.idusuario != <?= $f->usuario->idusuario ?> && !validPriv(45))">
        <?= $f->nombre.' - '.$f->ubicacion ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>
<div ng-init='initItemsPlaneados(<?= json_encode($items_planeados); ?>)'></div>
<?php
}
?>
<section style="padding:1ex" class="card-panel" >

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
    <?php $this->load->view('reportes/form/rec/personaOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/rec/equipoOT', array('ot'=>$ot, 'un_equipos'=>$un_equipos, 'item_equipos'=>$item_equipos) ); ?>
    <?php $this->load->view('reportes/form/rec/actividadesOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/rec/materialesOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/rec/otrosOT', array('ot'=>$ot) ); ?>
  </div>

  <div ng-if="rd.info.estado == 'ABIERTO' <?= (isset($frentes) && sizeof($frentes) > 0 )?'&& myfrente':''; ?>">
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#personalOT')" data-icon="&#xe047;" > Personal</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#equipoOT')" data-icon="&#xe042;"> Equipos</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#actividadOT')" data-icon="k"> Actividades</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#materiales')" data-icon="5"> Material</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#otros')" data-icon="&"> Otros</button>
  </div>
  <div ng-if="<?= (isset($frentes) && sizeof($frentes) > 0 )?'myfrente':''; ?>">
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


    <?php $this->load->view('reportes/form/asociar_item'); ?>
  </div>
</section>
