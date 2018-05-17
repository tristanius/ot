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
        <th data-icon="*"> </th>
      </tr>
      <tr style="background: #b9dae5">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>
          <?php if (isset($frentes) && sizeof($frentes) > 0 ): ?>
            <input type="hidden" ng-init="otrosFilter.idfrente_ot = myfrente" disabled="disabled">
          <?php endif; ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="otr in rd.recursos.otros | filter: otrosFilter track by $index" ng-if="otr.idfrente_ot == myfrente" class="{{ (otr.idrecurso_reporte_diario == undefined || otr.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista(rd.recursos.otros, otr, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="otr.facturable" ng-init="otr.facturable = parseBool(otr.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <td ng-bind="otr.itemc_item">
        </td>
        <td ng-bind="otr.descripcion"></td>
        <td ng-bind="otr.unidad"></td>
        <td> <input type="number" ng-model="otr.cantidad" ng-init="otr.cantidad = parseNumb(otr.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' " style="width: 10ex;"> </td>
        <td ng-bind="otr.idfrente_ot"></td>
        <td  class="font9">
          <span ng-if="otr.item_asociado"> (<span ng-bind="otr.item_asociado" style="color: #934B10"></span>)</span>
          <button type="button" class="btn mini-btn2 blue" ng-click="viewAsociarItem(otr, '#asociarItem')"
            ng-show="rd.info.estado != 'CERRADO'" data-icon="*">
          </button>
        </td>
    </tbody>
  </table>
</div>
<br>
