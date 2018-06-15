<section>
  <table class="mytabla font10">
    <thead>
      <tr>
        <th>ID</th>
        <th>No. Factura</th>
        <th></th>
        <th>Inicio (aaaa-mm-dd)</th>
        <th>Final (aaaa-mm-dd)</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>Opciones</th>
      </tr>
      <tr class="noMaterialStyles">
        <th></th>
        <th> <input type="text" ng-model="filtroFactura.no_factura"> </th>
        <th> <input type="text" ng-model="filtroFactura.total"> </th>
        <th> <input type="text" ng-model="filtroFactura.fecha_inicio"> </th>
        <th> <input type="text" ng-model="filtroFactura.fecha_fin"> </th>
        <th> <input type="text" ng-model="filtroFactura.estado"> </th>
        <th> <input type="text" ng-model="filtroFactura.tipo_acta"> </th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <tr ng-repeat="c in contrato.facturas">
        <td> </td>
        <td> <span ng-bind="c.no_factura"></span> </td>
        <td ng-bind="c.total | currency"></td>
        <td ng-bind="c.fecha_inicio"></td>
        <td ng-bind="c.fecha_fin"></td>
        <td ng-bind="c.estado"></td>
        <td ng-bind="c.tipo_acta"></td>
        <td>
          <button type="button" class="btn mini-btn" ng-click="factura('<?= site_url('factura/form/mod') ?>/'+c.idfactura, '#ventanaFactura','#ventanaFacturaOcultas')"> Ir </button>
          <a class="btn mini-btn blue" ng-href="<?= site_url('export/informaActaFactura') ?>/{{c.idfactura}}" target="_blank"> Export </a>
        </td>
      </tr>
    </tbody>
  </table>
</section>
