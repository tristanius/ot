<section class="card-panel" ng-controller="condensado_rd">
  <h5 class="center-align">Consilidar cantidades guardadas del reporte</h5>
  <button type="button" class="btn mini-btn2 orange" ng-click="get_condensado('<?= site_url('reporte/gen_condensadoo/') ?>',rd.idreporte_diario)">Generar</button>

  <table id="info_rd_condensado" class="mytabla" >
      <caption style="border:1px solid #333">
        Consolidado de frentes y actividades generado en: {{ condensado.fecha }}
      </caption>
      <thead>
        <tr>
          <th>#</th>
          <th>Item</th>
          <th>Descripción</th>
          <th>Asociado</th>
          <th>Cantidad asociada</th>
        </tr>
      </thead>
      <tbody ng-repeat="frente in condensado.frentes">
        <tr ng-repeat="it in frente.items" >
          <td ng-bind="it.nombre_frente"></td>
          <td ng-bind="it.itemc_item"></td>
          <td ng-bind="it.descripcion"></td>
          <td ng-bind="it.item_asociado"></td>
          <td ng-if="!condensado.guardado"> <input type="text" ng-model="it.cantidad_asociada"> </td>
          <td ng-if="condensado.guardado" ng-bind="it.cantidad_asociada"></td>
        </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </tbody>
  </table>


  <div class="">
    <button type="button" class="btn blue" ng-click="" ng-if="condensado.guardado == false">Guardar</button>
    <button type="button" class="btn green" ng-click="" ng-if="condensado.guardado == true">Exportar</button>
  </div>
</section>
