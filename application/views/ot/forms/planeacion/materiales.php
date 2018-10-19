			<tr>
				<th colspan="14" rowspan="" style="background:#ddedd0">MATERIAL: </th>
			</tr>
			<tr ng-repeat="m in tr.material | orderBy: 'codigo'">
				<td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+m.codigo)"></span> <span ng-bind="m.item"></span> </td>
				<td><small ng-bind="m.codigo"></small></td>
				<td ng-bind="m.descripcion"></td>
				<th style="display:none">
					<select class="font9" style="width:60px;" ng-model="m.idsector_item_tarea" ng-init="m.idsector_item_tarea = (''+m.idsector_item_tarea)" disabled>
						<?php foreach ($sectores->result() as $key => $value): ?>
							<option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
						<?php endforeach; ?>
					</select>
				</th>
				<td class="noMaterialStyles"> <input type="checkbox" ng-model="m.facturable" ng-init="m.facturable = toboolean(m.facturable)"> </td>
				<td ng-bind="m.unidad"></td>

	      <td class="font9"> <input type="text" ng-model="m.fecha_ini" class="datepicker" style="border: 1px solid #E65100; width:10ex"> </td>
	      <td class="font9"> <input type="text" ng-model="m.fecha_fin" class="datepicker" style="border: 1px solid #E65100; width:10ex"> </td>

				<td> <input type="number" style="border: 1px solid #E65100; width:7ex" step=any ng-model="m.cantidad" ng-init="m.cantidad = strtonum(m.cantidad)" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
				<td> <input type="number" style="border: 1px solid #E65100; width:10ex" step=any ng-model="m.duracion" ng-init="m.duracion = strtonum(m.duracion)"  ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>

				<td style="text-align: right" ng-bind="m.tarifa | currency:'$':0"></td>

				<td style="display:none">
					<input type="text" ng-model="m.subtarifa" style="max-width:10ex;" ng-init="m.subtarifa = m.subtarifa?m.subtarifa:m.tarifa">
				</td>

				<td style="text-align: right">
					{{ ( m.facturable?(m.cantidad * m.duracion)*m.tarifa:0 ) | currency:'$':0 }}
					<button ng-show=" ( m.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.material, m, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
				</td>
				<td>
					<select ng-model="m.idfrente_ot" ng-options="f.idfrente_ot as f.nombre for f in ot.frentes" ng-init="m.idfrente_ot = m.idfrente_ot">	</select>
				</td>

	      <td class="font9">  <span  ng-click="dialog('Agregado en: '+m.fecha_agregado )" data-icon="&#xe039;" ng-init="datepicker_init()"></span> </td>
			</tr>

			<tr>
				<td colspan="14" class="right-align" > <b>Subtotal: </b> <span ng-bind="tr.msubtotal | currency"></span> </td>
			</tr>
