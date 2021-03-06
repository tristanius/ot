<div class="noMaterialStyles" style="max-width:100%; overflow: auto">
  <button type="button" class="btn mini-btn indigo darken-1" ng-click="vista_extendida=!vista_extendida" ng-init="vista_extendida=false">vista extendida actividades</button>
  <table class="mytabla font10" ng-hide="isOnPeticion">
    <thead class="font9">
      <tr style="background: #EEE">
        <th>#</th>
        <th style="background: #F4F9FD ">Fact.</th>
        <!--<th style="max-width:6ex;">Sector</th>-->
        <th>item</th>
        <th>Descripcion</th>
        <th>UND</th>

        <th class="light-blue lighten-5" ng-show="vista_extendida">Ejecc.</th>
        <th class="light-blue lighten-5" ng-show="vista_extendida">A Cargo</th>
        <th class="light-blue lighten-5" ng-show="vista_extendida">Calidad</th>

        <th class="light-blue lighten-5" ng-show="vista_extendida">Abscisa Ini.</th>
        <th class="light-blue lighten-5" ng-show="vista_extendida">Abscisa fin.</th>

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

        <th ng-show="vista_extendida"></th>
        <th ng-show="vista_extendida"></th>
        <th ng-show="vista_extendida"></th>

        <th ng-show="vista_extendida"></th>
        <th ng-show="vista_extendida"></th>

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
            <input type="hidden" ng-init="actividadFilter.idfrente_ot = myfrente" disabled="disabled">
          <?php endif; ?></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="act in rd.recursos.actividades | filter: actividadFilter track by $index" ng-if="act.idfrente_ot == myfrente" class="{{ (!act.idrecurso_reporte_diario && act.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista(rd.recursos.actividades, act, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="act.facturable" ng-init="act.facturable = parseBool(act.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <!--<td style="max-width:6ex;"> <span ng-bind="act.idsector_item_tarea"></span> </td>-->
        <td> <a href="" ng-click="mensaje(act.descripcion)"  ng-bind="act.itemc_item"></a> </td>
        <td> <div ng-bind="act.descripcion" style="max-width: 1000px; max-height: 5ex; overflow: hidden"></div> </td>
        <td ng-bind="act.unidad"></td>

        <!-- AVANCE DE OBRA -->
        <th ng-show="vista_extendida">
          <select class="" ng-model="act.tipo_ejecucion" style="width: 12ex;">
            <option value="">-</option>
            <option value="AVANCE DE OBRA">AVANCE DE OBRA</option>
            <option value="REPROCESO">REPROCESO</option>
            <option value="CONTINGENCIA">CONTINGENCIA</option>
            <option value="SOBREANCHO">SOBREANCHO</option>
          </select>
        </th>
        <th ng-show="vista_extendida">
          <select class="" ng-model="act.a_cargo" style="width: 11ex;">
            <option value="">-</option>
            <option value="PROPIO">PROPIO</option>
            <option value="SUBCONTRATISTA">SUBCONTRATISTA</option>
            <option value="RECLAMACION">RECLAMACION</option>
          </select>
        </th>
        <th ng-show="vista_extendida">
          <select class="" ng-model="act.calidad" style="width: 11ex;">
            <option value="">-</option>
            <option value="SIN PRUEBA">SIN PRUEBA</option>
            <option value="PEMDIENTE">PEMDIENTE</option>
            <option value="SATISFACTORIO">SATISFACTORIO</option>
            <option value="LIBERADO">LIBERADO</option>
            <option value="RECHAZADO">RECHAZADO</option>
            <option value="FACTURADO PEND">FACTURADO PEND.</option>
          </select>
        </th>

        <td ng-show="vista_extendida"> <input type="text" ng-model="act.abscisa_ini" style="width: 8ex;" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td ng-show="vista_extendida"> <input type="text" ng-model="act.abscisa_fin" style="width: 8ex;" ng-readonly="rd.info.estado == 'CERRADO' "> </td>

        <td  class="light-blue lighten-5" ng-show="vista_extendida">
          <select class="" ng-model="act.tipo_instalacion" style="width: 11ex;" ng-disabled="rd.info.estado == 'CERRADO'">
            <option value="N/A">-</option>
            <option value="Box Coulbert">Box Coulbert</option>
            <option value="Instalaciones Hidráulicas">Instalaciones Hidráulicas</option>
            <option value="Obra Civil">Obra Civil</option>
          </select>
        </td>

        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 8ex;" ng-model="act.ubicacion"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida">
          <select class="" style="width: 10ex;" ng-model="act.margen">
            <option value="derecho">derecho</option>
            <option value="central">central</option>
            <option value="izquierdo">izquierdo</option>
          </select>
        </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.MH_inicio"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.MH_fin"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.longitud"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.ancho"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.alto"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.cant_elementos"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.cant_varillas"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.diametro_acero"> </td>
        <td class="blue-text text-darken-2" ng-show="vista_extendida"> <input type="text" style="width: 7ex;" ng-model="act.peso_und"> </td>


        <td class="yellow lighten-4">
          <input type="number" step=0.001 ng-model="act.cantidad" ng-init="act.cantidad = parseNumb(act.cantidad)"  ng-change="act.cantidad = parseNumb(act.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' " style="width: 10ex;">
        </td>
        <td ng-init="act.acumulado?act.acumulado:0;" ng-show="!vista_extendida">
          <span ng-bind="(act.acumulado*1) + (act.cantidad*1) |  number:5"></span>
        </td>
        <td  class="font9">
          <span ng-if="act.item_asociado"> (<span ng-bind="act.item_asociado" style="color: #934B10"></span>)</span>
          <button type="button" class="btn mini-btn2 blue" ng-click="viewAsociarItem(act, '#asociarItem')"
            ng-show="rd.info.estado != 'CERRADO'" data-icon="*">
          </button>
        </td>
    </tbody>
  </table>
</div>
<br>
