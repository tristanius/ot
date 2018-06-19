<div class="">

  <h5>Otros conceptos facturables</h5>

  <button type="button" class="btn btn-floating modal-trigger" href="#add_conceptos_facturables"> <i data-icon="i"></i> </button>
  <?php $this->load->view('factura/factura/modales/add_conceptos_facturables'); ?>
  <table class="mytabla">
    <thead>
      <tr>
        <th>No.</th>
        <th>Item</th>
        <th>Concepto</th>
        <th>Tipo</th>
        <th>Valor</th>
      </tr>
      <tr>
        <th></th>
        <th> <input type="text" placeholder="Filtro item" value=""> </th>
        <th> <input type="text" placeholder="Filtro concepto" value=""> </th>
        <th> <input type="text" placeholder="Filtro tipo" value=""> </th>
        <th> </th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="otr in factura.otros_conceptos track by $index">
        <td ng-bind="$index"></td>
        <td ng-bind="otr.item"></td>
        <td ng-bind="otr.concepto"></td>
        <td ng-bind="otr.tipo"></td>
        <td ng-bind="otr.valor"></td>
        <td> <button type="button" class="btn mini-bt2 red" ng-click="">X</button> </td>
      </tr>
    </tbody>
  </table>

</div>
