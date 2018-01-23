<section class="card-panel" ng-controller="condensado_rd">
  <h5 class="center-align">Consilidar cantidades guardadas del reporte</h5>
  <table id="info_rd_condensado" ng-init="get_condensado('<?= site_url('reporte/get_consolidado/') ?>',rd.idreporte_diario)">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Descripción</th>
        <th>Asociado</th>
        <th>Cantidad</th>
      </tr>
    </thead>
    <tbody ng-repeat="act in condensado.actividades">
      <tr ng-repeat="i in condensado.items">
        <td ng-model="i.itemc_item"></td>
        <td ng-model="i.descripcion"></td>
        <td ng-model="act.itemc_item"></td>
        <td> <input type="text" ng-model="i.cantidad"> </td>
      </tr>
    </tbody>
  </table>

  <div class="">
    <button type="button" class="btn blue">Guardar</button>
    <button type="button" class="btn green">Exportar</button>
  </div>
</section>
