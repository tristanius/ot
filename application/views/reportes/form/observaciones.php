<section>
  <section class="row">

    <div class="col s12 m6 l6">
      <div class="">
        <label for="">Add. Observación</label>
        <button type="button" class="btn btn-floating green" ng-click="addObservacion('proveedor')" ng-if="validPriv(71)"> Add. </button>
      </div>

      <div class="" ng-repeat="obs in rd.info.observaciones track by $index">
        <br>
        Observación <span ng-if="obs.fecha" ng-bind="obs.fecha"></span> <button type="button" class="btn mini-btn2 red"  ng-if="validPriv(71) && rd.info.estado == 'ABIERTO' " ng-click="popObservacion( rd.info.observaciones, obs )"> x </button>:
        <textarea ng-model="obs.msj" ng-disabled="rd.info.estado == 'CERRADO' || !validPriv(71)" style="min-height: 15ex; border: 1px solid #999; box-shadow: none;"></textarea>
      </div>
    </div>

    <div class="col s12 m6 l6">
      <div class="">
        <label for="">Add. Actividad</label>
        <button type="button" class="btn btn-floating blue" ng-click="addActividad('proveedor')" ng-if="validPriv(71)"> Add. </button>
      </div>

      <div class="" ng-repeat="obs in rd.info.actividades track by $index">
        <br>
        Actividad <span ng-if="obs.fecha" ng-bind="obs.fecha"></span> <button type="button" class="btn mini-btn2 red"  ng-if="validPriv(71) && rd.info.estado == 'ABIERTO' " ng-click="popObservacion( rd.info.actividades, obs )"> x </button>:
        <textarea ng-model="obs.msj" ng-disabled="rd.info.estado == 'CERRADO' || !validPriv(71)" style="min-height: 15ex; border: 1px solid #999; box-shadow: none;"></textarea>
      </div>
    </div>

  </section>

  <hr>

  <div class="row">
    <div class="col s12 m12 l12">
      <label for="">Add. Observación del cliente</label>
      <button type="button" class="btn btn-floating" ng-click="addObservacion('cliente')" ng-if="validPriv(72)"> Add. </button>
    </div>
    <div class="" ng-repeat="obs in rd.info.observaciones_cliente track by $index">
      <br>
      Observación cliente <span ng-bind="obs.fecha"></span>:
      <textarea ng-model="obs.msj" ng-disabled="rd.info.estado == 'CERRADO' || !validPriv(72)" style="min-height: 15ex; border: 1px solid #999; box-shadow: none;"></textarea>
    </div>
  </div>

</section>
