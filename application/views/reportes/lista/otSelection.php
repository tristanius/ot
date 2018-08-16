<section id="seleccionar_ot" ng-show="seleccionar_ot" class="col s12 m12 l12" style="max-height: 300px; overflow: auto">
  <h6>Seleciona la OT buscada:</h6>
  <hr>
  <div class="">
    <table class="mytabla" style="background:#FFF; width: auto;">
      <thead>
        <tr>
          <th>Seleccionar</th>
          <th>C.O. / oficina</th>
          <th>No. Orden</th>
          <th>Estado</th>
        </tr>
        <tr>
          <th></th>
          <th> <input type="text" ng-model="filterOtSelect.base_idbase" placeholder="filtro de busqueda"> </th>
          <th> <input type="text" ng-model="filterOtSelect.nombre_ot" placeholder="filtro de busqueda"> </th>
          <th> <input type="text" ng-model="filterOtSelect.estado_doc" placeholder="filtro de busqueda"> </th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="ot in myOts | filter: filterOtSelect">
          <td>
            <button type="button" class="btn mini-btn2" ng-click="seleccionarOT(ot, '<?= site_url() ?>')" data-icon="w"> Sel.</button>
          </td>
          <td ng-bind="ot.base_idbase"></td>
          <td ng-bind="ot.nombre_ot"></td>
          <td ng-bind="ot.estado_doc"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
</section>
