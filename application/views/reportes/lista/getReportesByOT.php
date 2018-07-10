<section ng-controller="reportes">
  <div class="" ng-controller="listOTReportes">

    <div class="row">
      <h5 class="center-align">Manejo de reportes diarios:</h5>
        <div class="col l12 regularForm row">

          <fieldset style="padding:1ex;" class="blue lighten-5">
            <h6><b>Consulta de orden de trabajo a reportar:</b></h6>
            <div class="noMaterialStyles row col l3 m4 s12">
              <b class="col l3 m4 s4">No. OT:</b>
              <input class="col l8 m8 s8" type="text" ng-model="consulta.indicio_nombre_ot" style="padding: 5px;" placeholder="Ej: 350-16">
            </div>

            <div class="noMaterialStyles row col l3 m4 s12">
              <b class="col l3 m4 s4">Base:</b>
              <select ng-model="consulta.base" class="col l8 m8 s8" style="height:4ex;">
                <option value="">No Seleccionado</option>
                <option ng-repeat="b in log.bases" value="{{b.idbase}}"> {{b.idbase + " - " + b.nombre_base }} </option>
              </select>
            </div>

            <div class="noMaterialStyles row col l3 m4 s12">
              <b class="col l3 m4 s4">Estado:</b>
              <select ng-model="consulta.estado" class="col l8 m8 s8" style="height:4ex;">
                <option value="">No Seleccionado</option>
                <option value="POR EJECUTAR">POR EJECUTAR</option>
                <option value="ACTIVA">ACTIVA</option>
                <option value="FINALIZÓ">FINALIZÓ</option>
              </select>
            </div>

            <div class="row col l1 m2 s12">
              <button type="button" class="btn" data-icon="," ng-click="getOTs('<?= site_url('ot/getBy') ?>')"></button>
            </div>
          </fieldset>
          <br>
          <hr>

          <?php $this->load->view('reportes/lista/otSelection'); ?>
        </div>

        <div class="col l12 m12 s12">

          <div class="noMaterialStyles row col l12">
            <div class="">
              <b class="">Orden de trabajo:</b>
              <span ng-bind="consulta.nombre_ot"></span>
              <input type="hidden" ng-model="consulta.ot">
            </div>
            <!-- <select class="col s5 l5" ng-model="consulta.ot" style="height:4ex;">
              <option ng-repeat="ot in myOts" value="{{ot.idOT}}">{{ot.nombre_ot}}</option>
            </select> -->
            <div ng-show="historialByOT">
              <button type="button" class="btn mini-btn" style="margin:0px;" ng-click="getReportesView('<?= site_url() ?>')"> Actualizar </button>

              <a target="_blank" ng-if="validPriv(68)" ng-href="<?= site_url('export/historyRepoByOT') ?>/{{consulta.idOT}}/{{consulta.nombre_ot}}" class="btn mini-btn" style="margin:0px;">historial reportes</a>
              <a target="_blank" ng-if="!validPriv(68)" ng-href="<?= site_url('export/historyRepoByOT') ?>/{{consulta.idOT}}/{{consulta.nombre_ot}}/1" class="btn mini-btn" style="margin:0px;">historial reportes</a>
              <button type="button" style="margin:0px;" class="btn orange lighten-2 mini-btn "
                  ng-click="clickeableLink('<?=  site_url('ot/resumenOT') ?>/'+consulta.idOT, $event, 'Resumen OT '+consulta.nombre_ot);">
                  Avance de obra
                </button>
            </div>
          </div>

        </div>

        <div class="col l6" ng-show="(!ot.selected && setloader)">

          <img src="<?= base_url('assets/img/ajax-loader.gif') ?>" alt="">

        </div>
    </div>

    <div class="row">
      <hr clas="hr-termo">

      <div class="row col l12" ng-show="ot.selected" ng-init="ot.selected = false">
        <div class="col l12" style="margin:0px;padding:0px;">
          <div class="col s12 m8 l9">
            <?php $this->load->view('reportes/lista/list'); ?>
          </div>
          <div ng-if="validPriv(38)" class="col s12 m4 l3" ng-include="calendarLink" ng-controller="calendar"> </div>
        </div>
      </div>

    </div>

    <div id="ventanaReporte" class="VentanaContainer nodisplay row">
      <div class="loader col s12" ng-include="enlaceGetReporte">
      </div>
    </div>
    <div id="ventanaReporteOCulta" class="WindowOculta nodisplay">
      <button type="button" class="btn blue" ng-click="toggleWindow2('#ventanaReporte', '#ventanaReporteOCulta');" name="button">
        <small>Mostrar Ventana oculta</small>
      </button>
    </div>
  </div>

</section>
