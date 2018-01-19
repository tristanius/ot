<fieldset class="noMaterialStyles regularForm">
  <legend>Formulario para agregar material</legend>

  <p>
    <div>Codigo Materal:</div>
    <input type="text" ng-model="addMaterial.codigo_temporal">
  </p>

  <p>
    <div>Descripción del material:</div>
    <input type="text" ng-model="addMaterial.descripcion_temporal">
  </p>
  <p>
    <div>Material Propio? :</div>
    <input type="checkbox" ng-model="addMaterial.propietario_recurso" ng-init="addMaterial.propietario_recurso = true">
  </p>

  <p>
    <div>Referencia propietario:</div>
    <select ng-model="addMaterial.propietario_observacion" ng-init="addMaterial.propietario_observacion = 'TERMOTECNICA'">
      <option value="TERMOTECNICA">TERMOTECNICA</option>
      <option value="TERMOTECNICA-ALQ">TERMOTECNICA-ALQ</option>
      <option value="PMA-ALQ">PMA-ALQ</option>
      <option value="PMA">PMA</option>
      <option value="ECP">ECP</option>
    </select>
  </p>

  <p>
    <div>Item a asignar:</div>
    <select ng-model="myitemf_mt" ng-options="(el.itemc_item + ' ' + el.descripcion) for el in itemsOT | filter: { grupo_mayor:'material' }">
    </select>
  </p>

  <div>
      <button type="button" name="btn mini-btn" ng-click="addRecursoOT(addMaterial, '<?= site_url('recurso/addRecursoOT') ?>', 'material', myitemf_mt)">Crear</button>
      <button type="button" name="btn mini-btn" ng-click="showSection('#addMaterial')">Ocultar</button>
  </div>
</fieldset>
<br>
