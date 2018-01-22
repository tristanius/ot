<div class="noMaterialStyles" style="overflow:auto"> <!-- max-height:400px;  -->
  <table id="equiposReporte" class="mytabla font10" ng-hide="isOnPeticion"><!-- class: sticked -->
    <thead id="thead2" style="background: #EEE; box-shadow:0px 0px 4px #333;">
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan="2">Horometro / <br> kilometraje</th>
        <th colspan="3">Reporte horas</th>
        <th></th>
      </tr>
      <tr class="background:#EEE; color:#EEE;">
        <th>#</th>
        <th>Item</th>
        <th style="background: #F4F9FD ">Fact.</th>
        <th data-icon="x"></th>
        <th>Codigo</th>
        <th>Ref./AF</th>
        <th>Equipo</th>
        <th>Operador / Conductor</th>
        <th>Base</th>

        <th>Cant.</th>
        <th>UND</th>
        <th>Inicial</th>
        <th>Final</th>
        <th>OPER.</th>
        <th>DISP.</th>
        <th>VAR.</th>
        <th><></th>
      </tr>
    </thead>
    <tbody>

      <tr style="background: #b9dae5">
        <td></td>
        <td> <input style="width: 4ex" type="text" ng-model="equipoFilter.itemc_item"> </td>
        <td></td>
        <td></td>
        <td> <input style="width: 7ex" type="text" ng-model="equipoFilter.codigo_siesa"> </td>
        <td> <input style="width: 8ex" type="text" ng-model="equipoFilter.referencia"> </td>
        <td> <input style="width: 8ex" type="text" ng-model="equipoFilter.descripcion_equipo"> </td>
        <td> <input style="width: 13ex" type="text" ng-model="equipoFilter.nombre_operador"> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <?php if (isset($frentes) && sizeof($frentes) > 0 ): ?>
            <input type="hidden" ng-init="equipoFilter.idfrente_ot = myfrente" disabled="disabled">
          <?php endif; ?>
        </td>
        <td></td>
      </tr>

      <tr ng-repeat="eq in rd.recursos.equipos | orderBy: 'itemc_item' | filter: equipoFilter track by $index"  class="{{ (eq.idrecurso_reporte_diario == undefined || eq.idrecurso_reporte_diario == '')?'newrow':''; }}">
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
        <td class="noMaterialStyles"> <input type="text" ng-model="eq.procedencia" style="border: green 1px solid; width:9ex;"> </td>

        <td class="inputSmall"> <input type="number" min=0 ng-model="eq.cantidad" step=any ng-init="eq.cantidad = parseNumb(eq.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputSmall"> <input type="text" ng-model="eq.unidad" ng-readonly="rd.info.estado == 'CERRADO' "> </td>

        <td class="inputSmall"> <input type="text" ng-model="eq.horometro_ini" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputSmall"> <input type="text" ng-model="eq.horometro_fin" ng-readonly="rd.info.estado == 'CERRADO' "> </td>

        <td class="inputSmall"> <input style="border: green 1px solid; " type="number" min=0 ng-model="eq.horas_operacion" ng-init="eq.horas_operacion = parseNumb(eq.horas_operacion)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputSmall"> <input style="border: green 1px solid; " type="number" min=0 ng-model="eq.horas_disponible" ng-init="eq.horas_disponible = parseNumb(eq.horas_disponible)" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td class="inputSmall noMaterialStyles"> <input type="checkbox" ng-model="eq.varado" ng-init="eq.varado = parseBool(eq.varado)" ng-disabled="rd.info.estado == 'CERRADO' "> </td>

        <td class="font9">
          <span ng-if="eq.item_asociado">  (<span ng-bind="eq.item_asociado" style="color: #934B10"></span>)</span>
          <button type="button" class="btn mini-btn2 blue" ng-click="viewAsociarItem(eq, '#asociarItem')"
            ng-show="rd.info.estado != 'CERRADO' "> <>
          </button>
        </td>
      </tr>
      <tr id="thead1" style="background:#EEE; color:#EEE;">
        <th></th>
        <th>Item</th>
        <th>Fact.</th>
        <th>Impr.</th>
        <th>Codigo</th>
        <th>Ref./AF</th>
        <th>Equipo</th>
        <th>Operador / Conductor</th>
        <th>Base</th>

        <th>Cant.</th>
        <th>UND</th>
        <th>Inicial</th>
        <th>Final</th>
        <th>OPER.</th>
        <th>DISP.</th>
        <th>VAR.</th>
        <th><></th>
      </tr>
    </tbody>
  </table>
</div>

<br>
