<section class="">
	<?php $this->load->view('ot/add/windowItems') ?>

	<p ng-show=" (tr.idtarea_ot == undefined || tr.idtarea_ot == '') || true">
		<button type="button" ng-click="VwITems(1)" class="btn green mini-btn" data-icon="&#xe052;"> Actividades</button>
		<button type="button" ng-click="VwITems(2)" class="btn green mini-btn" data-icon="&#xe052;"> Personal</button>
		<button type="button" ng-click="VwITems(3)" class="btn green mini-btn" data-icon="&#xe052;"> Equipo</button>
	</p>
	<style media="screen">
		.ui-datepicker-div select{
			display: inline-block;
		}
	</style>

	<hr>

	<fieldset>
		<div class="selectEnabled">
			<label class="col m1 right-align"><b style="color:#0D47A1">FECHA INICIO: </b></label>
			<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_inicio"  value="<?= date('Y-m-d') ?>" placeholder=" fecha" style="cursor: pointer" readonly/>
		</div>
		<div class="selectEnabled">
			<label class="col m1 right-align"><b style="color:#0D47A1">FECHA FIN: </b></label>
			<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_fin"  value="<?= date('Y-m-d') ?>" placeholder=" fecha" style="cursor: pointer"  readonly/>
		</div>

		<div class="selectEnabled">
			<label class="col m1 right-align"><b style="color:#0D47A1">SAP tarea/Control: </b></label>
			<input type="text"  ng-model="tr.sap" placeholder=" No. control cambio/ Tarea" />
		</div>

		<p class="noMaterialStyles regularForm" ng-if="validPriv(49)">
			<label for="">Editar tarea:</label>
			<input type="checkbox" ng-model="tr.editable">
		</p>


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
					<td>{{ act.itemc_item }}</td>
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
					<td>{{ per.itemc_item }}</td>
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
					<td>{{ eq.itemc_item }}</td>
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
