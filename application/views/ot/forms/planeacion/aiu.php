
	<div class="col s6" ng-if="tr.nombre_tarea">
		<table class="mytabla" ng-init="calcularSubtotales()">
			<thead style="background:#ddedd0">
				<tr>
					<th></th>
					<th>Recursos</th>
					<th ng-bind="tr.valor_recursos | currency: '$ ':0"></th>
				</tr>
				<tr>
					<th>Concepto</th>
					<th>%</th>
					<th>Valor</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Administración</td>
					<td> <span ng-bind="tr.a" ng-init="calcularSubtotales()"> </span> </td>
					<td> <span ng-bind="(tr.valor_recursos*tr.a) | currency: '$ ' "></span> </td>
				</tr>
				<tr>
					<td>Imprevistos</td>
					<td> <span ng-bind="tr.i" ng-init="calcularSubtotales()"> </span> </td>
					<td> <span ng-bind="(tr.valor_recursos*tr.i) | currency: '$ ' "></span> </td>
				</tr>
				<tr>
					<td>Utilidad</td>
					<td> <span ng-bind="tr.u" ng-init="calcularSubtotales()"> </span> </td>
					<td> <span ng-bind="(tr.valor_recursos*tr.u) | currency: '$ ' "></span> </td>
				</tr>
				<tr>
					<th colspan="2">Total Tarea de O.T.</th>
					<th ng-bind="tr.valor_tarea_ot | currency: '$ ' "></th>
				</tr>
			</tbody>
		</table>
	</div>
