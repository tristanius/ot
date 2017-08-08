<div class="row">

  <h5>Procesos relación y asociación de C.C.</h5>
  <div class="col l2" ng-show="validPriv(66)">
    <a href="#" class="btn-panel" style="width:100%" ng-click="clickeableLink('<?= site_url('persona/view_cargue_horas') ?>', $event, 'Personal asociado');">
      <h3 class="center-align" data-icon="V"></h3>
      <p class="center-align">Carge asociación nomina/JobsL</p>
    </a>
  </div>

  <div class="col l2" ng-show="validPriv(66)">
    <a href="#" class="btn-panel" style="width:100%" ng-click="clickeableLink('<?= site_url('MigracionReporte/formRecursosReporte') ?>', $event, 'Personal asociado');">
      <h3 class="center-align" data-icon="V"></h3>
      <p class="center-align">Movimientos de recusos reportados a C.C.</p>
    </a>
  </div>

</div>
