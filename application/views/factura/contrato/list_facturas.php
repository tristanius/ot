<section>
  <table class="mytabla font10">
    <thead>
      <tr>
        <th>Id</th>
        <th>No. Factura</th>
        <th>Factura $</th>
        <th>Tarifas</th>
        <th>Ini. periodo (Año-mes-día)</th>
        <th>Fin periodo (Año-mes-día)</th>
        <th>Estado</th>
        <th>Tipo</th>
        <th>Opciones</th>
      </tr>
      <tr class="noMaterialStyles">
        <th></th>
        <th> <input type="text" ng-model="filtroFactura.no_doc"> </th>
        <th> <input type="text" ng-model="filtroFactura.total"> </th>
        <th> <input type="text" ng-model="filtroFactura.descripcion_vigencia"> </th>
        <th> <input type="text" ng-model="filtroFactura.fecha_fin_factura"> </th>
        <th> <input type="text" ng-model="filtroFactura.fecha_fin_factura"> </th>
        <th> <input type="text" ng-model="filtroFactura.estado"> </th>
        <th> <input type="text" ng-model="filtroFactura.tipo"> </th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <tr ng-repeat="c in contrato.facturas">
        <td> <button type="button" ng-if="c.estado == 'ELABORACION' " class="btn mini-btn2 red" ng-click="delFactura(c.idfactura)"> X </button> </td>
        <td> Documento: <span ng-bind="c.no_doc"></span> </td>
        <td ng-bind="c.total | currency"></td>
        <td ng-bind="c.descripcion_vigencia"></td>
        <td ng-bind="c.fecha_ini_factura"></td>
        <td ng-bind="c.fecha_fin_factura"></td>
        <td ng-bind="c.estado"></td>
        <td ng-bind="c.tipo"></td>
        <td>
          <button type="button" class="btn mini-btn" ng-click="factura('<?= site_url('factura/form/mod') ?>/'+c.idfactura, '#ventanaFactura','#ventanaFacturaOcultas')"> Ir </button>
          <a class="btn mini-btn blue" ng-href="<?= site_url('export/informaActaFactura') ?>/{{c.idfactura}}" target="_blank"> Export </a>
        </td>
      </tr>
    </tbody>
  </table>
</section>
