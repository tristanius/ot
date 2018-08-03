
	<div class="col s6" ng.if="tr.idtarea_ot">
		<table class="mytabla">
			<thead style="background:#ddedd0">
				<tr>
					<th></th>
					<th>Recursos</th>
					<th ng-bind="tr.valor_recursos | currency: '$ '"></th>
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
					<td> <input type="text" ng-model="tr.a" ng-init="tr.a = (tr.a?tr.a:tr.a_vg)" ng-change="calcularSubtotales()"> </td>
					<td> <span ng-bind="(tr.valor_recursos*tr.a) | currency"></span> </td>
				</tr>
				<tr>
					<td>Imprevistos</td>
					<td> <input type="text" ng-model="tr.i" ng-init="tr.a = (tr.i?tr.i:tr.i_vg)" ng-change="calcularSubtotales()"> </td>
					<td> <span ng-bind="(tr.valor_recursos*tr.i) | currency"></span> </td>
				</tr>
				<tr>
					<td>Utilidad</td>
					<td> <input type="text" ng-model="tr.u" ng-init="tr.a = (tr.u?tr.u:tr.u_vg)" ng-change="calcularSubtotales()"> </td>
					<td> <span ng-bind="(tr.valor_recursos*tr.u) | currency"></span> </td>
				</tr>
				<tr>
					<th colspan="2">Total Tarea de O.T.</th>
          <th ng-bind="ot.valor_ot"></th>
				</tr>
			</tbody>
		</table>
	</div>
