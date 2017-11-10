<div class="row">

  <h4>Gestión de facturación web (Version 1.1)</h4>

  <div class="col l2" ng-if="validPriv(55)">
    <a ng-click="clickeableLink('<?= site_url('factura/gestion') ?>', $event, 'Gestionar facturas');" target="_blank" class="btn-panel"
        style="width:100%; cursor:pointer">
      <h3 class="center-align" data-icon="&#xe03e;"></h3>
      <p class="center-align"> Gestión de facturas</p>
    </a>
  </div>



  <div class="col l2" ng-if="validPriv(73)">
    <a href="#" ng-click="clickeableLink('<?= site_url('historicoFacturacion/cargue_historico/') ?>', $event, 'Cargue de historico');" class="btn-panel" style="width:100%">
      <h4 class="center-align" data-icon="">X</h4>
      <p class="center-align"> Historicio de facturación </p>
    </a>
  </div>

</div>
