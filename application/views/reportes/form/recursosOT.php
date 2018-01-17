<section style="padding:1ex">

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
  </div>
  <h5>Listados de recursos, cantidades y tiempos: </h5>

  <div ng-if="rd.info.estado == 'ABIERTO'">
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#personalOT')" data-icon="&#xe047;" > Personal</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#equipoOT')" data-icon="&#xe042;"> Equipos</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#actividadOT')" data-icon="k"> Actividades</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#materiales')" data-icon="k"> Material</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#otros')" data-icon="k"> Otros</button>
  </div>
  <div class="">
    <h5>Personal:</h5>
    <?php $this->load->view('reportes/form/rec/personalReporte', array('ot'=>$ot, 'estados_labor'=>$estados_labor) ); ?>
    <hr>

    <h5>Equipo:</h5>
    <?php $this->load->view('reportes/form/rec/equipoReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Actividad:</h5>
    <?php $this->load->view('reportes/form/rec/actividadesReporte', array('ot'=>$ot) ); ?>
  </div>
</section>
