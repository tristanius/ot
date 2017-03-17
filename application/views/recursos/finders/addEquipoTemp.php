<fieldset class="noMaterialStyles">
  <legend>Formulario para agregar equipo con codigo temporal</legend>
  <div class="row">
    <div class="col m6 l6 s6 row">
      <b class="col l3 m4 s6" for="">Codigo temporal:</b>
      <input type="text" class="col l8 m7 s6" ng-model="addequipo.codigo_temporal">
    </div>

    <div class="col m6 l6 s6 row">
      <b class="col l2 m4 s6" for="">Descripción temporal:</b>
      <input type="text" class="col l8 m7 s6" ng-model="addequipo.descripcion_temporal">
    </div>

    <div class="col m6 l6 s6 row">
      <b class="col l3 m3 s6" for="">Item:</b>
      <select class="col l8 m7 s6" ng-model="myitemf_eq" ng-options="(it.itemc_item + ' ' + it.descripcion) for it in itemsOT | filter: { grupo_mayor:'equipo' }">
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col s6 m4 l3">
      <button type="button" name="btn mini-btn" ng-click="addEquipoTempOT(addequipo, '<?= site_url('recurso/addRecursoOT') ?>')">Crear</button>
    </div>
    <div class="col s6 m3 l2">
      <button type="button" name="btn mini-btn" ng-click="showSection('#AddEquipoTemp')">Ocultar</button>
    </div>
  </div>
</fieldset>
<br>
