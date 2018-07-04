<fieldset class="noMaterialStyles regularForm">
  <legend>Formulario para agregar material</legend>

  <div class="row noMaterialStyles regularForm">
    <div class="col l4 m6 s12">
      <p>
        <label>Referencia / Serial:</label>
        <input type="text" ng-model="addOtro.codigo_temporal">
      </p>

      <p>
        <label>Descripción del item:</label>
        <input type="text" ng-model="addOtro.descripcion_temporal">
      </p>
      <p>
        <label>Item Propio? :</label>
        <input type="checkbox" ng-model="addOtro.propietario_recurso" ng-init="addOtro.propietario_recurso = true">
      </p>
    </div>
    <div class="col l4 m6 s12">
      <p>
        <label>Referencia propietario:</label>
        <select ng-model="addOtro.propietario_observacion" ng-init="addOtro.propietario_observacion = 'TERMOTECNICA'">
          <option value="TERMOTECNICA">TERMOTECNICA</option>
          <option value="TERMOTECNICA-ALQ">TERMOTECNICA-ALQ</option>
          <option value="PMA-ALQ">PMA-ALQ</option>
          <option value="PMA">PMA</option>
          <option value="ECP">ECP</option>
        </select>
      </p>

      <p>
        <label>Item a asignar:</label>
        <select ng-model="myitemf_mt" ng-options="(el.itemc_item + ' ' + el.descripcion) for el in itemsOT | filter: { grupo_mayor:'otros' }">
        </select>
      </p>


      <p>
        <label>Costo por unidad :</label>
        <input type="number" ng-model="addOtro.costo_und" ng-init="addOtro.costo_und = 0">
      </p>
    </div>
  </div>

  <div>
      <button type="button" name="btn mini-btn" ng-click="addRecursoOT(addOtro, '<?= site_url('recurso/addRecursoOT') ?>', 'otros', myitemf_mt)">Crear</button>
      <button type="button" name="btn mini-btn" ng-click="showSection('#addOtros')">Ocultar</button>
  </div>
</fieldset>
<br>
