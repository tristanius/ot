<fieldset class="noMaterialStyles regularForm">
  <legend>Formulario para agregar material</legend>

  <div class="row noMaterialStyles regularForm">
    <div class="col m6 s12 l4">
      <p>
        <label>Referencia / Serial:</label>
        <input type="text" ng-model="addMaterial.codigo_temporal">
      </p>

      <p>
        <label>Descripción del material:</label>
        <input type="text" ng-model="addMaterial.descripcion_temporal">
      </p>

      <p>
        <label>Material Propio? :</label>
        <input type="checkbox" ng-model="addMaterial.propietario_recurso" ng-init="addMaterial.propietario_recurso = true">
      </p>
    </div>
    <div class="col m6 s12 l4">
      <p>
        <label>Referencia propietario:</label>
        <select ng-model="addMaterial.propietario_observacion" ng-init="addMaterial.propietario_observacion = 'TERMOTECNICA'">
          <option value="TERMOTECNICA">TERMOTECNICA</option>
          <option value="TERMOTECNICA-ALQ">TERMOTECNICA-ALQ</option>
          <option value="PMA-ALQ">PMA-ALQ</option>
          <option value="PMA">PMA</option>
          <option value="ECP">ECP</option>
        </select>
      </p>

      <p>
        <label>Item a asignar:</label>
        <select ng-model="myitemf_mt" ng-options="(el.itemc_item + ' ' + el.descripcion) for el in itemsOT | filter: { grupo_mayor:'material' }"></select>
      </p>

      <p>
        <label>Costo por unidad :</label>
        <input type="number" ng-model="addMaterial.costo_und" ng-init="addMaterial.costo_und = 0">
      </p>
    </div>
  </div>

  <div>
      <button type="button" class="btn mini-btn green" ng-click="addRecursoOT(addMaterial, '<?= site_url('recurso/addRecursoOT') ?>', 'material', myitemf_mt); showSection('#addMaterial')"
        ng-disabled="!addMaterial.codigo_temporal || !myitemf_mt">
        Crear
      </button>
      <button type="button" class="btn mini-btn orange" ng-click="showSection('#addMaterial')">Ocultar</button>
  </div>
</fieldset>
<br>
