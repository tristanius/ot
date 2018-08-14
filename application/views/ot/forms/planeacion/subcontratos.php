
		<tr>
			<th colspan="12" rowspan="" style="background:#ddedd0">SUBCONTRATOS: </th>
		</tr>
		<tr ng-repeat="sb in tr.subcontratos | orderBy: 'codigo'">
			<td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+sb.codigo)"></span> <span ng-bind="sb.item"></span> </td>

			<td><small ng-bind="sb.codigo"></small></td>
			<td ng-bind="sb.descripcion"></td>

			<th style="display:none">
				<select class="font9" style="width:60px;" ng-model="sb.idsector_item_tarea" ng-init="sb.idsector_item_tarea = (''+sb.idsector_item_tarea)" disabled>
					<?php foreach ($sectores->result() as $key => $value): ?>
						<option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
					<?php endforeach; ?>
				</select>
			</th>

			<td class="noMaterialStyles"> <input type="checkbox" ng-model="sb.facturable" ng-init="sb.facturable = toboolean(sb.facturable)"> </td>
			<td ng-bind="sb.unidad"></td>

			<td>
      			<input type="number" style="border: 1px solid #E65100; width:7ex" min="0" step=any ng-model="sb.cantidad" ng-init="sb.cantidad = strtonum(sb.cantidad)" ng-change="calcularSubtotales()" ng-readonly="!tr.editable">
    		</td>
			<td>
      			<input type="number" style="border: 1px solid #E65100; width:10ex" min="0" step=any ng-model="sb.duracion" ng-init="sb.duracion = strtonum(sb.duracion)"  ng-change="calcularSubtotales()" ng-readonly="!tr.editable">
      		</td>

      		<td  style="display:none" ng-bind="sb.tarifa | currency:'$ ':0"></td>

			<td style="text-align: right"> 
				<small ng-bind="sb.subtarifa | currency:'$ ':2 "></small> 
				<input type="text" ng-model="sb.subtarifa" style="max-width:10ex;" ng-init="sb.subtarifa = sb.subtarifa?sb.subtarifa:sb.tarifa" ng-change="sb.tarifa = sb.subtarifa; calcularSubtotales()"> 
			</td>

			<td style="text-align: right">
				{{ ( sb.facturable?(sb.cantidad * sb.duracion)*sb.subtarifa:0 ) | currency:'$ ':0 }}
				<button ng-show=" ( sb.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.subcontratos, sb, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
			</td>

			<td>
				<select ng-model="sb.idfrente_ot" ng-options="f.idfrente_ot as f.nombre for f in ot.frentes" ng-init="sb.idfrente_ot = sb.idfrente_ot">	</select>
			</td>
			<td class="font9" >{{ sb.fecha_agregado }}</td>
		</tr>

		<tr>
			<td colspan="12" class="right-align" > <b>Subtotal: </b> <span ng-bind="tr.subactsubtotal | currency:'$ ':2"></span> </td>
		</tr>
