<div class="row col s12" style="padding:0">

	<div id="" class="col l3 s12" style="padding:2px; box-sizing: border-box;" >
		<div class="">
			<table class="mytabla">
				<thead>
					<tr>
						<td colspan="2"> <b>Indirectos:</b> </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> Administración (<span ng-bind="mytr.a*100"></span>%): </td>
						<td> <span ng-bind="mytr.json_indirectos.administracion | currency:'$':0 "></span></td>
					</tr>
					<tr>
						<td> Imprevistos (<span ng-bind="mytr.i*100"></span>%): </td>
						<td> <span ng-bind="mytr.json_indirectos.imprevistos | currency:'$':0 "></span></td>
					</tr>
					<tr>
						<td> Utilidad (<span ng-bind="mytr.u*100"></span>%): </td>
						<td> <span ng-bind="mytr.json_indirectos.utilidad | currency:'$':0 "></span> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col l3 s12" style="padding:2px; box-sizing: border-box;" >
		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Gastos de viaje:</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Gastos de viaje:</td>
					<td> {{ mytr.json_viaticos.valor_viaticos | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td>Administración (4.58%):</td>
					<td> {{ mytr.json_viaticos.administracion | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="" class="col l3 s12" style="padding:2px; box-sizing: border-box;" >
		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Horas extra y raciones:</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> Horas Extra:</td>
					<td> {{ mytr.json_horas_extra.valor_horas_extra | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td> Raciones:</td>
					<td>
						<div class="">
							cant: <b type="text" ng-bind="mytr.json_horas_extra.raciones_cantidad" ></b>
						</div>
						<div class="">
							 Valor Und: <b ng-bind="mytr.json_horas_extra.raciones_valor_und | currency:'$':0 "></b>
						</div>
						<b>Total raciones: {{ (mytr.json_horas_extra.raciones_cantidad * mytr.json_horas_extra.raciones_valor_und) | currency:'$':0 }}</b>
					</td>
				</tr>
				<tr>
					<td>Administración (4.58%):</td>
					<td> {{ mytr.json_horas_extra.administracion | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="" class="col l3 s12" style="padding:2px; box-sizing: border-box;" >

		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Reembolsables:</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> Gastos Reembolsables:</td>
					<td> {{ mytr.json_reembolsables.valor_reembolsables | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td>Administración (1%):</td>
					<td> {{ mytr.json_reembolsables.valor_reembolsables * 0.01 | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<h5>Valor tarea: {{ mytr.valor_tarea_ot | currency:'$':0}}</h5>
</div>
