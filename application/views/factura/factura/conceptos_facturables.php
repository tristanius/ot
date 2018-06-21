<div class="">

  <h5>Otros conceptos facturables</h5>

  <button type="button" class="btn light-blue accent-4 modal-trigger" href="#add_conceptos_facturables"> <i data-icon="i"></i> </button>
  <br>
  <?php $this->load->view('factura/factura/modales/add_conceptos_facturables'); ?>
  <table class="mytabla font10">
    <thead>
      <tr style="background: #EEE">
        <th>No.</th>
        <th>Item</th>
        <th>Concepto</th>
        <th>Tipo</th>
        <th>Valor</th>
      </tr>
      <tr style="background: #EEE">
        <th></th>
        <th> <input type="text" placeholder="Filtro item" ng-model="filtroConceptoFactura.item"> </th>
        <th> <input type="text" placeholder="Filtro concepto" ng-model="filtroConceptoFactura.concepto"> </th>
        <th> <input type="text" placeholder="Filtro tipo" ng-model="filtroConceptoFactura.tipo"> </th>
        <th> <input type="text" placeholder="Filtro tipo" ng-model="filtroConceptoFactura.valor"> </th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="otr in factura.conceptos_factura | filter: filtroConceptoFactura  track by $index">
        <td ng-bind="$index"></td>
        <td ng-bind="otr.item"></td>
        <td ng-bind="otr.concepto"></td>
        <td ng-bind="otr.tipo"></td>
        <td ng-bind="otr.valor"></td>
        <td> <button type="button" class="btn mini-bt2 red" ng-click="removeConceptoFactura(otr, '<?= site_url('factura/remove_concepto_factura') ?>')">X</button> </td>
      </tr>
    </tbody>
  </table>

</div>
