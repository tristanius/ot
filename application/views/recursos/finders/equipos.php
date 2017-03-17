<fieldset class="noMaterialStyles">
  <legend>Busca un equipo cargado y relacionalo con la Orden:</legend>

  <div class="row">
    <label class="col s6 m2 l2">Cod. Siesa:</label>
    <input type="text" ng-model="myconsulta.codigo_siesa">
    <button type="button" class="btn mini-btn" style="margin-top:0" data-icon="," ng-click="findRecursoOT('<?= site_url('recurso/finby') ?>', 'equipo', myconsulta, 'relacionEquipos')"></button>
    <button type="button" name="btn mini-btn" style="margin-top:0" ng-click="showSection('#findEquipo')" data-icon="&#xe036;"></button>
  </div>

  <br>

  <table>
    <thead>
      <tr>
        <th>Codigo siesa</th>
        <th>Referencia</th>
        <th>Descripcion</th>
        <th>Item por asignar</th>
        <th>Agregar</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="e in relacionEquipos">
        <td ng-bind="e.codigo_siesa"></td>
        <td ng-bind="e.referencia"></td>
        <td ng-bind="e.descripcion"></td>
        <td>
          <select class="col l8 m7 s6" ng-model="e.itemf" ng-options="(it.itemc_item + ' ' + it.descripcion) for it in itemsOT | filter: { grupo_mayor:'equipo' }">
          </select>
        </td>
        <td> <button type="button" class="btn mini-btn">Add.</button> </td>
      </tr>
    </tbody>
  </table>
</fieldset>
