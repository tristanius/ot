<section id="personalOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Personal agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#personalOT',1)" class="btn green mini-btn2" name="button" ng-show="rd.info.estado == 'ABIERTO'">Agregar</button>
      <button type="button" ng-click="closeRecursoReporte('#personalOT',4)" class="btn orange mini-btn2" name="button">Volver</button>

      <p class="padding1ex">
        Hola, aqui puedes elejir el personal que deseas agreagar al reporte diario que estas desarrollando. Recuerda, una vez hecho esto podras duplicar el reporte para agilizar este proceso
      </p>

    </div>

    <div class="" style="overflow:auto">
      <table class="mytabla">
        <thead>
          <tr>
            <th class="noMaterialStyles">
              <small>Todos</small><br>
              <input type="checkbox" ng-click="selectionAll(personalOT, 'add')">
            </th>
            <th>Identificacion</th>
            <th>Nombre de empleados</th>
            <th>OT</th>
            <th>Item</th>
            <th>Cod. cargo</th>
            <th>Cargo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="noMaterialStyles">
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_pOT, 'add')" ng-init="fil_pOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_pOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_pOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </td>
            <td><input type="text" ng-model="fil_pOT.identificacion" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_pOT.nombre_completo" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_pOT.nombre_ot" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_pOT.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_pOT.codigo" placeholder="filtrar"></td>
            <td><input type="text" ng-model="fil_pOT.descripcion" placeholder="filtrar"></td>
          </tr>
          <tr ng-repeat="p in personalOT | filter: fil_pOT | orderBy: 'nombre_completo'">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="p.add" ng-click="setSelecteState(p.add)"> </td>
            <td ng-bind="p.identificacion"></td>
            <td ng-bind="p.nombre_completo"></td>
            <td ng-bind="p.nombre_ot"></td>
            <td ng-bind="p.itemc_item"></td>
            <td ng-bind="p.codigo"></td>
            <td ng-bind="p.descripcion"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
