<section id="subcontratosOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Actividades  de <b>Subcontrato</b> planeadas en esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#subcontratosOT', 6)" class="btn green mini-btn2" name="button" ng-show="rd.info.estado == 'ABIERTO'">Agregar</button>
      <button type="button" ng-click="closeRecursoReporte('#subcontratosOT',0)" class="btn orange mini-btn2" name="button">Volver</button>

      <p class="padding1ex">
        Selecciona las actividades de <b>Subcontrato</b> que deseas reportar hoy.
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
            <th>Frente</th>
            <th>Tarea</th>
            <th>Subtarifa</th>
            <th>Planeado</th>
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
            <td><input type="text" ng-model="fil_subcontratosOT.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_subcontratosOT.codigo" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_subcontratosOT.descripcion" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_subcontratosOT.nombre_frente" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_subcontratosOT.nombre_tarea" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_subcontratosOT.subtarifa" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_subcontratosOT.planeado" placeholder="filtrar"></td>
          </tr>
          <tr ng-repeat="sbc in subcontratosOT | filter: fil_subcontratosOT">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="sbc.add" ng-init="sbc.add=false"> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.itemc_item"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.codigo"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.descripcion"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.nombre_frente"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.nombre_tarea"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.subtarifa"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="sbc.planeado"></span> </td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
