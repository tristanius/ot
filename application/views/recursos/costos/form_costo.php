<div id="form_costos_recurso" class="modal card-panel">

  <div class="padding1ex">

    <fieldset>
      <div class="">
        <label>Costo UND (<span ng-bind="cambio_un.data.unidad"></span>):  </label>
        <input type="text" ng-model="costo.costo_und">
      </div>

      <div class="">
        <label>F. inicio de valides del costo</label>
        <input type="text" ng-model="costo.fecha_inicio">
      </div>

      <div class="">
        <label>F. final de valides del costo</label>
        <input type="text" ng-model="costo.fecha_final">
      </div>

      <button type="button" class="btn btn-small" ng-click="addNuevoCostoRecurso(costo)">agregar costo</button>
    </fieldset>

    <table>
      <thead>
        <tr>
          <th>costo UND</th>
          <th>F. inicio</th>
          <th>F. final</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="cr in  costos_recurso">
          <td ng-bind="cr.costo_und"></td>
          <td ng-bind="cr.fecha_inicio"></td>
          <td ng-bind="cr.fecha_fin"></td>
        </tr>
      </tbody>
    </table>

  </div>

</div>
