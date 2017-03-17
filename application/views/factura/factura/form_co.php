<button type="button" ng-click="togglePanel()"> Filtro C.O. </button>
<section ng-hide="panel_visible">
  <div class="regularForm row col l6 m6 s12" style="border:1px solid #CCC;" ng-repeat="sec in sectores">
    <b class="col l12 m12 s12">Sector <span  ng-bind="sec.sector"></span> </b>
    <div class="col l6 m6 s12" ng-repeat="b in sec.bases">
      <label>
        <!-- <input type="checkbox" ng-model="fac.bases[b.idbase]" ng-change="" > -->
         <input type="checkbox" ng-model="b.selected" ng-change="delAddFromList(fac.bases, b.idbase)" >
        <span ng-bind="b.idbase+'-'+b.nombre_base"></span>
      </label>
    </div>
  </div>
</section>
