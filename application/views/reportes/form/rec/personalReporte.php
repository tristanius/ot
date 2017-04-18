<div class="noMaterialStyles" ng-init='listStatus = <?= json_encode($estados_labor) ?>'>
  <table class="mytabla" ng-hide="isOnPeticion">
    <thead>
      <tr style="background: #EEE">
        <th></th>
        <th></th>
        <th>Item</th>
        <th style="max-width: 14ex">Cédula</th>
        <th>Nombre Completo</th>
        <th>Cargo</th>
        <th style="max-width: 7ex">Estado <br> Trabajador</th>

        <th style="background: #F4F9FD ">Fact.</th>
        <th><small>Impr.</small></th>
        <th colspan="2" style="max-width: 12ex">Turnos</th>
        <th style="max-width: 7ex">Día</th>
        <th style="max-width: 6ex; background: #C5F5F9">H. Ord</th>
        <th style="max-width: 7ex">Rec. N.</th>
        <th style="max-width: 6ex">H.E.D.</th>
        <th style="max-width: 6ex">H.E.N.</th>
        <th>Ración</th>
        <th>Hr. <br> Almuer.</th>
        <th colspan="2">G. Viaje</th>
      </tr>
    </thead>
    <tbody>
      <tr style="background: #EEE">
        <td></td>
        <td>No.</td>
        <!-- <td>
          <input type="text"
              ng-model="personalFilter.indice"
              ng-change="verificadorNumericoFilter(personalFilter, 'indice',1)"
              style="width:2em">
        </td> -->

        <td> <input ng-model="personalFilter.itemc_item" style="width:6ex;"> </td>
        <td ><input style="max-width: 11ex" type="text" ng-model="personalFilter.identificacion"></td>
        <td><input type="text" style="max-width: 16ex" ng-model="personalFilter.nombre_completo"></td>
        <td><input type="text" style="max-width: 16ex" ng-model="personalFilter.descripcion"></td>
        <td style="max-width: 7ex"></td>

        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox"
              ng-click="changeFilterSelect2(personalFilter, 'facturable')" ng-init="personalFilter.facturable = undefined">
        </td>
        <td></td>

        <td class="red lighten-4 inputsSmall" style="text-align:center">Turno 1</td>
        <td class="red lighten-4 inputsSmall" style="text-align:center">Turno 2</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td> <!-- HO.-->

        <td></td>
        <td></td>
        <td>R/P</td>
        <td>Lugar</td>
      </tr>
      <tr ng-repeat="pr in rd.recursos.personal | orderBy: 'itemc_item' | filter: personalFilter track by $index" class="{{ (pr.idrecurso_reporte_diario == undefined || pr.idrecurso_reporte_diario == '')?'newrow':''; }}"> <!--  | orderBy: 'itemc_item' -->
        <td ng-init="pr.nomina = parseBool(pr.nomina)">
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista( rd.recursos.personal, pr, '<?= site_url('reporte/eliminarRecursosReporte/'); ?>', 'idrecurso_reporte_diario')" ng-show="rd.info.estado != 'CERRADO' "> x </button>
        </td>
        <td>
            <span ng-bind="pr.ind" ng-init="pr.ind = ($index+1)"></span>
        </td>
        <!-- <td ng-click="cambiarValorObjeto(pr,'clase','green lighten-5')" ng-bind="pr.indice" ng-init="pr.indice = ($index + 1)"></td> -->

        <td>
          <div class="valign-wrapper">
            <span ng-if="pr.valid != undefined && !pr.valid" class="valign red-text text-darken-2" ng-click="mensaje(pr.msj)"  style="font-size:3ex" data-icon="f"></span>
            <span ng-if="pr.valid != undefined && pr.valid && pr.msj != '' " class="valign orange accent-1" ng-click="mensaje(pr.msj)" style="font-size:2ex" data-icon="&#xe03d;"></span>
            <a href="#" ng-bind="pr.itemc_item" class="valign text-" ng-click="mensaje( pr.itemf_codigo+' '+pr.descripcion+' ')"></a>
          </div>
        </td>

        <td ng-click="cambiarValorObjeto(pr,'clase','green lighten-5')"  style="max-width: 14ex"> <b ng-bind="pr.identificacion"></b> </td>
        <td style="max-width: 25ex" ng-click="cambiarValorObjeto(pr,'clase','green lighten-5')"> <b ng-bind="pr.nombre_completo"></b> </td>
        <td style="max-width: 25ex"> <span ng-bind="pr.descripcion"></span> </td>
        <td class="regularForm">
          <select style="max-width: 10ex" ng-model="pr.idestado_labor" ng-model="pr.idestado_labor = (''+pr.idestado_labor)" ng-change="getStatusLaboral(pr.idestado_labor, pr)" ng-disabled="(rd.info.estado == 'CERRADO') || pr.nomina">
            <option ng-repeat="st in listStatus" value="{{st.idestado_labor}}">{{st.descripcion_estado_labor}}</option>
          </select>
        </td>

        <td class="noMaterialStyles" style="background: #F4F9FD ">
          <input type="checkbox" ng-model="pr.facturable" ng-init="pr.facturable = parseBool(pr.facturable)" ng-change="pr.facturable = parseBool(pr.facturable)" ng-disabled="rd.info.estado == 'CERRADO' " />
        </td>

        <td class="noMaterialStyles">
          <input type="checkbox" ng-model="pr.print" ng-init="pr.print = parseBool(pr.print)" ng-readonly="rd.info.estado == 'CERRADO' " />
        </td>

        <td>
          <table>
            <tr style="border:none;">
              <td class="inputsSmall" style="border:none;">
                <input ng-model="pr.hora_inicio" type="text" style="width:6ex; height: 1.5ex;" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina" placeholder="Hora Ini" required  />
              </td>
            </tr>
            <tr style="border:none;">
              <td class="inputsSmall" style="border:none;">
                <input ng-model="pr.hora_fin" type="text" style="width:6ex; height: 1.5ex;" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina" placeholder="Hora Fin" required  />
              </td>
            </tr>
          </table>
        </td>

        <td>
          <table>
            <tr style="border:none;">
              <td class="inputsSmall" style="border:none;">
                <input ng-model="pr.hora_inicio2" type="text" style="width:6ex; height: 1.5ex;" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina" placeholder="Hora Ini" required  />
              </td>
            </tr>
            <tr style="border:none;">
              <td class="inputsSmall" style="border:none;">
                <input ng-model="pr.hora_fin2" type="text" style="width:6ex; height: 1.5ex;" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina" placeholder="Hora Fin" required  />
              </td>
            </tr>
          </table>
        </td>

        <td class="inputsSmall">
          <div class="">
            <input type="number" min=0 style="border: green 1px solid; width:5ex;" ng-model="pr.cantidad" ng-init="pr.cantidad = parseNumb(pr.cantidad)" ng-readonly="rd.info.estado == 'CERRADO' "  min=0 max=1>
          </div>
        </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_ordinarias" ng-init="pr.horas_ordinarias = parseNumb(pr.horas_ordinarias)" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina"> </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_recargo" ng-init="pr.horas_recargo = parseNumb(pr.horas_recargo)" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina"> </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_extra_dia" ng-init="pr.horas_extra_dia = parseNumb(pr.horas_extra_dia)" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina"> </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_extra_noc" ng-init="pr.horas_extra_noc = parseNumb(pr.horas_extra_noc)" ng-readonly="(rd.info.estado == 'CERRADO') || pr.nomina"> </td>
        <td>
          <select class="" ng-model="pr.racion" ng-disabled="rd.info.estado == 'CERRADO' ">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </td>
        <td> <input type="checkbox" ng-model="pr.hr_almuerzo" ng-init="pr.hr_almuerzo = parseBool(pr.hr_almuerzo)" ng-disabled="rd.info.estado == 'CERRADO' "> </td>
        <td> <input type="text" style="width:5ex" ng-model="pr.gasto_viaje_pr" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
        <td> <input type="text" style="width:8ex" ng-model="pr.gasto_viaje_lugar" ng-readonly="rd.info.estado == 'CERRADO' "> </td>
      </tr>
    </tbody>
  </table>
</div>

<br>
