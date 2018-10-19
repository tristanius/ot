    <tr>
      <th colspan="11" rowspan="" style="background:#ddedd0">EQUIPOS: <a ng-href="<?= site_url('export/formatoEquiposTareaOT') ?>/{{ tr.idtarea_ot }}" class="btn mini-btn2" data-icon="&#xe030;"></a></th>
    </tr>
    <tr ng-repeat="eq in tr.equipos | orderBy: 'codigo'">
      <td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+eq.codigo)"></span> <span ng-bind="eq.item"></span> </td>
      <td><small ng-bind="eq.codigo"></small></td>
      <td ng-bind="eq.descripcion"></td>
      <th style="display:none">
        <select class="font9" style="width:60px;" ng-model="eq.idsector_item_tarea" ng-init="eq.idsector_item_tarea = (''+eq.idsector_item_tarea)" disabled>
          <?php foreach ($sectores->result() as $key => $value): ?>
            <option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
          <?php endforeach; ?>
        </select>
      </th>
      <td class="noMaterialStyles"> <input type="checkbox" ng-model="eq.facturable" ng-init="eq.facturable = toboolean(eq.facturable)"> </td>
      <td ng-bind="eq.unidad"></td>
      <td> <input type="number" style="border: 1px solid #E65100; width:7ex" step=any ng-model="eq.cantidad" ng-init="eq.cantidad = strtonum(eq.cantidad)" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
      <td> <input type="number" style="border: 1px solid #E65100; width:7ex" step=any ng-model="eq.duracion" ng-init="eq.duracion = strtonum(eq.duracion)"  ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
      <td style="text-align: right" ng-bind="eq.tarifa | currency:'$':0"></td>

      <td style="display:none">
        <input type="text" ng-model="eq.subtarifa" style="max-width:10ex;"  ng-init="eq.subtarifa = eq.subtarifa?eq.subtarifa:eq.tarifa">
      </td>

      <td style="text-align: right">
        {{ ( eq.facturable?(eq.cantidad * eq.duracion)*eq.tarifa:0 ) | currency:'$':0 }}
        <button ng-show=" ( eq.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.equipos, eq, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
      </td>
      <td>
        <select ng-model="eq.idfrente_ot" ng-options="f.idfrente_ot as f.nombre for f in ot.frentes" ng-init="eq.idfrente_ot = eq.idfrente_ot">	</select>
      </td>
      <td class="font9"> <input type="text" ng-model="eq.fecha_ini" style="border: 1px solid #E65100; width:7ex"> </td>
      <td class="font9"> <input type="text" ng-model="eq.fecha_fin" style="border: 1px solid #E65100; width:7ex"> </td>
      <td class="font9">  <span  ng-click="dialog('Agregado en: '+eq.fecha_agregado )" data-icon="&#xe039;"></span> </td>
    </tr>

    <tr>
      <td colspan="11" class="right-align" > <b>Subtotal equipos: </b> <span ng-bind="tr.eqsubtotal | currency"></span> </td>
    </tr>
