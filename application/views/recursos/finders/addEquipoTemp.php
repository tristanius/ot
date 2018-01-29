<fieldset class="noMaterialStyles regularForm">
  <legend>Formulario para agregar equipo con codigo temporal</legend>

  <p>
    <div>Codigo temporal:</div>
    <input type="text" ng-model="addequipo.codigo_temporal">
  </p>

  <p>
    <div>Descripción temporal:</div>
    <input type="text" ng-model="addequipo.descripcion_temporal">
  </p>
  <p>
    <div>Equipo Propio? :</div>
    <input type="checkbox" ng-model="addequipo.propietario_recurso" ng-init="addequipo.propietario_recurso = true">
  </p>

  <p>
    <div>Referencia propietario:</div>
    <select ng-model="addequipo.propietario_observacion" ng-init="addequipo.propietario_observacion = 'TERMOTECNICA'">
      <option value="TERMOTECNICA">TERMOTECNICA</option>
      <option value="TERMOTECNICA-ALQ">TERMOTECNICA-ALQ</option>
      <option value="PMA-ALQ">PMA-ALQ</option>
      <option value="PMA">PMA</option>
      <option value="ECP">ECP</option>
    </select>
  </p>

  <p>
    <div>Item a asignar:</div>
    <select ng-model="myitemf_eq" ng-options="(it.itemc_item + ' ' + it.descripcion) for it in itemsOT | filter: { grupo_mayor:'equipo' }">
    </select>
  </p>

  <div>
      <button type="button" name="btn mini-btn" ng-click="addRecursoOT(addequipo, '<?= site_url('recurso/addRecursoOT') ?>', 'equipo', myitemf_eq)">Crear</button>
      <button type="button" name="btn mini-btn" ng-click="showSection('#AddEquipoTemp')">Ocultar</button>
  </div>
</fieldset>
<br>
