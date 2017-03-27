<div class="row">
  <h3>Gestión de Ordenes de trabajo</h3>

  <div class="col l2" ng-show="validPriv(51)">
    <a ng-click="clickeableLink('<?= site_url('export/form_informeProduccion') ?>', $event, 'Inf. de Produccion');" target="_blank" class="btn-panel teal darken-3 white-text"
        style="width:100%; cursor:pointer">
      <h3 class="center-align" data-icon="&#xe010;"></h3>
      <p class="center-align">Informe de produccion (fact.)</p>
    </a>
  </div>

  <div class="col l2" ng-show"validPriv(52)">
    <a href="<?= site_url('export/informePYCO') ?>" class="btn-panel  orange darken-3 white-text" style="width:100%">
      <h3 class="center-align" data-icon="x"></h3>
      <p class="center-align">Informe General sabana de PyCO</p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(510000000000000000000)">
    <a href="<?= site_url('export/informeCargues') ?>" target="_blank" class="btn-panel cyan darken-2 white-text" style="width:100%">
      <h3 class="center-align" data-icon="U"></h3>
      <p class="center-align">Personal/equipo cargados X Orden</p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(61)">
    <a href="#" ng-click="clickeableLink('<?= site_url('consulta/form_reporte_pyco') ?>', $event, 'Inf. de equipos');" class="btn-panel blue darken-4 white-text" style="width:100%">
      <h3 class="center-align" data-icon="&#xe042;"></h3>
      <p class="center-align">Consulta de informes equipos mensual</p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(62)">
    <a href="#" ng-click="clickeableLink('<?= site_url('reportepersonal/form_tiempoLaboradoGeneral') ?>', $event, 'Tiempo Laborado');" class="btn-panel yellow darken-1 black-text" style="width:100%">
      <h3 class="center-align" data-icon="3"></h3>
      <p class="center-align"> Informe de tiempo Laborado </p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(62)">
    <a href="#" ng-click="clickeableLink('<?= site_url('reportepersonal/form_reporteMes') ?>', $event, 'Tiempo Laborado');" class="btn-panel yellow darken-1 black-text" style="width:100%">
      <h3 class="center-align" data-icon="3"></h3>
      <p class="center-align"> Informe de dias laborados por mes </p>
    </a>
  </div>

</div>
