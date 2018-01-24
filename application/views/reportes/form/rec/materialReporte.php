<div class="noMaterialStyles">
  <table class="mytabla font10" ng-hide="isOnPeticion">
    <thead>
      <tr style="background: #EEE">
        <th>#</th>
        <th style="background: #F4F9FD ">Fact.</th>
        <th>item</th>
        <th>Descripcion</th>
        <th>Unidad</th>
        <th>Cant. día</th>
        <th>Frente</th>
        <th> <> </th>
      </tr>
      <tr style="background: #b9dae5">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>
          <?php if (isset($frentes) && sizeof($frentes) > 0 ): ?>
            <input type="hidden" ng-init="materialFilter.idfrente_ot = myfrente" disabled="disabled">
          <?php endif; ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="m in rd.recursos.material | filter: materialFilter track by $index" class="{{ (m.idrecurso_reporte_diario == undefined || m.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista(rd.recursos.material, m, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="m.facturable" ng-init="m.facturable = parseBool(m.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <td ng-bind="m.itemc_item">
        </td>
        <td ng-bind="m.descripcion"></td>
        <td ng-bind="m.unidad"></td>
        <td> <input type="number" ng-model="m.cantidad" ng-init="m.cantidad = parseNumb(m.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' " style="width: 10ex;"> </td>
        <td ng-bind="m.idfrente_ot"></td>
        <td  class="font9">
          <span ng-if="m.item_asociado"> (<span ng-bind="m.item_asociado" style="color: #934B10"></span>)</span>
          <button type="button" class="btn mini-btn2 blue" ng-click="viewAsociarItem(m, '#asociarItem')"
            ng-show="rd.info.estado != 'CERRADO'"> <>
          </button>
        </td>
    </tbody>
  </table>
</div>
<br>
