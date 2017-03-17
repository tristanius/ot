<div class="noMaterialStyles" ng-init='getEstadosDoc(<?= json_encode($estados) ?>)'>
  <div class="row">
    <b class="col s3 m3 l2">Estado validacion PYCO: <span style="color:#4CAF50" ng-bind="rd.info.validado_pyco"></span> </b>
  </div>
  <hr>

  <div class="row" ng-if="myestado_doc.indicador_validacion == 'validador' ">
	   <div class="col s2 m2 l1">Nueva Validacion PYCO: </div>

    <div class="col s4 m3 l2" ng-show="validPriv(45)">
      <select class="" ng-model="selected_validacion_doc">
        <option ng-if="myestado_doc.anterior_validacion_doc != null" value="{{ myestado_doc.anterior_validacion_doc }}">{{myestado_doc.anterior_label}}</option>
        <option ng-if="myestado_doc.siguiente_validacion_doc != null" value="{{ myestado_doc.siguiente_validacion_doc }}">{{myestado_doc.siguiente_label}}</option>
      </select>
    </div>

    <button type="button" class="col s3 m2 l1 btn mini-btn" ng-if="selected_validacion_doc" ng-click="appyEstadoDoc(selected_validacion_doc)">Aplicar val.</button>
  </div>

  <div class="row"  ng-if="myestado_doc.indicador_validacion == 'facturador' " >
	   <div class="col s2 m2 l1">Validación FACT: </div>

    <div class="col s4 m3 l2" ng-show="validPriv(46)">
      <select class="" ng-model="selected_validacion_doc3">
        <option ng-if="myestado_doc.anterior_validacion_doc != null" value="{{ myestado_doc.anterior_validacion_doc }}">{{myestado_doc.anterior_label}}</option>
        <option ng-if="myestado_doc.siguiente_validacion_doc != null" value="{{ myestado_doc.siguiente_validacion_doc }}">{{myestado_doc.siguiente_label}}</option>
      </select>
    </div>

    <button type="button" class="col s3 m2 l1 btn mini-btn" ng-if="selected_validacion_doc3" ng-click="appyEstadoDoc(selected_validacion_doc3)">Aplicar val.</button>
  </div>

  <hr>

  <section>
  	<div class="">
  	  <label for="">Add. Observación PYCO</label>
  	  <textarea ng-model="obspyco"></textarea>
  	  <button type="button" class="btn" ng-click="addObservacion2(obspyco)"> Add. </button>
  	</div>
  </section>

</div>
