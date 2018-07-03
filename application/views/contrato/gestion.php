<section ng-controller="contrato">

  <fieldset class="padding1ex">
    <legend> <h4>Maestro de contratos</h4> </legend>
  </fieldset>

  <fieldset class="padding1ex">

    <button type="button" class="btn btn-small" ng-click="form('<?= site_url('contrato/form/') ?>', '#ventanaContrato', #ventanaContratoOculta')">Crear contrato</button>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>No. contrato</th>
          <th>Contratista</th>
          <th>Cliente</th>
          <th>Estado</th>
          <th>Inicio estimado</th>
          <th>Final estimado</th>
          <th>Items</th>
          <th>Vigencias</th>
        </tr>
        <tr>
          <th></th>
          <th> <input type="text" ng-model="filtroContrato.no_contrato" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.contratista" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.cliente" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.estado" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.fecha_inicio_estimado" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.fecha_final_estimado" value=""> </th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="c in contratos">
          <td ng-bind="c.no_contrato"></td>
          <td ng-bind="c.contratista"></td>
          <td ng-bind="c.cliente"></td>
          <td ng-bind="c.estado==true?'Activo':'Inactivo'"></td>
          <td ng-bind="c.fecha_inicio_estimado"></td>
          <td ng-bind="c.fecha_final_estimado"></td>
          <td > <button type="button" class="btn btn-small">Items</button> </td>
          <td > <button type="button" class="btn btn-small">Vigencias</button> </td>
        </tr>
      </tbody>
    </table>

  </fieldset>

  <div id="ventanaContrato" class="VentanaContainer nodisplay row">
    <div class="loader col s12" ng-include="enlaceVentana">
    </div>
  </div>
  <div id="ventanaContratoOculta" class="WindowOculta nodisplay">
    <button type="button" class="btn blue" ng-click="toggleWindow2('#ventanaContrato', '#ventanaContratoOculta');" name="button">
      <small>Mostrar Ventana oculta</small>
    </button>
  </div>
</section>
