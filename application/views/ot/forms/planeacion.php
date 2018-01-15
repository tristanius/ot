<section class="">
	<?php $this->load->view('ot/add/windowItems') ?>

	<p ng-show=" (tr.idtarea_ot == undefined || tr.idtarea_ot == '') || true">
		<div ng-if="!tr.idvigencia_tarifas">
			<label>Selecione una vigencia de tarifas: </label>
			<select ng-model="vg" ng-options="vg as vg.descripcion_vigencia disable when (ot.idcontrato != vg.idcontrato) for vg in vigencias track by vg.idvigencia_tarifas"></select>
			<button type="button" ng-if="vg"
				ng-click="setValorProp( vg.idvigencia_tarifas, tr, 'idvigencia_tarifas' ); setValorProp( tr.idvigencia_tarifas, filtroItems, 'idvigencia_tarifas' )" class="btn blue mini-btn">
				Seleccionar
			</button>
			<span ng-if="!tr.idcontrato"> Seleciona un contrato. </span>
		</div>
		<div ng-if="tr.idvigencia_tarifas">
					<h5>{{ findObjByProp(tr.idvigencia_tarifas, 'idvigencia_tarifas', vigencias).descripcion_vigencia }}</h5>
					<button type="button" ng-click="VwITems(1); setValorProp( tr.idvigencia_tarifas, filtroItems, 'idvigencia_tarifas' )" class="btn green mini-btn" data-icon="&#xe052;"> Actividades</button>
					<button type="button" ng-click="VwITems(2); setValorProp( tr.idvigencia_tarifas, filtroItems, 'idvigencia_tarifas' )" class="btn green mini-btn" data-icon="&#xe052;"> Personal</button>
					<button type="button" ng-click="VwITems(3); setValorProp( tr.idvigencia_tarifas, filtroItems, 'idvigencia_tarifas' )" class="btn green mini-btn" data-icon="&#xe052;"> Equipo</button>
		</div>

	</p>
	<style media="screen">
		.ui-datepicker-div select{
			display: inline-block;
		}
	</style>

	<hr>

	<fieldset>
		<div class="selectEnabled" style="display: inline-block; margin:1ex;">
				<label class="right-align"><b style="color:#0D47A1">FECHA INICIO: </b>
				<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_inicio"  value="<?= date('Y-m-d') ?>" placeholder=" fecha" style="cursor: pointer" readonly/>
			</label>
		</div>
		<div class="selectEnabled" style="display: inline-block; margin-right:1ex;">
				<label class="right-align"><b style="color:#0D47A1">FECHA FIN: </b>
				<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_fin"  value="<?= date('Y-m-d') ?>" placeholder=" fecha" style="cursor: pointer"  readonly/>
			</label>
		</div>

		<p class="selectEnabled">
			<label class="right-align"><b style="color:#0D47A1">SAP/Control: </b>
				<input type="text"  ng-model="tr.sap" placeholder=" No. control cambio/ Tarea" />
			</label>
			<label class="right-align"><b style="color:#0D47A1">Clase: </b>
				<select ng-model="tr.clase_sap">
					<option value="Z1 PM">Z1 PM</option>
					<option value="Z1 PM">Z1 PM</option>
					<option value="Z2 PM">Z2 PM</option>
					<option value="Z3 PM">Z3 PM</option>
					<option value="Z4 PC">Z4 PC</option>
					<option value="Z4 PM">Z4 PM</option>
					<option value="Z5 QM">Z5 QM</option>
					<option value="Z6 OM">Z6 OM</option>
					<option value="Z6 PC">Z6 PC</option>
					<option value="Z6 PM">Z6 PM</option>
					<option value="">N/A</option>
				</select>
			</label>
			<label class="right-align"><b style="color:#0D47A1">Tipo: </b>
				<select ng-model="tr.tipo_sap" >
					<option value="SUPERIOR">SUPERIOR</option>
					<option value="DERIVADA">DERIVADA</option>
					<option value="">N/A</option>
				</select>
			</label>
		</p>

		<p class="selectEnabled">
			<label class="right-align"><b style="color:#0D47A1">SAP para pago: </b>
				<input type="text"  ng-model="tr.sap_pago" placeholder=" # SAP para pago" />
			</label>
			<label class="right-align"><b style="color:#0D47A1">Clase: </b>
				<select ng-model="tr.clase_sap_pago">
					<option value="Z1 PM">Z1 PM</option>
					<option value="Z1 PM">Z1 PM</option>
					<option value="Z2 PM">Z2 PM</option>
					<option value="Z3 PM">Z3 PM</option>
					<option value="Z4 PC">Z4 PC</option>
					<option value="Z4 PM">Z4 PM</option>
					<option value="Z5 QM">Z5 QM</option>
					<option value="Z6 OM">Z6 OM</option>
					<option value="Z6 PC">Z6 PC</option>
					<option value="Z6 PM">Z6 PM</option>
					<option value="">N/A</option>
				</select>
			</label>
			<label class="right-align"><b style="color:#0D47A1">Tipo: </b>
				<select ng-model="tr.tipo_sap_pago" >
					<option value="SUPERIOR">SUPERIOR</option>
					<option value="DERIVADA">DERIVADA</option>
					<option value="">N/A</option>
				</select>
			</label>
		</p>

		<div class="noMaterialStyles regularForm" ng-if="validPriv(49)" style="display: inline-block; margin:1ex;">
			<label for="" style="color:#0D47A1"> <b>Editar tarea:</b> </label>
			<input type="checkbox" ng-model="tr.editable">
		</div>

		<div> <b>{{ tr.nombre_tarea }} :</b> </div>

	</fieldset>

	<div class="col s12 overflowAuto">
		<table class="mytabla largWidth">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Descripción</th>
					<th style="max-width:70px;">Sector</th>
					<th>Fact.</th>
					<th>UND</th>
					<th>Cantidad</th>
					<th>Duración</th>
					<th>Valor Und.</th>
					<th>Valor calc.</th>
					<th>Agregado</th>
				</tr>
			</thead>
			<tbody class="font11">
				<tr>
					<th colspan="10" rowspan="" style="background:#ddedd0">ACTIVIDADES DE MTTO.</th>
				</tr>
				<tr ng-repeat="act in tr.actividades | orderBy: 'codigo'">
					<td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+act.codigo)"></span> {{ act.itemc_item }}</td>
					<td>{{ act.descripcion }}</td>
					<th>
						<select class="font9" style="width:60px;" ng-model="act.idsector_item_tarea" ng-init="act.idsector_item_tarea = (act.idsector_item_tarea)">
							<?php foreach ($sectores->result() as $key => $value): ?>
								<option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
							<?php endforeach; ?>
						</select>
					</th>
					<td class="noMaterialStyles"> <input type="checkbox" ng-model="act.facturable" ng-init="act.facturable = toboolean(act.facturable)"> </td>
					<td>{{ act.unidad }}</td>
					<td> <input type="number" style="border: 1px solid #E65100; width:7ex" min="0" step=0.1 ng-model="act.cantidad" ng-init="act.cantidad = strtonum(act.cantidad)" style="width:8ex" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
					<td> <input type="number" style="border: 1px solid #E65100; width:10ex" min="0" step=any ng-model="act.duracion" ng-init="act.duracion = strtonum(act.duracion)" style="width:10ex" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
					<td style="text-align: right">{{ act.tarifa | currency:'$':0}}</td>
					<td style="text-align: right">
						{{ ( act.facturable?(act.cantidad * act.duracion)*act.tarifa: 0 ) | currency:'$':0  }}
						<button ng-show=" ( act.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true )" type="button" ng-click="unset_item(tr.actividades, act, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
					</td>
					<td class="font9">{{ act.fecha_agregado }}</td>
				</tr>


				<tr>
					<th colspan="10" rowspan="" style="background:#ddedd0">PERSONAL</th>
				</tr>
				<tr ng-repeat="per in tr.personal | orderBy: 'codigo'">
					<td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+per.codigo)"></span> {{ per.itemc_item }}</td>
					<td style="max-width: 50%;">{{ per.descripcion }}</td>
					<th>
						<select class="font9" style="width:60px;" ng-model="per.idsector_item_tarea" ng-init="per.idsector_item_tarea = (''+per.idsector_item_tarea)" disabled>
							<?php foreach ($sectores->result() as $key => $value): ?>
								<option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
							<?php endforeach; ?>
						</select>
					</th>
					<td class="noMaterialStyles"> <input type="checkbox" ng-model="per.facturable" ng-init="per.facturable = toboolean(per.facturable)"> </td>
					<td>{{ per.unidad }}</td>
					<td><input type="number" style="border: 1px solid #E65100; width:7ex" min="0" step=any ng-model="per.cantidad" ng-init="per.cantidad = strtonum(per.cantidad)" style="width:7ex" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
					<td><input type="number" style="border: 1px solid #E65100; width:10ex" min="0" step=any ng-model="per.duracion" ng-init="per.duracion = strtonum(per.duracion)" style="width:10ex" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
					<td style="text-align: right">{{ per.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( per.facturable? (per.cantidad * per.duracion)*per.tarifa :0 ) | currency:'$':0  }}
						<button ng-show=" ( per.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.personal, per, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button>
					</td>
					<td class="font9">{{ per.fecha_agregado }}</td>
				</tr>


				<tr>
					<th colspan="10" rowspan="" style="background:#ddedd0">EQUIPOS: <a ng-href="<?= site_url('export/formatoEquiposTareaOT') ?>/{{ tr.idtarea_ot }}" class="btn mini-btn2" data-icon="&#xe030;"></a></th>
				</tr>
				<tr ng-repeat="eq in tr.equipos | orderBy: 'codigo'">
					<td> <span data-icon="&#xe039;" style="color:#6ce25d" ng-click="dialog('Codigo interno: '+eq.codigo)"></span> {{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<th>
						<select class="font9" style="width:60px;" ng-model="eq.idsector_item_tarea" ng-init="eq.idsector_item_tarea = (''+eq.idsector_item_tarea)" disabled>
							<?php foreach ($sectores->result() as $key => $value): ?>
								<option value="<?= $value->idsector_item_tarea ?>"><?= $value->idsector_item_tarea.'-'.$value->nombre_sector_item ?></option>
							<?php endforeach; ?>
						</select>
					</th>
					<td class="noMaterialStyles"> <input type="checkbox" ng-model="eq.facturable" ng-init="eq.facturable = toboolean(eq.facturable)"> </td>
					<td>{{ eq.unidad }}</td>
					<td> <input type="number" style="border: 1px solid #E65100; width:7ex" min="0" step=any ng-model="eq.cantidad" ng-init="eq.cantidad = strtonum(eq.cantidad)" ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
					<td> <input type="number" style="border: 1px solid #E65100; width:10ex" min="0" step=any ng-model="eq.duracion" ng-init="eq.duracion = strtonum(eq.duracion)"  ng-change="calcularSubtotales()" ng-readonly="!tr.editable"> </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( eq.facturable?(eq.cantidad * eq.duracion)*eq.tarifa:0 ) | currency:'$':0 }}
						<button ng-show=" ( eq.fecha_agregado == '' || ot.estado_doc == 'POR EJECUTAR' || tr.editable == true ) " type="button" ng-click="unset_item(tr.equipos, eq, '<?= site_url() ?>')" class="btn red mini-btn2"> x </button></td>
					<td class="font9">{{ eq.fecha_agregado }}</td>
				</tr>
				<tr>
					<td colspan="6" rowspan="" style="text-align: right">Sutotal de recursos: </td>
					<td colspan="3" rowspan="" headers=""><big><b>{{ (tr.eqsubtotal+tr.actsubtotal+tr.persubtotal) | currency:'$':0 }}</b></big></td>
				</tr>
			</tbody>
		</table>
	</div>

</section>
