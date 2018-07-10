<div style="overflow: auto">
  <table class="mytabla font11 striped">
    <thead>
      <tr>
        <th class="blue-grey lighten-4" colspan="4">Items de contrato</th>
        <th class="blue-grey lighten-5" colspan="9">Items internos equivalentes</th>
      </tr>
      <tr class="blue-grey lighten-5">
        <th class="blue-grey lighten-4">#</th>
        <th class="blue-grey lighten-4">Item</th>
        <th class="blue-grey lighten-4">Descripcion</th>
        <th class="blue-grey lighten-4">Tipo</th>
        <th>Codigo Interno</th>
        <th>Descripcion interna</th>
        <th>unidad</th>
        <th>Und. minima</th>
        <th>Hr. disp</th>
        <th>Base disp</th>
        <th>Incidencia salarial</th>
        <th>Mod</th>
        <th>Del.</th>
      </tr>
      <tr class="blue-grey darken-3">
        <th></th>
        <th> <input type="text" ng-model="filtroItems.item" placeholder="filtro" /> </th>
        <th> <input type="text" ng-model="filtroItems.descripcion" placeholder="filtro" /> </th>
        <th class="noMaterialStyles">
          <select ng-model="filtroItems.tipo">
            <option value="actividad">actividad</option>
            <option value="personal">Personal</option>
            <option value="equipo">equipo</option>
            <option value="material">Material</option>
            <option value="otros">Otros</option>
            <option value="">Sin selección</option>
          </select>
        </th>
        <th> <input type="text" ng-model="filtroItems.codigo" placeholder="filtro" /> </th>
        <th> <input type="text" ng-model="filtroItems.descripcion_interna" placeholder="filtro" /> </th>
        <th> <input type="text" ng-model="filtroItems.unidad" placeholder="filtro" /> </th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody ng-init="itemCounter = 0">
      <tr ng-repeat="i in items | filter: filtroItems track by $index">
        <td> <a href="#" ng-click="dialog('IDitemc: '+i.iditemc+'- IDitemf: '+i.iditemf)" ng-bind="$index"></a> </td>
        <td ng-bind="i.item"> </td>
        <td ng-bind="i.descripcion"> </td>
        <td ng-bind="i.tipo"> </td>
        <td ng-bind="i.codigo"> </td>
        <td ng-bind="i.descripcion_interna"> </td>
        <td ng-bind="i.unidad"> </td>
        <td ng-bind="i.und_minima"> </td>
        <td ng-bind="i.hrdisp"> </td>
        <td ng-bind="i.basedisp"> </td>
        <td ng-bind="i.incidencia_salarial"> </td>
        <td>
          <button type="button" class="btn btn-small orange font10"> Modificar</button>
        </td>
        <td>
          <button type="button" class="btn btn-small red font10"> X</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
