<section id="actividadOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Actividades planeadas en esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#actividadOT',3)" class="btn green mini-btn2" name="button" ng-show="rd.info.estado == 'ABIERTO'">Agregar</button>
      <button type="button" ng-click="closeRecursoReporte('#actividadOT',0)" class="btn orange mini-btn2" name="button">Volver</button>

      <p class="padding1ex">
        Selecciona las actividades que deseas reportar hoy.
      </p>

    </div>

    <div class="" style="overflow:auto">
      <table class="mytabla">
        <thead>
          <tr>
            <th>#</th>
            <th>Item</th>
            <th>Codigo Fact.</th>
            <th>Descripcion</th>
            <th>Sector</th>
            <th>Planeado</th>
            <th>Nombre de OT</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="noMaterialStyles">
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_acOT)" ng-init="fil_acOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_acOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_acOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </td>
            <td><input type="text" ng-model="fil_acOT.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_acOT.codigo" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_acOT.descripcion" placeholder="filtrar"></td>
            <td></td>
            <td><input type="text" ng-model="fil_acOT.planeado" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_acOT.nombre_ot" placeholder="filtrar"></td>
          </tr>
          <tr ng-repeat="ac in actividadesOT | filter: fil_acOT">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="ac.add" ng-init="ac.add=false"> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.itemc_item"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.codigo"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.descripcion"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.idsector_item_tarea"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.planeado"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.nombre_ot"></span> </td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
