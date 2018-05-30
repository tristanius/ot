<div class="noMaterialStyles">
  <table class="mytabla font10" ng-hide="isOnPeticion">
    <thead>
      <tr style="background: #EEE">
        <th>#</th>
        <th style="background: #F4F9FD ">Fact.</th>
        <th style="max-width:6ex;">Sector</th>
        <th>item</th>
        <th>Descripcion</th>
        <th>UND</th>
        <th>Cant. día</th>
        <th>Acumulado</th>
        <th>Abscisa Ini.</th>
        <th>Abscisa fin.</th>
        <th>Tipo instal.</th>
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
        <th></th>
        <th></th>
        <th></th>
        <th>
          <?php if (isset($frentes) && sizeof($frentes) > 0 ): ?>
            <input type="hidden" ng-init="actividadFilter.idfrente_ot = myfrente" disabled="disabled">
          <?php endif; ?>
        </th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="act in rd.recursos.actividades | filter: actividadFilter track by $index" ng-if="act.idfrente_ot == myfrente" class="{{ (act.idrecurso_reporte_diario == undefined || act.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista(rd.recursos.actividades, act, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="act.facturable" ng-init="act.facturable = parseBool(act.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <td style="max-width:6ex;"> <span ng-bind="act.idsector_item_tarea"></span> </td>
        <td ng-bind="act.itemc_item">
        </td>
        <td ng-bind="act.descripcion"></td>
        <td ng-bind="act.unidad"></td>
        <td> <input type="number" min=0 step=0.00001 ng-model="act.cantidad" ng-init="act.cantidad = parseNumb(act.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' " style="width: 10ex;"> </td>
        <td ng-init="act.acumulado?act.acumulado:0;">
          <span ng-bind="(act.acumulado*1) + (act.cantidad*1) |  number:5"></span>
        </td>
        <td> <input type="text" ng-model="act.abscisa_ini" value="" style="width: 10ex;" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td> <input type="text" ng-model="act.abscisa_ini" value="" style="width: 10ex;" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td>
          <select class="" ng-model="act.tipo_instalacion" style="width: 12ex;" ng-disabled="rd.info.estado == 'CERRADO'">
            <option value="N/A">N/A</option>
            <option value="Box Coulbert">Box Coulbert</option>
            <option value="Instalaciones Hidráulicas">Instalaciones Hidráulicas</option>
            <option value="Obra Civil">Obra Civil</option>
          </select>
        </td>
        <td  class="font9">
          <span ng-if="act.item_asociado"> (<span ng-bind="act.item_asociado" style="color: #934B10"></span>)</span>
          <button type="button" class="btn mini-btn2 blue" ng-click="viewAsociarItem(act, '#asociarItem')"
            ng-show="rd.info.estado != 'CERRADO'" data-icon="*">
          </button>
        </td>
    </tbody>
  </table>
</div>
<br>
