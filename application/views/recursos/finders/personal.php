<fieldset class="noMaterialStyles">
  <legend>Busca una persona cargada a otra orden para realacionarla:</legend>
  <small style="color:red">Cuidado! si no estas seguro de la cedula procede con precaución.</small>
  <div class="row">
    <label class="col s4 m3 l2">Cedula:</label>
    <input class="col s5 m4 l3" type="text" ng-model="myconsulta.identificacion">
    <br class="clear-left">
    <label class="col s4 m3 l2">Orden: </label>
    <input class="col s5 m4 l3" type="text" ng-model="myconsulta.nombre_ot">
    <br class="clear-left">
    <button type="button" style="margin:0" data-icon="," ng-click="findRecursoOT('<?= site_url('recurso/finby') ?>', 'persona', myconsulta, 'relacionPersonal')"></button>
    <button type="button" style="margin:0" ng-click="showSection('#findPersonal')" data-icon="&#xe036;"></button>
  </div>

  <br>

  <table class="mytabla font10" >
    <thead>
      <tr>
        <th>Orden</th>
        <th>Identificacion</th>
        <th>Nombre completro</th>
        <th>Cargo de la Orden</th>
        <th>Cargo a relacionar (B: basico / O: opcional)</th>
        <th>Agregar</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="p in relacionPersonal">
        <td ng-bind="p.nombre_ot"></td>
        <td ng-bind="p.identificacion"></td>
        <td ng-bind="p.nombre_completo"></td>
        <td ng-bind="p.descripcion"></td>
        <td>
          <select class="col l8 m7 s6" ng-model="p.itemf" ng-options="(it.itemc_item + ' ' + it.descripcion+' - tipo item:'+ it.BO) for it in itemsOT | filter: { grupo_mayor:'persona' }">
          </select>
        </td>
        <td>
          <button type="button" class="btn mini-btn" style="overflow:visible; max-height:9ex" ng-click="relacionarRecursosOT('<?= site_url('recurso/relacionarRecursosOT') ?>', 'persona', p, findPersonal)">
            Add. a {{ consulta.nombre_ot }}
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>
