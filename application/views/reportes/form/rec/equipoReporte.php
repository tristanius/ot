<div class="noMaterialStyles">
  <table class="mytabla" ng-hide="isOnPeticion">
    <thead style="background: #EEE">
      <tr>
        <th rowspan="2"></th>
        <th rowspan="2">Item</th>
        <th rowspan="2" style="background: #F4F9FD ">Fact.</th>
        <th rowspan="2">Impr.</th>
        <th rowspan="2">Codigo</th>
        <th rowspan="2">Ref./AF</th>
        <th rowspan="2">Equipo</th>
        <th rowspan="2">Operador / Conductor</th>
        <th rowspan="2">Cant.</th>
        <th rowspan="2">UND</th>
        <th colspan="2">Horometro</th>
        <th colspan="3">Reporte horas</th>
      </tr>
      <tr>
        <th>Inicial</th>
        <th>Final</th>

        <th>OPER.</th>
        <th>DISP.</th>
        <th>VAR.</th>
      </tr>

      <tr>
        <th></th>
        <th> <input style="width: 6ex" type="text" ng-model="filterEquipos.itemc_item"> </th>
        <th></th>
        <th></th>
        <th> <input style="width: 7ex" type="text" ng-model="filterEquipos.codigo_siesa"> </th>
        <th> <input style="width: 8ex" type="text" ng-model="filterEquipos.referencia"> </th>
        <th> <input style="width: 8ex" type="text" ng-model="filterEquipos.descripcion_equipo"> </th>
        <th> <input style="width: 8ex" type="text" ng-model="filterEquipos.nombre_operador"> </th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
      </tr>
    </thead>
    <tbody>

      <tr ng-repeat="eq in rd.recursos.equipos | orderBy: 'itemc_item' | filter: filterEquipos track by $index"  class="{{ (eq.idrecurso_reporte_diario == undefined || eq.idrecurso_reporte_diario == '')?'newrow':''; }}">
        <td>
          <span ng-bind="eq.ind" ng-init="eq.ind = $index+1"></span>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista( rd.recursos.equipos, eq, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>','idrecurso_reporte_diario')"
            ng-show="rd.info.estado != 'CERRADO' "> x
          </button>
        </td>

        <td>
          <div  class="valign-wrapper" >
            <span ng-if="eq.valid != undefined && !eq.valid" class="valign red-text text-darken-2" ng-click="mensaje(eq.msj)" style="font-size:3ex" data-icon="f"></span>
            <span ng-if="eq.valid != undefined && eq.valid && eq.msj != ''" class="valign orange accent-1" ng-click="mensaje(eq.msj)" style="font-size:2ex" data-icon="&#xe03d;"></span>
            <a ng-bind="eq.itemc_item" class="valign" ng-click="mensaje(eq.descripcion)" href="#" />
          </div>
        </td>

        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="eq.facturable" ng-init="eq.facturable = parseBool(eq.facturable) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>
        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="eq.print" ng-init="eq.print = parseBool(eq.print) " ng-disabled="rd.info.estado == 'CERRADO' ">
        </td>

        <td ng-bind="eq.codigo_siesa"></td>
        <td ng-bind="eq.referencia"></td>
        <td ng-bind="eq.descripcion_equipo"></td>
        <td> <input type="text" style="width:90%" ng-model="eq.nombre_operador" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputsSmall"> <input type="number" min=0 ng-model="eq.cantidad" step=any ng-init="eq.cantidad = parseNumb(eq.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputsSmall"> <input type="text" ng-model="eq.unidad" ng-readonly="rd.info.estado == 'CERRADO' "> </td>

        <td class="inputsSmall"> <input type="text" ng-model="eq.horometro_ini" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputsSmall"> <input type="text" ng-model="eq.horometro_fin" ng-readonly="rd.info.estado == 'CERRADO' "> </td>

        <td class="inputsSmall"> <input style="border: green 1px solid; " type="number" min=0 ng-model="eq.horas_operacion" ng-init="eq.horas_operacion = parseNumb(eq.horas_operacion)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputsSmall"> <input style="border: green 1px solid; " type="number" min=0 ng-model="eq.horas_disponible" ng-init="eq.horas_disponible = parseNumb(eq.horas_disponible)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputsSmall noMaterialStyles"> <input type="checkbox" ng-model="eq.varado" ng-init="eq.varado = parseBool(eq.varado)" ng-disabled="rd.info.estado == 'CERRADO' "> </td>
      </tr>
    </tbody>
  </table>
</div>

<br>
