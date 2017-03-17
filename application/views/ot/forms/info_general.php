<section>
  <div class="">
    <h5>Información general de OT</h5>

    <div class="row">

      <div class="col s12 m12 l12">
        <label for=""> Estado de la Orden:  <span style="color:green" ng-bind="ot.estado_doc"></span></label>

        <select ng-model="myestado_doc">
          <option value="POR EJECUTAR" ng-if="(ot.estado_doc != 'ACTIVA' && ot.estado_doc != 'FINALIZÓ')">POR EJECUTAR</option>
          <option value="ACTIVA">ACTIVA</option>
          <option value="FINALIZÓ">FINALIZÓ</option>
        </select>

        <button type="button" class="btn mini-btn2" ng-click="ot.estado_doc = myestado_doc">Aplicar</button>
      </div>
    </div>

    <br>

    <div style="padding:3px;" class="row">
      <div class="col s12 m12 l12">
        Fecha real inicio: <input type="text" class="datepicker" ng-model="ot.fecha_inicio" ng-init="datepicker_init()" placeholder="fecha inicio real">
      </div>
      <div class="col s12 m12 l12">
        Fecha real final: <input type="text" class="datepicker" ng-model="ot.fecha_fin" ng-init="datepicker_init()" placeholder="fecha fin real">
      </div>
    </div>

    <br>

    <div class="row" style="background:#F1F1F1; padding:3px;">
      O.T. Legalizada: <input type="text" ng-model="ot.ot_legalizada" placeholder="Orden legalizada" ng-readonly="!validPriv(54)">
    </div>

    <div class="row" style="background:#F1F1F1; padding:3px;">
      F. creación C.C.: <input type="text" class="datepicker" ng-model="ot.fecha_creacion_cc" placeholder="Orden legalizada" ng-disabled="!validPriv(54)">
    </div>

    <br>

    <div style="background:#F1F1F1; padding:3px;" class="row">
      <div class="col s12 m12 l12">
        Presupuesto Interno inicial:
        <input type="text" class="datepicker" ng-model="ot.presupuesto_fecha_ini" ng-init="datepicker_init()" placeholder="P Interno fecha inicial" ng-disabled="!validPriv(54)">
        <input type="text" ng-model="ot.presupuesto_porcent_ini" placeholder="%" ng-readonly="!validPriv(54)">
      </div>
      <div class="col s12 m12 l12">
        Presupuesto Interno Final:
        <input type="text" class="datepicker" ng-model="ot.presupuesto_fecha_fin" ng-init="datepicker_init()" placeholder="P. interno fecha Final" ng-disabled="!validPriv(54)">
        <input type="text" ng-model="ot.presupuesto_porcent_fin" placeholder="%" ng-readonly="!validPriv(54)">
      </div>
    </div>

  </div>
</section>
