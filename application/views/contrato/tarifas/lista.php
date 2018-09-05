<h5 class="center-align"> Listado de tarifas de la vigencia</h5>

<button type="button" class="btn btn-small light-green accent-4">Agregar</button>
<button type="button" class="btn btn-small indigo darken-3">Importar</button>
<button type="button" class="btn btn-small orange">Exportar</button>

<div class="">
  <br>
</div>

<table class="mytabla staked font11">
  <thead>
    <tr>
      <th>ID</th>
      <th>Codigo</th>
      <th>Item</th>
      <th>Descripción</th>
      <th>Tipo</th>
      <th>Tarifa</th>
      <th>Mod.</th>
      <th>Del.</th>
    </tr>
    <tr>
      <th></th>
      <th> <input type="text" ng-model="filterTarifaVigencia.codigo" placeholder="filtro" style="width: 10ex;"> </th>
      <th> <input type="text" ng-model="filterTarifaVigencia.item" placeholder="filtro" style="width: 10ex;"> </th>
      <th> <input type="text" ng-model="filterTarifaVigencia.descripcion" placeholder="filtro"> </th>
      <th> <input type="text" ng-model="filterTarifaVigencia.tipo" placeholder="filtro" style="width: 10ex;"> </th>
      <th> <input type="text" ng-model="filterTarifaVigencia.tarifa" placeholder="filtro" style="width: 10ex;"> </th>
      <th> </th>
      <th> </th>
    </tr>
  </thead>
  <tbody>
    <tr ng-repeat="tf in vg.tarifas | filter: filterTarifaVigencia">
      <th> <i class="fas fa-info-circle" ng-click="dialog(tf.iditemf)"></i> </th>
      <td ng-bind="tf.codigo"></td>
      <td ng-bind="tf.item"></td>
      <td ng-bind="tf.descripcion"></td>
      <td ng-bind="tf.tipo"></td>
      <td ng-bind="tf.tarifa | currency:'$ ':2 "></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
