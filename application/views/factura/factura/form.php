<section id="formFactura" class="windowCentered2 row" ng-controller="formFactura" <?php if($isMod): ?> ng-init="getFacturaData('<?= site_url('factura/get/'.$idfactura) ?>')" <?php endif; ?> >
  <h4> <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" /> Acta de factura - {{ contrato.contratista }}</h4>
  <hr>

  <section>

    <div class="card">
      <div class="inputs row noMaterialStyles padding1ex">

        <div class="padding1ex col s12 m6 l3">
          <b>No. Factura: </b>
          <input type="text" ng-model="factura.no_factura" placeholder="No. de factura">
        </div>

        <div class="padding1ex col s12 m6 l3">
          <b>No. Contrato: </b>
          <input type="text" ng-model="contrato.no_contrato" name="" disabled/>
          <input type="hidden" ng-model="contrato.idcontrato" ng-init="factura.idcontrato = contrato.idcontrato">
        </div>

        <div class="padding1ex col s12 m6 l3">
          <b>vigencia de tarifas: </b>
          <select class="" ng-options="v.idvigencia_tarifas as v.descripcion_vigencia for v in contrato.vigencias" ng-model="factura.idvigencia_tarifas"
                ng-init="factura.idvigencia_tarifas = (factura.idvigencia_tarifas?factura.idvigencia_tarifas:contrato.vigencias[0].idvigencia_tarifas)" disabled>
          </select>
        </div>

        <div class="padding1ex col s12 m6 l3 end">
          <b>Estado del acta: </b>
          <select class="" ng-model="factura.estado_acta" ng-init="factura.estado_acta = (factura.estado_acta?factura.estado_acta:'EN CREACION')">
            <option value="EN CREACION">EN CREACION</option>
            <option value="ENVIADO">ENVIADO</option>
            <option value="POR FIRMAR">POR FIRMAR</option>
            <option value="APROBADO">APROBADO</option>
            <option value="PAGADO">PAGADO</option>
          </select>
        </div>

      </div>

      <div class="inputs row noMaterialStyles padding1ex" ng-init="initModals()">

        <div class="padding1ex col s12 m6 l3">
          <b>Inicio periodo facturación: </b>
          <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="factura.fecha_inicio" placeholder="No. de fecha" ng-disabled="0" >
        </div>

        <div class="padding1ex col s12 m6 l3">
          <b>Final periodo facturación: </b>
          <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="factura.fecha_fin" placeholder="No. de fecha" ng-disabled="0" >
        </div>

        <div class="padding1ex col s12 m6 l3 end">
          <b>Centros de operación a facturar: </b>
          <div>
            <button type="button" class="btn mini-btn modal-trigger" href="#centros_operacion">1. Centros de Operación</button>
          </div>
        </div>

        <div class="padding1ex col s12 m6 l3 end">
          <b>O.T.´s a facturar:</b>
          <div>
            <button type="button" class="btn mini-btn modal-trigger" href="#ordenes">2. Ordenes de trabajo</button>
          </div>
        </div>

      </div>
    </div>

    <div id="myTabs" ng-init="initTabs('#myTabs')">
      <ul>
        <li><a href="#tabs-1">Descripción</a></li>
        <li><a href="#tabs-2">Recursos</a></li>
        <li><a href="#tabs-3">Adjuntos</a></li>
      </ul>
      <div id="tabs-1" class="noMaterialStyles">
        <?php $this->load->view("factura/factura/notas"); ?>
      </div>
      <div id="tabs-2">
        <?php $this->load->view("factura/factura/recursos"); ?>
      </div>
      <div id="tabs-3">
        <?php $this->load->view("factura/factura/adjuntos"); ?>
      </div>
    </div>

  </section>

  <div id="modales">
    <?php $this->load->view('factura/factura/modales/centros_operacion'); ?>
    <?php $this->load->view('factura/factura/modales/ordenes'); ?>
  </div>

  <hr>

  <div class="btnWindow">
    <?php if ($isMod): ?>
      <button id="guardar_reporte" ng-show="panel_visible" type="button" class="waves-effect waves-light btn mini-btn2" ng-click="save('<?= site_url('factura/mod') ?>','mod')">
        <b data-icon="&#xe015;"></b> Actualizar
      </button>
    <?php else: ?>
      <button id="guardar_reporte" ng-show="panel_visible" type="button" class="waves-effect waves-light btn mini-btn2" ng-click="save('<?= site_url('factura/add') ?>','add')">
        <b data-icon="&#xe015;"></b> Registrar
      </button>
    <?php endif; ?>
    <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow2('#ventanaFactura', '#ventanaFacturaOculta')" data-icon="&#xe036;"> Ocultar</button>
    <button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="cerrarWindowLocal('#ventanaFactura', enlaceGetFactura)" data-icon="n"> Cerrar</button>
  </div>
</section>

<script>

</script>
