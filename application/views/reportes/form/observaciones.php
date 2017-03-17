<section>
  <div class="">
    <label for="">Add. Observación</label>
    <button type="button" class="btn" ng-click="addObservacion()"> Add. </button>
  </div>
  <div class="" ng-repeat="obs in rd.info.observaciones track by $index">
    <hr>
    Observación:
    <textarea ng-model="obs.msj"></textarea>
  </div>
</section>
