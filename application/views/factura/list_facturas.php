<section style="max-width:100%; overflow: auto;">
  <table class="mytabla font10">
    <thead>
      <tr>
        <th>ID</th>
        <th>No. Factura</th>
        <th>Descripcion</th>
        <th>Total factura</th>
        <th>Inicio (aaaa-mm-dd)</th>
        <th>Final (aaaa-mm-dd)</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>Opciones</th>
      </tr>
      <tr class="noMaterialStyles">
        <th></th>
        <th> <input type="text" ng-model="filtroFactura.no_factura"> </th>
        <th> <input type="text" ng-model="filtroFactura.descripcion" value=""> </th>
        <th> <input type="text" ng-model="filtroFactura.total"> </th>
        <th> <input type="text" ng-model="filtroFactura.fecha_inicio"> </th>
        <th> <input type="text" ng-model="filtroFactura.fecha_fin"> </th>
        <th> <input type="text" ng-model="filtroFactura.estado_factura"> </th>
        <th> <input type="text" ng-model="filtroFactura.tipo_acta"> </th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <tr ng-repeat="c in contrato.facturas | filter: filtroFactura">
        <td> </td>
        <td> <span ng-bind="c.no_factura"></span> </td>
        <td ng-bind="c.descripcion"></td>
        <td ng-bind="c.total | currency" class="right-align"></td>
        <td ng-bind="c.fecha_inicio" class="right-align"></td>
        <td ng-bind="c.fecha_fin" class="right-align"></td>
        <td ng-bind="c.estado_factura"></td>
        <td ng-bind="c.tipo_acta"></td>
        <td>
          <button type="button" class="btn mini-btn" ng-click="factura('<?= site_url('factura/form/mod') ?>/'+c.idfactura, '#ventanaFactura','#ventanaFacturaOcultas')"> Editar </button>
          <button type="button" class="btn mini-btn" ng-click="ver('<?= site_url('factura/ver') ?>/'+c.idfactura, '#ventanaFactura','#ventanaFacturaOcultas')"> Ver </button>

          <button type="button" class="btn mini-btn red darken-4" ng-click="delFactura('<?= site_url('factura/delete') ?>/', c.idfactura)"> Delete </button>
        </td>
      </tr>
    </tbody>
  </table>
</section>
