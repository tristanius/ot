<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Cambio de Unidad de negocio </h4>
    <small ng-bind="cambio_un.data.idrecurso_ot"> </small>
    <p>
      <table>
        <thead>
          <tr>
            <th> Codigo recurso </th>
            <th> Nombre de recurso</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-if="cambio_un.data.identificacion">
            <td> <span ng-bind="cambio_un.data.identificacion"></span> </td>
            <td> <span ng-bind="cambio_un.data.nombre_completo"></span> </td>
          </tr>
          <tr ng-if="cambio_un.data.codigo_siesa">
            <td> <span ng-bind="cambio_un.data.referencia"></span> </td>
            <td> <span ng-bind="cambio_un.data.descripcion_equipo"></span> </td>
          </tr>
          <tr ng-if="cambio_un.data.itemf_codigo">
            <td> <span ng-bind="cambio_un.data.itemf_codigo"></span> </td>
            <td> <span ng-bind="cambio_un.data.descripcion"></span> </td>
          </tr>
        </tbody>
      </table>
    </p>
    <fieldset>
      <div class="noMaterialStyles regularForm">
        <div>
          <label for="">Unidad de negocio: </label>
          <select ng-model="cambio_un.data.UN">
            <option value=""></option>
            <option value="PERSONAL">PERSONAL</option>
            <option value="EQUIPO">EQUIPO</option>
            <option value="APU">APU</option>
          </select>
        </div>

        <div class="">
          <label for="">Costo UND:</label>
          <input type="text" ng-model="cambio_un.data.costo_und">
        </div>
      </div>
    </fieldset>
  </div>
  <div class="modal-footer">
    <a href="#!" class="waves-effect waves-green btn-flat" ng-click="cambiarUN( '<?= site_url('recurso/update_rot') ?>', cambio_un, '#modal1')">Actualizar</a>
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" ng-click="cambio_un.data = undefined" style="color:red">Salir</a>
  </div>
</div>
