<section class="card-panel" ng-controller="condensado_rd">
  <h5 class="center-align" ng-init="get_condensado('<?= site_url('reporte/get_condensado/') ?>', <?= $r->idreporte_diario ?>)">Consilidar cantidades guardadas del reporte</h5>
  <button type="button" class="btn mini-btn2 orange" ng-click="get_condensado('<?= site_url('reporte/gen_condensado/') ?>',rd.idreporte_diario)">Generar</button> &nbsp;
  <button type="button" ng-if="condensado.guardado == true" class="btn mini-btn2 light-green accent-1" ng-click="get_condensado('<?= site_url('reporte/actualizar_condensado/') ?>',rd.idreporte_diario)">Actualizar</button>

  <table id="info_rd_condensado" class="mytabla" >
      <caption style="border:1px solid #333">
        Consolidado de frentes y actividades generado en: {{ condensado.fecha }}
      </caption>
      <thead>
        <tr style="background: #6FA5ED">
          <th>Orden</th>
          <th>Frente</th>
          <th>Fecha</th>
          <th>Item</th>
          <th>Descripción</th>
          <th>UND</th>
          <th>Asociado</th>
          <th>Total frente</th>
          <th>Cantidad asociada</th>
        </tr>
      </thead>
      <tbody ng-repeat="frente in condensado.frentes">
        <tr>
          <td colspan="9"> <b ng-bind="frente.nombre+' '+frente.ubicacion"></b>  </td>
        </tr>
        <tr ng-repeat="it in frente.items" >
          <td ng-bind="it.nombre_ot"></td>
          <td ng-bind="it.nombre_frente"></td>
          <td ng-bind="it.fecha_reporte"></td>
          <td ng-bind="it.itemc_item"></td>
          <td class="tableexport-string"> <span ng-bind="it.descripcion"></span> </td>
          <td ng-bind="it.unidad"></td>
          <td ng-bind="it.item_asociado + ' ('+ it.descripcion_asociada +') '"></td>
          <td ng-bind="it.total"></td>
          <td>
            <input type="number" ng-if="!condensado.guardado" ng-model="it.cantidad_asociada" ng-change="validar_cantidad_frente('codigo', it.codigo, frente.items, it)">
            <span ng-if="condensado.guardado" ng-bind="it.cantidad_asociada"></span>
            <span ng-if="it.alerta == true" style="color:red">La cantidad ingresada supera los valores maximos reportados del item en este frente.</span>
          </td>
        </tr>
      </tbody>
  </table>

  <div>

    <button type="button" class="btn blue" ng-click="save_condensado('<?= site_url('reporte/save_condensado') ?>', condensado, rd.idreporte_diario)" ng-if="condensado.guardado == false">Guardar</button>
    <button type="button" class="btn green" ng-click="exportar_tabla('#info_rd_condensado')" ng-if="condensado.guardado == true">Exportar</button>
  </div>
</section>
