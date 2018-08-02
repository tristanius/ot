
			<tr>
				<th colspan="12" rowspan="" style="background:#ddedd0">OTROS: </th>
			</tr>
			<tr ng-repeat="o in tr.otros | orderBy: 'codigo'">
				<td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+o.codigo)"></span> <span ng-bind="o.item"></span> </td>
				<td><small ng-bind="o.codigo"></small></td>
				<td ng-bind="o.descripcion"></td>
				<th style="display:none">
					<select class="font9" style="width:60px;" ng-model="o.idsector_item_tarea" ng-init="o.idsector_item_tarea = (''+o.idsector_item_tarea)" disabled>
						<?php foreach ($sectores->result() as $key => $value): ?>
							<option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
						<?php endforeach; ?>
					</select>
				</th>
				<td class="noMaterialStyles"> <input type="checkbox" ng-model="o.facturable" ng-init="o.facturable = toboolean(o.facturable)"> </td>
				<td ng-bind="o.unidad"></td>
				<td> <input type="number" style="border: 1px solid #E65100; width:7ex" min="0" step=any ng-model="o.cantidad" ng-init="o.cantidad = strtonum(o.cantidad)" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
				<td> <input type="number" style="border: 1px solid #E65100; width:10ex" min="0" step=any ng-model="o.duracion" ng-init="o.duracion = strtonum(o.duracion)"  ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
				<td style="text-align: right" ng-bind="o.tarifa | currency:'$':0"></td>
				<td style="text-align: right"> <small ng-bind="o.subtarifa"></small> <input type="text" ng-model="o.subtarifa" style="max-width:10ex;" ng-init="o.subtarifa = o.subtarifa?o.subtarifa:o.tarifa"> </td>
				<td style="text-align: right">
					{{ ( o.facturable?(o.cantidad * o.duracion)*o.tarifa:0 ) | currency:'$':0 }}
					<button ng-show=" ( o.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.otros, o, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
				</td>
				<td>
					<select ng-model="o.idfrente_ot" ng-options="f.idfrente_ot as f.nombre for f in ot.frentes" ng-init="o.idfrente_ot = o.idfrente_ot">	</select>
				</td>
				<td class="font9">{{ o.fecha_agregado }}</td>
			</tr>

			<tr>
				<td colspan="12" class="right-align" > <b>Subtotal: </b> <span ng-bind="tr.otrsubtotal | currency"></span> </td>
			</tr>
