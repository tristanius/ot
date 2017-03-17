<div class="noMaterialStyles">
  <table class="mytabla" ng-hide="isOnPeticion">
    <thead>
      <tr style="background: #EEE">
        <th>#</th>
        <th style="background: #F4F9FD ">Fact.</th>
        <th style="max-width:6ex;">Sector</th>
        <th>item</th>
        <th>Descripcion</th>
        <th>Unidad</th>
        <th>Cant. día</th>
        <th>Acumulado</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="act in rd.recursos.actividades track by $index" class="{{ (act.idrecurso_reporte_diario == undefined || act.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista(rd.recursos.actividades, act, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="act.facturable" ng-init="act.facturable = parseBool(act.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <td style="max-width:6ex;"> <span ng-bind="act.idsector_item_tarea"></span> </td>
        <td ng-bind="act.itemc_item"></td>
        <td ng-bind="act.descripcion"></td>
        <td ng-bind="act.unidad"></td>
        <td class="inputsSmall"> <input type="number" min=0 step=0.1 ng-model="act.cantidad" ng-init="act.cantidad = parseNumb(act.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td ng-init="act.acumulado  = getCantidadSum('<?= site_url('reporte/getCantidadSum/') ?>', rd.info.fecha_reporte, act, rd.info.idOT )" >
          <span ng-bind="(parseNumb(act.acumulado) + parseNumb(act.cantidad)) | number:5"></span>
        </td>
    </tbody>
  </table>
</div>

<br>
