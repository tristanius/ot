<div id="ordenes" class="modal">
  <div class="modal-content">
    <div class="card padding1ex">

      <h5> Ordenes de Trabajo a facturar:</h5>
      <p>Las siguientes ordenes seleccionadas son las que tomaran recursos para facturar:</p>
      <table class="mytabla noMaterialStyles" style="background:#FFF; width: auto;">
        <thead>
          <tr>
            <th>Seleccion</th>
            <th>Orden de trabajo</th>
            <th>C.O.</th>
          </tr>
          <tr ng-init="seleccionCO = {}">
            <th></th>
            <th> <input type="text" ng-model="seleccionOT.nombre_ot"> </th>
            <th> <input type="text" ng-model="seleccionOT.base_idbase"> </th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="c in factura.ordenes | filter: seleccionOT" >
            <td><input type="checkbox" ng-model="c.isSelected" ng-init="c.isSelected = (c.isSelected?c.isSelected:true)" ng-change="deteccionCambios = true"></td>
            <td><span ng-bind="c.nombre_ot"></span> </td>
            <td><span ng-bind="c.base_idbase"></span> </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="btn mini-btn modal-close" ng-click="selectedOTs(); getRecursos('<?= site_url('factura/get_recursos')  ?>')"> filtrar las O.T. seleccionadas. </a>
    <a href="#!" class="btn mini-btn modal-close red darken-3" > Salir sin filtrar </a>
  </div>
</div>
