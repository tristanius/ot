<div class="noMaterialStyles regularForm row">
  <div class="col s12 m6 l4">
    <small>Aplicar Estado: </small>
    <select class="" ng-model="aplicarEstado">
      <option value="" style="color:#BBB"></option>
      <option value="POR APROBAR">POR APROBAR</option>
      <option value="APROBADO">APROBADO</option>
      <option value="FACTURADO">FACTURADO</option>
      <option value="PAGO">PAGO</option>
    </select>
    <button type="button" class="btn mini-btn2 light-green darken-3" ng-click="setValRange(aplicarEstado, 'estado', orden.recursos )"> Estado <span data-icon="&#xe00a;"></span> </button>
  </div>

  <div class="col s12 m6 l4">
    <label for="">Aplicar acta serv.: </label>
    <select class="" ng-model="aplicarActa" data-icon="&#xe02f;">
      <option value="" style="color:#BBB"></option>
      <option value="{{b}}" ng-repeat="b in fac.actas">{{b}}</option>
    </select>
    <button type="button" class="btn mini-btn2 light-green darken-3" ng-click="setValRange(aplicarActa, 'acta', orden.recursos )"> Acta <span data-icon="&#xe00a;"></span> </button>
  </div>
</div>
