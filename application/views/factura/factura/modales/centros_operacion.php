<div id="centros_operacion" class="modal" ng-init="factura.centros_operacion = contrato.centros_operacion">
  <div class="modal-content">
    <div class="card padding1ex">

      <h5> Centros de operacion a facturar:</h5>
      <p>Los centros de operación seleccionados obtendrán los recursos de la OTs homologadas es estos para facturar:</p>
      <table class="mytabla noMaterialStyles" style="background:#FFF; width: auto;">
        <thead>
          <tr>
            <th>Seleccion</th>
            <th>C.O.</th>
            <th>Descripción</th>
          </tr>
          <tr ng-init="seleccionCO = {}">
            <th></th>
            <th> <input type="text" ng-model="seleccionCO.idbase"> </th>
            <th> <input type="text" ng-model="seleccionCO.nombre_base"> </th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="c in factura.centros_operacion | filter: seleccionCO" >
            <td><input type="checkbox" ng-model="c.isSelected" ng-init="c.isSelected = (c.isSelected?c.isSelected:true)" ng-change="deteccionCambios = true" ng-disabled="factura.validado"></td>
            <td><span ng-bind="c.idbase"></span> </td>
            <td><span ng-bind="c.nombre_base"></span> </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="btn mini-btn modal-close" ng-click="selectedCOs(); getRecursos('<?= site_url('factura/get_recursos')  ?>')" ng-if="!factura.validado"> Filtrar los C.O.´s seleccionados. </a>
    <a href="#!" class="btn mini-btn modal-close red darken-3" > Salir sin filtrar </a>
  </div>
</div>
