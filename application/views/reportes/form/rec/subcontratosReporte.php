<div class="noMaterialStyles" style="max-width:100%; overflow: auto">
  <button type="button" class="btn mini-btn indigo darken-1" ng-click="vista_extendida=!vista_extendida" ng-init="vista_extendida=false">vista extendida act. Subcontrato</button>
  <table class="mytabla font10" ng-hide="isOnPeticion">
    <thead>
      <tr style="background: #EEE">
        <th>#</th>
        <th style="background: #F4F9FD ">Fact.</th>
        <!--<th style="max-width:6ex;">Sector</th>-->
        <th>item</th>
        <th>Descripcion</th>
        <th>UND</th>
        <th>Abscisa Ini.</th>
        <th>Abscisa fin.</th>

        <th class="light-blue lighten-5" ng-show="vista_extendida">Tipo instal.</th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Ubicacion </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Margen </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> MH ini </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> MH fin </small> </th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Longitud </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Ancho </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Alto </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> # Elmentos </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> # Varillas </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Diametro </small></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"><small> Peso Unit. </small></th>


        <th class="yellow lighten-4">Cant. item</th>
        <th ng-show="!vista_extendida">Acumulado</th>
        <th data-icon="*"> </th>
      </tr>
      <tr style="background: #b9dae5">
        <th></th>
        <th></th>
        <!--<th></th>-->
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>

        <th class="light-blue lighten-5" ng-show="vista_extendida"></th> <!-- tipo instalacion -->
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"> </th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>
        <th class="light-blue lighten-5" ng-show="vista_extendida"></th>

        <th class="yellow lighten-4"></th>
        <th ng-show="!vista_extendida"></th>
        <th>
          <?php if (isset($frentes) && sizeof($frentes) > 0 ): ?>
            <input type="hidden" ng-init="sbcFilter.idfrente_ot = myfrente" disabled="disabled">
          <?php endif; ?></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="sbc in rd.recursos.subcontratos | filter: sbcFilter track by $index" ng-if="sbc.idfrente_ot == myfrente" class="{{ (!sbc.idrecurso_reporte_diario && sbc.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista(rd.recursos.subcontratos, act, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="sbc.facturable" ng-init="sbc.facturable = parseBool(sbc.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <!--<td style="max-width:6ex;"> <span ng-bind="sbc.idsector_item_tarea"></span> </td>-->
        <td ng-bind="sbc.itemc_item">
        </td>
        <td ng-bind="sbc.descripcion" style="min-width: 200px;"></td>
        <td ng-bind="sbc.unidad"></td>
        <td> <input type="text" ng-model="sbc.abscisa_ini" value="" style="width: 8ex;" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td> <input type="text" ng-model="sbc.abscisa_fin" value="" style="width: 8ex;" ng-readonly="rd.info.estado == 'CERRADO' "> </td>

        <!-- AVANCE DE OBRA -->
        <td  class="light-blue lighten-5" ng-show="vista_extendida">
          <select class="" ng-model="sbc.tipo_instalacion" style="width: 12ex;" ng-disabled="rd.info.estado == 'CERRADO'">
            <option value="N/A">N/A</option>
            <option value="Box Coulbert">Box Coulbert</option>
            <option value="Instalaciones Hidráulicas">Instalaciones Hidráulicas</option>
            <option value="Obra Civil">Obra Civil</option>
          </select>
        </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.ubicacion"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida">
          <select class="" style="width: 10ex;" ng-model="sbc.margen">
            <option value="derecho">derecho</option>
            <option value="central">central</option>
            <option value="izquierdo">izquierdo</option>
          </select>
        </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.MH_inicio"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.MH_fin"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.longitud"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.ancho"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.alto"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.cant_elementos"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.cant_varillas"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.diametro_acero"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="sbc.peso_und"> </td>


        <td class="yellow lighten-4">
          <input type="number" min=0 step=0.001 ng-model="sbc.cantidad" ng-init="sbc.cantidad = parseNumb(sbc.cantidad)"  ng-change="sbc.cantidad = parseNumb(sbc.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' " style="width: 10ex;">
        </td>
        <td ng-init="sbc.acumulado?sbc.acumulado:0;" ng-show="!vista_extendida">
          <span ng-bind="(sbc.acumulado*1) + (sbc.cantidad*1) |  number:5"></span>
        </td>
        <td  class="font9">
          <span ng-if="sbc.item_asociado"> (<span ng-bind="sbc.item_asociado" style="color: #934B10"></span>)</span>
          <button type="button" class="btn mini-btn2 blue" ng-click="viewAsociarItem(act, '#asociarItem')"
            ng-show="rd.info.estado != 'CERRADO'" data-icon="*">
          </button>
        </td>
    </tbody>
  </table>
</div>
<br>