<section id="formFactura" class="windowCentered2 row" ng-controller="formFactura" <?php if($isMod): ?> ng-init="getFacturaData('<?= site_url('factura/get/'.$idfactura) ?>')" <?php endif; ?>>
  <style media="screen">
     #formFactura label{
       color:#000;
     }
  </style>
  <section class="area reportes" ng-init='sectores = <?= json_encode($sectores) ?>'>
    <div class="btnWindow">
      <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindowLocal('#ventanaFactura', enlaceGetFactura)">Salir</button>
    </div>
  </section>
  <h5 class="center-align" style="border:1px solid #2196F3;  padding:2px;"> Acta/Factura </h5>

  <div id="basesFact" class="noMaterialStyles row font12" style="border:1px solid #000; padding:1ex; background:#EFEFEF">
    <div class="col s12 m6 l4 regularForm row">
      <span>Nombre del documento.: </span>
      <input type="text" class="text" ng-model="fac.no_doc" placeholder="Acta No. #">
    </div>

    <div class="col s12 m6 l4 regularForm row">
      <span>Inicio periodo Fact.: </span>
      <input type="text" class="datepicker" ng-model="fac.fecha_ini_factura" ng-init="datepicker_init()" placeholder="ingresa una fecha (ini)" readonly>
    </div>

    <div class="col s12 m6 l4 regularForm row">
      <span>Final periodo Fact.: </span>
      <input type="text" class="datepicker" ng-model="fac.fecha_fin_factura" ng-init="datepicker_init()" placeholder="ingresa una fecha (fin)" readonly>
    </div>

    <div class="col s12 m6 l4 regularForm row">
      <span>Vigencia de tarifas:</span>
      <select class="" ng-model="fac.idvigencia_tarifas" ng-init="fac.idvigencia_tarifas = (contrato.vigencias[0].idvigencia_tarifas+'')">
        <option value="">Selecciona una opción</option>
        <option ng-repeat="vig in contrato.vigencias" value="{{vig.idvigencia_tarifas}}">{{vig.descripcion_vigencia}}</option>
      </select>
    </div>

    <div class="col s12 m6 l4 regularForm row">
      <span>Tipo de Factura:</span>
      <select class="" ng-model="fac.tipo" ng-init="fac.tipo = 'ESTANDAR'">
        <option value="">Selecciona una opción</option>
        <option value="ESTANDAR">Estandar</option>
        <option value="REAJUSTE">Reajuste</option>
      </select>
    </div>

    <div class="col s12 m6 l4 regularForm row">
      <span>C. Costo ECP: </span>
      <input type="text" ng-model="fac.centro_costo_ecp" placeholder="Centro de costo" >
    </div>

    <div class="clear-left"></div>

    <?php
    if(!$isMod){
      $this->load->view('factura/factura/form_co');
    }else{
      $this->load->view('factura/factura/form_newacta');
    } ?>

    <?php if (!$isMod): ?>
      <div class="row">
        <button type="button" class="btn mini-btn" ng-click="getRecursos('<?= site_url('factura/getFacturablesByOT') ?>')">Obtener recursos reportados</button>
      </div>
    <?php endif; ?>

  </div>

  <br>
  <div class="loader col s12 m12 l12" ng-show="loaders.formLoad" <?php if (!$isMod): ?> ng-init="loaders.formLoad = false" <?php endif; ?> >
    <img src="<?= base_url('assets/img/ajax-loader2.gif') ?>" alt="">
  </div>

  <div class="panel" ng-show="panel_visible">
    <?php $this->load->view('factura/factura/recursos'); ?>
  </div>

  <br>
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
