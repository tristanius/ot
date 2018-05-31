<section ng-if="factura.fecha_inicio && factura.fecha_fin && factura.recursos.length > 0">

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
          <th><small>Selecc.</small></th>
          <th style="min-width:100px">Orden</th>
          <th>C.O.</th>
          <th style="min-width:100px">Fecha</th>
          <th>Item</th>
          <th>Fact.</th>
          <th style="max-width:300px;">Descripción</th>
          <th style="width:100px;">Tipo</th>
          <th>Tarifa</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>A</th>
          <th>I</th>
          <th>U</th>
          <th>Total</th>
          <th>C.C</th>
          <th>Cod. activo</th>
          <th>Equipo</th>
          <th>Del.</th>
        </tr>
        <tr class="noMaterialStyles regularForm">
          <th><input type="checkbox" ng-model="allitems" ng-click="modSeletionState(orden.recursos, allitems)"></th>
          <th> <input class="inputMedium" type="text" placeholder="Filtro" ng-model="filtroItems.nombre_ot" ng-change="changeSelectFac('filtroItems')"> </th>
          <th> <input class="inputMedium" type="text" placeholder="Filtro" ng-model="filtroItems.base_idbase" ng-change="changeSelectFac('filtroItems')"> </th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.fecha_reporte" ng-change="changeSelectFac('filtroItems')"> </th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.itemc_item" ng-change="changeSelectFac('filtroItems')"> </th>
          <th></th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.descripcion" ng-change="changeSelectFac('filtroItems')"> </th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.identificacion" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputSmall" type="text" placeholder="Filtro" ng-model="filtroItems.codigo_siesa" ng-change="changeSelectFac('filtroItems')"></th>
          <th> <input class="inputMedium" type="text" placeholder="Filtro" ng-model="filtroItems.dec_equipo" ng-change="changeSelectFac('filtroItems')"></th>
          <th> </th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="rrd in filteredRecursos = (factura.recursos | filter: filtroItems) | startFrom:currentPage*pageSize | limitTo:pageSize">
          <td class="noMaterialStyles regularForm">
            <input type="checkbox" ng-model="rrd.isSelected" init="rrd.isSelected = false">
          </td>
          <td> <span ng-bind="rrd.nombre_ot"></span> </td>
          <td> <span ng-bind="rrd.base_idbase"></span> </td>
          <td> <span ng-bind="rrd.fecha_reporte"></span> </td>
          <td> <span ng-bind="rrd.itemc_item"></span> </td>
          <td> <span ng-bind="rrd.facturable"></span> </td>
          <td> <span ng-bind="rrd.descripcion" style="width:300px;"></span> </td>
          <td> <span ng-bind="rrd.clasificacion"></span> </td>
          <td> <span ng-bind="rrd.tarifa | currency"></span> </td>
          <td style="background: #DCE8C0; text-align:right"><span ng-bind="rrd.cantidad"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.subtotal | currency" ng-init="rrd.subtotal = (rrd.tarifa*rrd.cantidad)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.a | currency" ng-init="rrd.a = (rrd.subtotal*0.18)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.i | currency" ng-init="rrd.i = (rrd.subtotal*0.01)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.u | currency" ng-init="rrd.u = (rrd.subtotal*0.04)"></span> </td>
          <td style="background: #DCE8C0; text-align:right"> <span ng-bind="rrd.total | currency" ng-init="rrd.total = (rrd.total?rrd.total:(rrd.subtotal + rrd.a + rrd.i + rrd.u))"></span> </td>
          <td> <small ng-bind="rrd.identificacion"></small> </td>
          <td> <small ng-bind="rrd.codigo_siesa"></small> </td>
          <td> <small ng-bind="rrd.descripcion_equipo"></small> </td>
          <td><button type="button" class="btn red mini-btn2" style="margin-top: 0px" ng-click="deleteElementFactura(orden.recursos, rrd, 'recurso')" >x</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="noMaterialStyles regularForm">
    <button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
      Anterior
    </button>
    {{currentPage+1}}/{{numberOfPages(factura)}}
    <button ng-disabled="currentPage >= filteredRecursos.length/pageSize - 1" ng-click="currentPage=currentPage+1">
      Siguiente
    </button>
    &nbsp;
    Ir a: <input type="number" max="numberOfPages" ng-model="pgNum" ng-change="currentPage = (pgNum-1 > 0)?(pgNum-1):0">
  </div>
</section>


<div ng-if="!factura.fecha_inicio || !factura.fecha_fin">
  <p style="color:red">Hola, debes seleccionar fechas de inicio y final de factura para obtener los recursos de produccion dentro de un rango de fechas del contrato.</p>
</div>

<div ng-if="(factura.fecha_inicio && factura.fecha_fin) && (!factura.recursos || factura.recursos.length == 0)">
  <button type="button" class="btn" ng-click="getRecursos('<?= site_url('factura/get_recursos')  ?>')">Obtener recursos</button>
</div>
