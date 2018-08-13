    <tr>
      <th colspan="12" rowspan="" style="background:#ddedd0">ACTIVIDADES DE MTTO.</th>
    </tr>

    <tr ng-repeat="act in tr.actividades | orderBy: 'codigo'">
      <td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+act.codigo)"></span> <span ng-bind="act.item"></span></td>
      <td><small ng-bind="act.codigo"></small></td>
      <td>{{ act.descripcion }}</td>
      <th style="display:none">
        <select class="font9" style="width:60px;" ng-model="act.idsector_item_tarea" ng-init="act.idsector_item_tarea = (act.idsector_item_tarea)">
          <?php foreach ($sectores->result() as $key => $value): ?>
            <option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
          <?php endforeach; ?>
        </select>
      </th>
      <td class="noMaterialStyles"> <input type="checkbox" ng-model="act.facturable" ng-init="act.facturable = toboolean(act.facturable)"> </td>
      <td ng-bind="act.unidad"></td>
      <td> <input type="number" style="border: 1px solid #E65100; width:7ex" step=0.01 ng-model="act.cantidad" ng-init="act.cantidad = strtonum(act.cantidad)" style="width:8ex" ng-change="calcularSubtotales(); act.cantidad = strtonum(act.cantidad)" ng-readonly="!tr.editable"> </td>
      <td> <input type="number" style="border: 1px solid #E65100; width:10ex" step=any ng-model="act.duracion" ng-init="act.duracion = strtonum(act.duracion)" style="width:10ex" ng-change="calcularSubtotales(); act.duracion = strtonum(act.duracion)" ng-readonly="!tr.editable"> </td>
      <td style="text-align: right" ng-bind="act.tarifa | currency:'$':0"></td>

      <td style="display:none;">
        <input type="text" ng-model="act.subtarifa" style="max-width:10ex;" ng-init="act.subtarifa = act.subtarifa?act.subtarifa:act.tarifa">
      </td>

      <td style="text-align: right">
        {{ ( act.facturable?(act.cantidad * act.duracion)*act.tarifa: 0 ) | currency:'$':0  }}
        <button ng-show=" ( act.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true )" type="button" ng-click="unset_item(tr.actividades, act, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
      </td>
      <td>
        <select ng-model="act.idfrente_ot" ng-options="f.idfrente_ot as f.nombre for f in ot.frentes" ng-init="act.idfrente_ot = act.idfrente_ot">	</select>
      </td>
      <td class="font9">{{ act.fecha_agregado }}</td>
    </tr>

    <tr>
      <td colspan="12" class="right-align" > <b>Subtotal: </b> <span ng-bind="tr.actsubtotal | currency"></span> </td>
    </tr>
