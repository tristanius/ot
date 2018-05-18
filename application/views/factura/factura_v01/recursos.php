<section>
  <div style="border: 1px solid #333; padding:1ex" class="noMaterialStyles regularForm row">
    <div class="col s12 m6 l2">
      <b>C.O.</b>
      <select class="" ng-model="filtro_CO" ng-options="b for b in fac.bases | orderBy:b"  ng-change="changeSelectFac('base')">
      </select>
    </div>

    <div class="col s12 m6 l5">
      <b>Orden:</b>
      <select ng-model="orden" ng-options="ot.No_OT for ot in fac.ordenes  | filter:{CO:filtro_CO}" ng-change="changeSelectFac('orden')">
        <!-- <option ng-repeat="ot in fac.ordenes | filter: filtro" value="{{ ot.idOT}}"> {{ ot.No_OT+' - '+ot.CO }} </option> -->
      </select>
      &nbsp;&nbsp;
      &nbsp;&nbsp;
      <?php if (!$isMod): ?>
        <button type="button" class="btn red mini-btn" style="margin-top: 0px" ng-click="deleteElementFactura(fac.ordenes, orden, 'orden')" >X</button>
      <?php endif; ?>
    </div>
  </div>

  <style media="screen">
    table#tablaRecursos tr td span{
      height:26px;
      max-height: 26px;
      overflow: hidden;
      display:block;
    }
  </style>
  <div style="overflow:scroll; width: 100%; height: 530px; border: 1px solid #333">
    <?php if ($isMod){
      $this->load->view('factura/factura/form_selec_estado');
    } ?>
    <table id="tablaRecursos" class="mytabla font10" style="min-width:1270px; max-width:2500px;">
      <thead>
        <tr>
          <th><small>Check</small></th>
          <th style="min-width:100px">Orden</th>
          <th style="min-width:100px">Fecha reporte</th>
          <th>Item</th>
          <th>Fact.</th>
          <th style="max-width:300px;">Descripcion</th>
          <th style="width:100px;">Tipo</th>
          <th>Cant. und</th>
          <th>Tarifa</th>
          <th>Cant. factura</th>
          <th>Valor recurso</th>
          <th>A</th>
          <th>I</th>
          <th>U</th>
          <th>Total</th>
          <th>C.C</th>
          <th>Nombre</th>
          <th>Activo</th>
          <th>Equipo</th>
          <th>Estado</th>
          <th>Acta</th>
          <th>Del.</th>
        </tr>
        <tr class="noMaterialStyles regularForm">
          <th>Todo: <input type="checkbox" ng-model="allitems" ng-click="modSeletionState(orden.recursos, allitems)"></th>
          <th> <input class="inputMedium" type="text" placeholder="Filtro" ng-model="filtroItems.nombre_ot" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.fecha_reporte" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.item" ng-change="changeSelectFac('filtroItems')"></th>
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
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.identificacion" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputMedium" type="text" placeholder="Filtro" ng-model="filtroItems.nombre_completo" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.codigo_siesa" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputMedium" type="text" placeholder="Filtro" ng-model="filtroItems.dec_equipo" ng-change="changeSelectFac('filtroItems')"></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="rrd in orden.recursos | filter: filtroItems | startFrom:currentPage*pageSize | limitTo:pageSize">
          <td class="noMaterialStyles regularForm">
            <input type="checkbox" ng-model="rrd.isSelected" init="rrd.isSelected = false">
          </td>
          <td> <span ng-bind="rrd.nombre_ot"></span> </td>
          <td> <span ng-bind="rrd.fecha_reporte"></span> </td>
          <td> <span ng-bind="rrd.item"></span> </td>
          <td> <span ng-bind="rrd.facturable"></span> </td>
          <td> <span ng-bind="rrd.descripcion" style="width:300px;"></span> </td>
          <td> <span ng-bind="rrd.clasificacion"></span> </td>
          <td> <span ng-bind="rrd.cant_und"></span> </td>
          <td> <span ng-bind="rrd.tarifa | currency"></span> </td>
          <td style="background: #DCE8C0; text-align:right"><span ng-bind="rrd.cantidad_total" ng-init="rrd.cantidad_total = calcularCantidad(rrd)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.valor_total | currency" ng-init="rrd.valor_total = (rrd.tarifa*rrd.cantidad_total)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.a | currency" ng-init="rrd.a = (rrd.valor_total*0.18)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.i | currency" ng-init="rrd.i = (rrd.valor_total*0.01)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.u | currency" ng-init="rrd.u = (rrd.valor_total*0.04)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.total | currency" ng-init=""></span> </td>
          <td> <span ng-bind="rrd.identificacion"></span> </td>
          <td> <span ng-bind="rrd.nombre_completo"></span> </td>
          <td> <span ng-bind="rrd.codigo_siesa"></span> </td>
          <td> <span ng-bind="rrd.dec_equipo"></span> </td>
          <td> <span ng-bind="rrd.estado"></span> </td>
          <td> <span ng-bind="rrd.acta"></span> </td>
          <td><button type="button" class="btn red mini-btn2" style="margin-top: 0px" ng-click="deleteElementFactura(orden.recursos, rrd, 'recurso')" >x</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="noMaterialStyles regularForm">
    <button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
      Anterior
    </button>
    {{currentPage+1}}/{{numberOfPages()}}
    <button ng-disabled="currentPage >= orden.recursos.length/pageSize - 1" ng-click="currentPage=currentPage+1">
      Siguiente
    </button>
    &nbsp;
    Ir a: <input type="number" max="numberOfPages" ng-model="pgNum" ng-change="currentPage = (pgNum-1 > 0)?(pgNum-1):0">
  </div>
</section>
