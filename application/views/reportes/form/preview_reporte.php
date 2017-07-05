<section id="preview_reporte">

  <div class="noMaterialStyles regularForm">
    <h5>Personal:</h5>
    <table class="mytabla font10">
      <thead>
        <tr>
          <th rowspan="2" class="">identificacion</th>
          <th rowspan="2" class="w15" style="min-width:40%">Nombre Completo</th>
          <th rowspan="2" class="">Item</th>
          <th rowspan="2" class="w17 font8" style="min-width:30%">Cargo</th>
          <th rowspan="2" class="">C/L</th>
          <th rowspan="2" class="">B/O</th>
          <th rowspan="2" class="">Facturable</th>
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
        <tr ng-repeat="p in rd.recursos.personal" ng-if="p.facturable || p.print"> <!-- ng-if="p.facturable == '1' " -->
  			  <td>{{p.identificacion}}</td>
  			  <td style="min-width:30%">{{p.nombre_completo}}</td>
  			  <td>{{p.itemc_item}}</td>
  			  <td style="min-width:30%">{{ ((p.CL == "L")? p.descripcion_item : p.descripcion) }} </td>
  			  <td>{{p.CL}}</td>
  			  <td>{{ p.BO }} </td>
          <td style='background:#F4FBFC'>{{ p.facturable?"SI":"NO" }} </td>
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
    <table class="mytabla font10">
      <thead style="background:#EEE">
        <tr>
          <th rowspan="2">Item</th>
          <th rowspan="2">Fact.</th>
          <th rowspan="2">Cod. Siesa</th>
          <th rowspan="2">Ref./AF</th>
          <th rowspan="2">Facturable</th>
          <th rowspan="2">Equipo</th>
          <th rowspan="2">Operador / Conductor</th>
          <th rowspan="2">Cant.</th>
          <th rowspan="2">UND</th>
          <th colspan="2">Horometro / <br> Kilometraje</th>
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
          <tr ng-repeat="e in rd.recursos.equipos" > <!-- ng-if="e.facturable == '1' " -->
            <td>{{ e.itemc_item }}</td>
            <td>{{ e.facturable?"SI":"NO" }}</td>
            <td>{{ e.codigo_siesa }}</td>
            <td>{{ e.referencia }}</td>
            <td>{{ e.facturable?"SI":"NO" }}</td>
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
    <table class="mytabla font10">
      <thead style="background:#EEE">
        <tr>
          <th>Codigo</th>
          <th>Actividad</th>
          <th>Unidad</th>
          <th>Fact.</th>
          <th>canditad día</th>
          <th>Cantidad Acumulada</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="a in rd.recursos.actividades"> <!-- ng-if="a.facturable == '1' " -->
          <td> {{ a.itemc_item }} </td>
          <td> {{ a.descripcion + ( ( a.idsector_item_tarea!= 1 )?a.nom_sector:'' ) }} </td>
          <td> {{ a.unidad }} </td>
          <td> {{ a.facturable?"SI":"NO" }}</td>
          <td> {{ a.cantidad }} </td>
          <td> {{ a.acumulado+(a.cantidad*1) }} </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="">
    <style>
      table#observaciones td{
        padding: 5px;
      }
    </style>
    <br>
    <table id="observaciones" class="mytabla font10 nocenter noMaterialStyles" style="border-collapse:collapse;">
      <thead style="background:#EEE;">
        <tr>
          <th>Observaciones del contratista:</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="obs in rd.info.observaciones">
          <td> <div ng-bind="obs.msj"></div> </td>
        </tr>
      </tbody>
    </table>
    <br>
    <table class="font10 nocenter" cellpadding="0" cellspacing="0" border="1">
      <thead style="background:#EEE">
        <tr>
          <th> Elaborado por </th>
          <th> Representante del contratista</th>
          <th> Representante del cliente</th>
        </tr>
      </thead>
      <tbody class="">
        <tr>
          <td>Nombre: <span ng-bind="rd.info.elaborador_nombre"></span> </td>
          <td>Nombre: <span ng-bind="rd.info.contratista_nombre"></span> </td>
          <td>Nombre: <span ng-bind="rd.info.ecopetrol_nombre"></span> </td>
        </tr>
        <tr>
          <td>Cargo: <span ng-bind="rd.info.elaborador_cargo"></span> </td>
          <td>Cargo: <span ng-bind="rd.info.contratista_cargo"></span> </td>
          <td>Cargo: <span ng-bind="rd.info.ecopetrol_cargo"></span> </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
