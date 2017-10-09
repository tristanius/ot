<section id="equipoOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Equipo agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#equipoOT',2)" class="btn green mini-btn2" name="button" ng-show="rd.info.estado == 'ABIERTO'">Agregar</button>
      <button type="button" ng-click="closeRecursoReporte('#equipoOT',4)" class="btn orange mini-btn2" name="button">Volver</button>
    </div>

    <div class="row">
      <br>
      <button type="button" class="btn blue" ng-click="showContent('#AddEquiposReporteSection', 'div.sectionsEquiposRD')">Equipos para reportar</button>
      <!-- <button type="button" class="btn blue-grey darken-1" ng-click="showContent('#AddEquiposOtSection', 'div.sectionsEquiposRD')">Buscar equipos no relacionados</button> -->
      <br>
    </div>

    <div id="AddEquiposReporteSection" class="sectionsEquiposRD " style="overflow:auto">
      <h4>Equipos por agregar al reporte</h4>
      <table class="mytabla">
        <thead>
          <tr>
            <th>No. </th>
            <th>Cod. Siesa</th>
            <th>Referencia</th>
            <th>Descripción</th>
            <th>item</th>
            <th>Unidad negocio</th>
            <th>Asignacion</th>
          </tr>
          <tr>
            <th class="noMaterialStyles">
              Todos <input type="checkbox" ng-click="selectionAll(equiposOT, 'add');">
            </th>
            <th colspan="6">

            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="noMaterialStyles">
            <td>
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_eOT)" ng-init="fil_eOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_eOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_eOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </tdequipoByOT>
            <td><input type="text" ng-model="fil_eOT.codigo_siesa" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_eOT.referencia" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_eOT.descripcion" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_eOT.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_eOT.unidad_negocio" placeholder="filtrar"></td>
            <td></td>
          </tr>
          <tr ng-repeat="e in equiposOT | filter: fil_eOT | orderBy: 'itemc_item' " style="{{ e.propietario_recurso==true?'':'background: #ffc46d' }}">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="e.add" ng-click="setSelecteState(e.add)"> </td>
            <td ng-bind="e.codigo_siesa"></td>
            <td ng-bind="e.referencia"></td>
            <td ng-bind="e.descripcion"></td>
            <td ng-bind="e.itemc_item"></td>
            <td ng-bind="e.unidad_negocio"></td>
            <td ng-bind="e.propietario_observacion"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
