<fieldset class="noMaterialStyles regularForm">
  <legend>Formulario para agregar equipo con codigo temporal</legend>

  <p>
    <div>Referencia / Serial:</div>
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

  <p>
    <label>Costo por unidad :</label>
    <input type="number" ng-model="addequipo.costo_und" ng-init="addequipo.costo_und = 0">
  </p>

  <div>
      <button type="button" class="btn mini-btn green" ng-click="addRecursoOT(addequipo, '<?= site_url('recurso/addRecursoOT') ?>', 'equipo', myitemf_eq); showSection('#addEquipo')"
        ng-disabled="!addequipo.codigo_temporal || !myitemf_eq">
        Crear
      </button>
      <button type="button" class="btn mini-btn orange" ng-click="showSection('#addEquipo'); addEquipo = {} ">Ocultar</button>
  </div>
</fieldset>
<br>
