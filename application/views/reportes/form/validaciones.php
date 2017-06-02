<div class="noMaterialStyles" ng-init='getEstadosDoc(<?= json_encode($estados) ?>)'>
  <div class="row" ng-if="myvalidacion_doc">
    <b>Estado validacion por aplicar: <span style="color:#874d08" ng-bind="myvalidacion_doc"></span> </b>
    <button type="button" ng-click="aplicarEstado(myestado_doc, myvalidacion_doc)" class="">Aplicar</button>
  </div>
  <br>

  <section class="row">
    <fieldset class="col l3 m3 s12" ng-if="validPriv(45) && (rd.info.validado_pyco == 'ELABORADO' || rd.info.validado_pyco == 'CORREGIDO')">
        <legend>Validación PYCO</legend>
        <button type="button" class="btn mini-btn2 green darken-1" ng-click="appyEstadoDoc('CERRADO','VALIDO')" ng-disabled="!validPriv(45)">Valido</button>
        <button type="button" class="btn mini-btn2 orange darken-4" ng-click="appyEstadoDoc('ABIERTO','CORREGIR')" ng-disabled="!validPriv(45)">Corregir</button>
    </fieldset>
    <fieldset class="col l3 m3 s12" ng-if="validPriv(50) && (rd.info.validado_pyco == 'VALIDO' || rd.info.validado_pyco == 'CORREGIDO')">
        <legend>Validación Costos</legend>
        <button type="button" class="btn mini-btn2 orange darken-4" ng-click="appyEstadoDoc('CERRADO','CORREGIR HE')" ng-disabled="!validPriv(50)">corregir HE</button>
        <button type="button" class="btn mini-btn2 orange darken-4" ng-click="appyEstadoDoc('CERRADO','CORREGIR VIATICOS')" ng-disabled="!validPriv(50)">Corregir Viaticos</button>
    </fieldset>
    <fieldset class="col l3 m3 s12" ng-if="validPriv(70)">
        <legend>Validación Facturación</legend>
        <button type="button" class="btn mini-btn2 green darken-1" ng-click="appyEstadoDoc('CERRADO','FIRMADO')" ng-disabled="!validPriv(70)">Firmado</button>
    </fieldset>
  </section>

  <hr>

  <section>
  	<div class="">
  	  <label for="">Add. Observación de validación:</label>
  	  <textarea ng-model="obspyco"></textarea>
  	  <button type="button" class="btn" ng-click="addObservacion2(obspyco)"> Add. </button>
  	</div>
  </section>

</div>
