<section ng-controller="imprimirRD" class="windowCentered2 row font10">
  <h4 ng-init="getRecursos('<?= site_url("export/printSelection/".$idOT."/".$idrepo) ?>')">Selecciona los recursos que deseas imprimir: {{ recursos.nombre_ot }}</h4>
  <hr>

  <div class="noMaterialStyles regularForm">
    <h5>Personal:</h5>
    <table class="mytabla">
      <thead>
        <tr>
          <th rowspan="2"> imprimir</th>
          <th rowspan="2" class="">identificacion</th>
          <th rowspan="2" class="w15">Nombre Completo</th>
          <th rowspan="2" class="">Item</th>
          <th rowspan="2" class="w17 font8">Cargo</th>
          <th rowspan="2" class="">C/L</th>
          <th rowspan="2" class="">B/O/N</th>
          <th rowspan="2" class="">Und.</th>
          <th colspan="2" class="" nowrap="nowrap">Horario</th>
          <th colspan="5" class="">Hr. trabajadas</th>
          <th rowspan="2" class="">Alm</th>
          <th rowspan="2" class="">Rac</th>
          <th colspan="2" class="">G. viaje</th>
        </tr>
        <tr>
          <th class="" nowrap="nowrap">Turno 1</th>
          <th class="" nowrap="nowrap">Turno 2</th>
          <th class="" style="padding:2px;">Día</th>
          <th class="" style="padding:2px;">H.O.</th>
          <th class="" style="padding:2px;">HED</th>
          <th class="" style="padding:2px;">HEN</th>
          <th class="" style="padding:2px;">HRN</th>
          <th>P/R</th>
          <th>Lugar</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="p in recursos.personal" ng-if="p.facturable == '1' ">
          <td> <input type="checkbox" ng-model="p.imprimir"> </td>
  			  <td>{{p.identificacion}}</td>
  			  <td>{{p.nombre_completo}}</td>
  			  <td>{{p.itemc_item}}</td>
  			  <td>{{ ((p.CL == "L")? p.descripcion_item : p.descripcion) }} </td>
  			  <td>{{p.CL}}</td>
  			  <td> {{ (!p.facturable?"N":p.BO) }} </td>
  			  <td>{{ p.unidad }}</td>
          <td>
            <div>{{ p.hora_inicio }}</div>
            <div>{{ (p.hora_fin == 0)?'-':p.hora_fin; }}</div>
          </td>
          <td>
           <div>{{ (p.hora_inicio2 == 0)?'-':p.hora_inicio2; }}</div>
           <div>{{ p.hora_fin2 }}</div>
         </td>
  			  <td>{{ ( (p.cantidad == 0)?'-':p.cantidad*1 ) }}</td>
          <td>{{ ( (p.horas_ordinarias == 0)?'-':p.horas_ordinarias ) }}</td>
  			  <td>{{ ( (p.horas_extra_dia == 0)?'-':p.horas_extra_dia ) }}</td>
  			  <td>{{ ( (p.horas_extra_noc == 0)?'-':p.horas_extra_noc ) }}</td>
  			  <td>{{ ( (p.horas_recargo == 0)?'-':p.horas_recargo ) }}</td>
  			  <td>{{ ( (p.hr_almuerzo>0)?'Sí':'No' ) }}</td>
  			  <td>{{ (p.racion?p.racion:'' ) }}</td>
  			  <td>{{ (p.gasto_viaje_pr?p.gasto_viaje_pr:'') }}</td>
  			  <td class="font8">{{ (p.gasto_viaje_lugar?p.gasto_viaje_lugar:'') }}</td>
        </tr>
      </tbody>
    </table>

    <hr>

    <h5>Equipo</h5>
    <table class="mytabla">
      <thead style="background:#EEE">
        <tr>
          <th rowspan="2">Imprimir</th>
          <th rowspan="2">Item</th>
          <th rowspan="2">Cod. Siesa</th>
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
      </thead>
      <tbody>
          <tr ng-repeat="e in recursos.equipos" ng-if="e.facturable == '1' ">
            <td><input type="checkbox" ng-model="e.imprimir"></td>
            <td>{{ e.itemc_item }}</td>
            <td>{{ e.codigo_siesa }}</td>
            <td>{{ e.referencia }}</td>
            <td>{{ e.descripcion }}</td>
            <td>{{ e.nombre_operador }}</td>
            <td>{{ ( (e.cantidad == 0)?'-':e.cantidad ) }}</td>
            <td>{{ e.unidad }}</td>
            <td>{{ e.horometro_ini }}</td>
            <td>{{ e.horometro_fin }}</td>
            <td>{{ e.horas_operacion }}</td>
            <td>{{ ( (e.horas_disponible == 0)?'-':e.horas_disponible ) }}</td>
            <td>{{ (e.varado?'SI':'' )}}</td>
          </tr>
      </tbody>
    </table>

    <h5>Actividades:</h5>
    <table class="mytabla">
      <thead style="background:#EEE">
        <tr>
          <th>Imprimir</th>
          <th>Codigo</th>
          <th>Actividad</th>
          <th>Unidad</th>
          <th>canditad día</th>
          <th>Cantidad Acumulada</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="a in recursos.actividades" ng-if="a.facturable == '1' ">
          <td> <input type="checkbox" ng-model="a.imprimir"></td>
          <td> {{ a.itemc_item }} </td>
          <td> {{ a.descripcion + ( ( a.idsector_item_tarea!= 1 )?a.nom_sector:'' ) }} </td>
          <td> {{ a.unidad }} </td>
          <td> {{ a.cantidad }} </td>
          <td> {{ a.acumulado+(a.cantidad*1) }} </td>
        </tr>
      </tbody>
    </table>
  </div>


  <div class="btnWindow">
    <button type="button" class="waves-effect waves-light btn mini-btn2" ng-if=" (validPriv(38) || validPriv(45) || validPriv(46) ) "
        ng-click="printSelected('<?= site_url('export/reportePDFSelected'.$idOT."/".$idrepo) ?>')">
      <b data-icon="&#xe015;"></b> Generar
    </button>
    <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow2('#ventanaReporte', '#ventanaReporteOCulta')" data-icon="&#xe036;"> Ocultar</button>
    <button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="cerrarWindowLocal('#ventanaReporte', enlaceGetReporte)" data-icon="n"> Cerrar</button>
  </div>
</section>
