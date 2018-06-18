<section ng-controller="factura">
  <h5>Gestión de facturas</h5>

  <div class="panel row noMaterialStyles regularForm">

    <div class="col s12 m12 l12" ng-init="linkDataContrato = '<?= site_url('factura/lista') ?>'">
      <span>Contrato:</span>
      <select class="" ng-model="consulta.idcontrato" ng-init="consulta.idcontrato = '1'">
        <?php foreach ($contratos as $key => $value): ?>
          <option value="<?= $value->idcontrato ?>"><?= $value->no_contrato.' - '.$value->contratista ?></option>
        <?php endforeach; ?>
      </select>
      <button type="button" style="margin:0" class="btn mini-btn" ng-click="getDataContrato()">Gestionar</button>
    </div>

  </div>
  <hr>


  <div class="row">
    <div class="col s12 m6 l6" ng-if="consulta.idcontrato != '' && consulta.idcontrato != undefined && contrato.no_contrato != undefined && contrato.no_contrato != ''">
      <button type="button" class="btn btn-small" ng-click="factura('<?= site_url('factura/form/add') ?>', '#ventanaFactura', '#ventanaFacturaOculta')">
        <span data-icon="i"></span>
      </button> Add. Factura a {{ contrato.no_contrato }}
    </div>
    <div class="loader col s12 m6 l6" ng-show="loaders.getfacturas" ng-init="loaders.getfacturas = false">
      <img src="<?= base_url('assets/img/ajax-loader2.gif') ?>" alt="">
    </div>
  </div>

  <div class="resultset">
    <br>
    <?php $this->load->view('factura/contrato/list_facturas'); ?>
  </div>


  <div id="ventanaFactura" class="VentanaContainer nodisplay row">
    <div class="loader col s12" ng-include="enlaceGetFactura">
    </div>
  </div>
  <div id="ventanaFacturaOculta" class="WindowOculta nodisplay">
    <button type="button" class="btn blue" ng-click="toggleWindow2('#ventanaFactura', '#ventanaFacturaOculta');" name="button">
      <small>Mostrar Ventana oculta</small>
    </button>
  </div>


</section>
