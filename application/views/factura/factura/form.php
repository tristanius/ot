<section id="formFactura" class="windowCentered2 row" ng-controller="formFactura" <?php if($isMod): ?> ng-init="getFacturaData('<?= site_url('factura/get/'.$idfactura) ?>')" <?php endif; ?> >
  <h4 class="card padding1ex" > <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" /> Acta de factura - {{ contrato.contratista }}</h4>
  <hr>

  <img src="<?= base_url('assets/img/ajax-loader2.gif') ?>" ng-show="spinner" alt="">

  <section >

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
          <select class="" ng-options="v as v.descripcion_vigencia for v in contrato.vigencias" ng-model="factura.vigencia_tarifas"
                ng-init="factura.vigencia_tarifas = (factura.vigencia_tarifas?factura.vigencia_tarifas:contrato.vigencias[0])" disabled>
          </select>
        </div>

        <div class="padding1ex col s12 m6 l3 end">
          <b>Estado del acta: </b>

          <div class="fixed-action-btn">
            <a class="btn-floating btn-large red">
              <i class="large material-icons">mode_edit</i>
            </a>
            <ul>
              <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
              <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
              <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
              <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
            </ul>
          </div>

          <select class="" ng-model="factura.estado_acta" ng-init="factura.estado_acta = (factura.estado_acta?factura.estado_acta:'EN CREACION')">
            <option value="EN CREACION">EN CREACION</option>
            <option value="APROBADO">APROBADO</option>
            <option value="POR FIRMAR">POR FIRMAR</option>
            <option value="POR PAGAR">POR PAGAR</option>
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

        <div class="padding1ex col s12 m6 l3" ng-if="factura.fecha_inicio && factura.fecha_fin && factura.estado != 'CERRADO'">
          <b>Centros de operación a facturar: </b>
          <div>
            <button type="button" class="btn mini-btn modal-trigger" href="#centros_operacion">1. Centros de Operación</button>
          </div>
        </div>

        <div class="padding1ex col s12 m6 l3 end" ng-if="factura.fecha_inicio && factura.fecha_fin && factura.estado != 'CERRADO'">
          <b>O.T.´s a facturar:</b>
          <div>
            <button type="button" class="btn mini-btn modal-trigger" href="#ordenes">2. Ordenes de trabajo</button>
          </div>
        </div>

        <div class="padding1ex col s12 m12 l6 end"  ng-if="!factura.fecha_inicio || !factura.fecha_fin">
          <p class="panel" style="color:orange">Hola, debes seleccionar fechas de inicio y final de factura para filtrar C.O´s y Ordenes de trabajo.</p>
        </div>

      </div>
    </div>

    <div id="myTabs" ng-init="initTabs('#myTabs')">
      <ul>
        <li><a href="#tabs-1">Información</a></li>
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

  <img src="<?= base_url('assets/img/ajax-loader2.gif') ?>" ng-show="spinner" alt="">

  <div class="btnWindow" ng-show="!spinner">
    <button id="guardar_reporte" type="button" class="waves-effect waves-light green btn mini-btn2" ng-click="save('<?= site_url('factura/save') ?>')">
      <b data-icon="&#xe015;"></b> Guardar Cambios
    </button>
    <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow2('#ventanaFactura', '#ventanaFacturaOculta')" data-icon="&#xe036;"> Ocultar</button>
    <button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="confirmarCerrar('¿Estas seguro de cerrar el formulario de factura?','#ventanaFactura', enlaceGetFactura)" data-icon="n"> Cerrar</button>
  </div>
</section>


<script type="text/javascript">
$(document).ready(function(){
  $('.fixed-action-btn').floatingActionButton();
})
</script>
