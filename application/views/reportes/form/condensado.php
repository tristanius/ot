<section class="card-panel" ng-controller="condensado_rd">
  <h5 class="center-align">Consilidar cantidades guardadas del reporte</h5>
  <button type="button" class="btn mini-btn2 orange" ng-click="get_condensado('<?= site_url('reporte/get_consolidado/') ?>',rd.idreporte_diario)">Generar</button>
  <table id="info_rd_condensado" class="mytabla">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Descripción</th>
        <th>Asociado</th>
        <th>Cantidad asociada</th>
      </tr>
    </thead>
    <tbody ng-repeat="act in condensado.actividades">
      <tr ng-repeat="it in condensado.items" ng-if="it.idfrente_ot == act.idfrente_ot">
        <td ng-bind="it.nombre_frente"></td>
        <td ng-bind="it.itemc_item"></td>
        <td ng-bind="it.descripcion"></td>
        <td ng-bind="act.itemc_item"></td>
        <td> <input type="text" ng-model="it.cantidad_asociada"> </td>
      </tr>
    </tbody>
  </table>

  <div class="">
    <button type="button" class="btn blue">Guardar</button>
    <button type="button" class="btn green">Exportar</button>
  </div>
</section>

{{condensado | json}}
