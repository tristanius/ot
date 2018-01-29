<section id="materialOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Material agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#materialOT',4)" class="btn green mini-btn2" name="button" ng-show="rd.info.estado == 'ABIERTO'">Agregar</button>
      <button type="button" ng-click="closeRecursoReporte('#materialOT',0)" class="btn orange mini-btn2" name="button">Volver</button>
    </div>

    <div id="AddEquiposReporteSection" class="sectionsEquiposRD " style="overflow:auto">
      <h4>Material por agregar al reporte</h4>
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
              Todos <input type="checkbox" ng-click="selectionAll(materialOT, 'add');">
            </th>
            <th colspan="6">

            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="noMaterialStyles">
            <td>
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_mOT)" ng-init="fil_mOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_mOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_mOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </tdequipoByOT>
            <td><input type="text" ng-model="fil_mOT.referencia" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_mOT.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_mOT.descripcion" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_mOT.descripcion_recurso" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_mOT.unidad_negocio" placeholder="filtrar"></td>
            <td></td>
          </tr>
          <tr ng-repeat="m in materialOT | filter: fil_mOT | orderBy: 'itemc_item' " style="{{ m.propietario_recurso==true?'':'background: #ffc46d' }}">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="m.add" ng-click="setSelecteState(m.add)"> </td>
            <td ng-bind="m.referencia"></td>
            <td ng-bind="m.itemc_item"></td>
            <td ng-bind="m.descripcion"></td>
            <td ng-bind="m.descripcion_recurso"></td>
            <td ng-bind="m.unidad_negocio"></td>
            <td ng-bind="m.propietario_observacion"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
