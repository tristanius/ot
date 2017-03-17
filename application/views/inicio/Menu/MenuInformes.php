<div class="row">
  <h3>Gestión de Ordenes de trabajo</h3>

  <div class="col l2" ng-show="validPriv(51)">
    <a ng-click="clickeableLink('<?= site_url('export/form_informeProduccion') ?>', $event, 'Inf. de Produccion');" target="_blank" class="btn-panel teal darken-3 white-text"
        style="width:100%; cursor:pointer">
      <h3 class="center-align" data-icon="&#xe010;"></h3>
      <p class="center-align">Informe de produccion (fact.)</p>
    </a>
  </div>


  <div class="col l2">
    <a href="<?= site_url('export/informeCargues') ?>" target="_blank" class="btn-panel cyan darken-2 white-text" style="width:100%">
      <h3 class="center-align" data-icon="U"></h3>
      <p class="center-align">Personal/equipo cargados X Orden</p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(47)">
    <a href="#" ng-click="clickeableLink('<?= site_url('consulta/form_reporte_pyco') ?>', $event, 'Inf. de equipos');" class="btn-panel blue darken-4 white-text" style="width:100%">
      <h3 class="center-align" data-icon="&#xe042;"></h3>
      <p class="center-align">Consulta de informes equipos mensual</p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(510000000000000000000)">
    <a href="#" ng-click="clickeableLink('', $event, 'Gestion de OTs');" class="btn-panel red white-text" style="width:100%">
      <h3 class="center-align" data-icon="x"></h3>
      <p class="center-align">Consulta periodos y otros conceptos</p>
    </a>
  </div>

</div>
