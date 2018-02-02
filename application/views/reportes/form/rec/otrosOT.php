<section id="otrosOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Otros elementos agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#otrosOT',4)" class="btn green mini-btn2" name="button" ng-show="rd.info.estado == 'ABIERTO'">Agregar</button>
      <button type="button" ng-click="closeRecursoReporte('#otrosOT',0)" class="btn orange mini-btn2" name="button">Volver</button>
    </div>

    <div id="AddEquiposReporteSection" class="sectionsEquiposRD " style="overflow:auto">
      <h4>Otros elementos por agregar al reporte</h4>
      <table class="mytabla">
        <thead>
          <tr>
            <th>No. </th>
            <th>Referencia</th>
            <th>item</th>
            <th>Referencia</th>
            <th>Descripción</th>
            <th>Unidad negocio</th>
            <th>Asignacion</th>
          </tr>
          <tr>
            <th class="noMaterialStyles">
              Todos <input type="checkbox" ng-click="selectionAll(otrosOT, 'add');">
            </th>
            <th colspan="6">

            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="noMaterialStyles">
            <td>
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_otros)" ng-init="fil_otros.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_otros.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_otros.add == true" data-icon="&#xe04c;"></big>
              </button>
            </tdequipoByOT>
            <td><input type="text" ng-model="fil_otros.referencia" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_otros.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_otros.descripcion" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_otros.descripcion_recurso" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_otros.unidad_negocio" placeholder="filtrar"></td>
            <td></td>
          </tr>
          <tr ng-repeat="otr in otrosOT | filter: fil_otros | orderBy: 'itemc_item' " style="{{ otr.propietario_recurso==true?'':'background: #ffc46d' }}">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="otr.add" ng-click="setSelecteState(otr.add)"> </td>
            <td ng-bind="otr.referencia"></td>
            <td ng-bind="otr.itemc_item"></td>
            <td ng-bind="otr.descripcion"></td>
            <td ng-bind="otr.descripcion_recurso"></td>
            <td ng-bind="otr.unidad_negocio"></td>
            <td ng-bind="otr.propietario_observacion"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
