<section ng-controller="contrato">

  <fieldset class="padding1ex" ng-init="getContratos('<?= site_url('contrato/get_contratos') ?>')">
    <legend> <h4>Maestro de contratos</h4> </legend>
  </fieldset>

  <fieldset class="padding1ex">

    <p>
      <button type="button" class="btn btn-small blue darken-3 white-text" ng-click="form('<?= site_url('contrato/form/') ?>', '#ventanaContrato', '#ventanaContratoOculta')">Crear contrato</button>
    </p>

    <table class="mytabla striped font10">
      <thead>
        <tr class="blue-grey lighten-4">
          <th>ID</th>
          <th>No. contrato</th>
          <th>Contratista</th>
          <th>Cliente</th>
          <th>Estado</th>
          <th>Items</th>
          <th>Vigencias de tarifa</th>
          <th>Inicio estimado</th>
          <th>Final estimado</th>
          <th>Mod.</th>
          <th>Elim</th>
        </tr>
        <tr class="blue-grey lighten-5">
          <th></th>
          <th> <input type="text" ng-model="filtroContrato.no_contrato" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.contratista" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.cliente" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.estado" value=""> </th>
          <th></th>
          <th></th>
          <th> <input type="text" ng-model="filtroContrato.fecha_inicio_estimado" value=""> </th>
          <th> <input type="text" ng-model="filtroContrato.fecha_final_estimado" value=""> </th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody >
        <tr ng-repeat="c in contratos | filter: filtroContrato">
          <td ng-bind="c.idcontrato"></td>
          <td ng-bind="c.no_contrato"></td>
          <td ng-bind="c.contratista"></td>
          <td ng-bind="c.cliente"></td>
          <td ng-bind="c.estado==true?'Activo':'Inactivo'"></td>
          <td>
            <button type="button" class="btn btn-small lime lighten-4 black-text"
              ng-click="clickeableLink('<?= site_url('item/gestion') ?>/'+c.idcontrato, $event, 'Maestro items de contrato');">
              <small>Items</small>
            </button>
          </td>
          <td>
            <button type="button" class="btn btn-small green accent-2" ng-click="clickeableLink('<?= site_url('vigencia/gestion') ?>/'+c.idcontrato, $event, 'Vigencias de contrato');">
              <small>Vigencias</small>
            </button>
          </td>
          <td ng-bind="c.fecha_inicio_estimado"></td>
          <td ng-bind="c.fecha_fin_estimado"></td>
          <td>
            <button type="button" class="btn btn-small orange" ng-click="form('<?= site_url('contrato/form/') ?>/'+c.idcontrato, '#ventanaContrato', '#ventanaContratoOculta');"> <small>Modificar</small> </button>
          </td>
          <td>
            <button type="button" class="btn btn-small red"> <small>X</small> </button>
          </td>
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
