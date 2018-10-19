    <tr>
      <th colspan="14" rowspan="" style="background:#ddedd0">PERSONAL</th>
    </tr>

    <tr ng-repeat="per in tr.personal | orderBy: 'codigo'">
      <td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+per.codigo)"></span> <span ng-bind="per.item"></span> </td>
      <td><small ng-bind="per.codigo"></small></td>
      <td style="max-width: 50%;">{{ per.descripcion }}</td>
      <th style="display:none">
        <select class="font9" style="width:60px;" ng-model="per.idsector_item_tarea" ng-init="per.idsector_item_tarea = (''+per.idsector_item_tarea)" disabled>
          <?php foreach ($sectores->result() as $key => $value): ?>
            <option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
          <?php endforeach; ?>
        </select>
      </th>
      <td class="noMaterialStyles"> <input type="checkbox" ng-model="per.facturable" ng-init="per.facturable = toboolean(per.facturable)"> </td>
      <td>{{ per.unidad }}</td>

      <td class="font9"> <input type="text" class="datepicker" ng-model="per.fecha_ini" style="border: 1px solid #E65100; width:10ex"> </td>
      <td class="font9"> <input type="text" class="datepicker" ng-model="per.fecha_fin" style="border: 1px solid #E65100; width:10ex"> </td>

      <td><input type="number" style="border: 1px solid #E65100; width:7ex" step=any ng-model="per.cantidad" ng-init="per.cantidad = strtonum(per.cantidad)" style="width:7ex" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
      <td><input type="number" style="border: 1px solid #E65100; width:7ex" step=any ng-model="per.duracion" ng-init="per.duracion = strtonum(per.duracion)" style="width:10ex" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>

      <td style="text-align: right" ng-bind="per.tarifa | currency:'$':0"></td>

      <td style="display:none" >
        <input type="text" ng-model="per.subtarifa" style="max-width:10ex;" ng-init="per.subtarifa = per.subtarifa?per.subtarifa:per.tarifa">
      </td>

      <td style="text-align: right">
        {{ ( per.facturable? (per.cantidad * per.duracion)*per.tarifa :0 ) | currency:'$':0  }}
        <button ng-show=" ( per.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.personal, per, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
      </td>
      <td>
        <select ng-model="per.idfrente_ot" ng-options="f.idfrente_ot as f.nombre for f in ot.frentes" ng-init="per.idfrente_ot = per.idfrente_ot">	</select>
      </td>

      <td class="font9">  <span  ng-click="dialog('Agregado en: '+per.fecha_agregado )" data-icon="&#xe039;" ng-init="datepicker_init()"></span> </td>
    </tr>

    <tr>
      <td colspan="14" class="right-align" > <b>Subtotal de personal: </b> <span ng-bind="tr.persubtotal | currency"></span> </td>
    </tr>
