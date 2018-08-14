<section class="">
	<div class="col s12 overflowAuto" style="padding:0px">
		<table class="mytabla largWidth">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Descripción</th>
					<th>Facturable</th>
					<th>Unidad</th>
					<th>Cantidad</th>
					<th>Duración</th>
					<th>Valor Und.</th>
					<th>Valor calc.</th>
					<th>Agregado</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="9" rowspan="" style="background:#ddedd0">ACTIVIDADES DE MTTO.</th>
				</tr>
				<tr ng-repeat="act in mytr.actividades | orderBy: 'codigo' ">
					<td>{{ act.itemc_item }}</td>
					<td>{{ act.descripcion }}</td>
					<td>{{ act.facturable?'SI':'NO' }}</td>
					<td>{{ act.unidad }}</td>
					<td> {{ act.cantidad }} </td>
					<td> {{ act.duracion }} </td>
					<td style="text-align: right">{{ act.tarifa | currency:'$':0}}</td>
					<td style="text-align: right">
						{{ ( act.facturable?(act.cantidad * act.duracion)*act.tarifa: 0 ) | currency:'$':0  }}
					<td>{{ act.fecha_agregado }}</td>
				</tr>
				<tr>
					<th colspan="9" rowspan="" style="background:#ddedd0">PERSONAL</th>
				</tr>
				<tr ng-repeat="per in mytr.personal | orderBy: 'codigo' ">
					<td>{{ per.itemc_item }}</td>
					<td>{{ per.descripcion }}</td>
					<td>{{ per.facturable?'SI':'NO' }}</td>
					<td>{{ per.unidad }}</td>
					<td> {{per.cantidad}} </td>
					<td> {{per.duracion}} </td>
					<td style="text-align: right">{{ per.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( per.facturable? (per.cantidad * per.duracion)*per.tarifa :0 ) | currency:'$':0  }}
					</td>
					<td>{{ per.fecha_agregado }}</td>
				</tr>
				<tr>
					<th colspan="9" rowspan="" style="background:#ddedd0">EQUIPOS</th>
				</tr>

				<tr ng-repeat="eq in mytr.equipos | orderBy: 'codigo' ">
					<td>{{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<td>{{ eq.facturable?'SI':'NO' }}</td>
					<td>{{ eq.unidad }}</td>
					<td> {{eq.cantidad}} </td>
					<td> {{eq.duracion}} </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( eq.facturable?(eq.cantidad * eq.duracion)*eq.tarifa:0 ) | currency:'$':0 }}
					</td>
					<td>{{ eq.fecha_agregado }}</td>
				</tr>

				<tr>
					<th colspan="9" rowspan="" style="background:#ddedd0">MATERIALES</th>
				</tr>

				<tr ng-repeat="eq in mytr.material | orderBy: 'codigo' ">
					<td>{{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<td>{{ eq.facturable?'SI':'NO' }}</td>
					<td>{{ eq.unidad }}</td>
					<td> {{eq.cantidad}} </td>
					<td> {{eq.duracion}} </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( eq.facturable?(eq.cantidad * eq.duracion)*eq.tarifa:0 ) | currency:'$':0 }}
					</td>
					<td>{{ eq.fecha_agregado }}</td>
				</tr>

				<tr>
					<th colspan="9" rowspan="" style="background:#ddedd0">OTROS</th>
				</tr>

				<tr ng-repeat="eq in mytr.otros | orderBy: 'codigo' ">
					<td>{{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<td>{{ eq.facturable?'SI':'NO' }}</td>
					<td>{{ eq.unidad }}</td>
					<td> {{eq.cantidad}} </td>
					<td> {{eq.duracion}} </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( eq.facturable?(eq.cantidad * eq.duracion)*eq.tarifa:0 ) | currency:'$':0 }}
					</td>
					<td>{{ eq.fecha_agregado }}</td>
				</tr>

				<tr>
					<th colspan="9" rowspan="" style="background:#ddedd0">SUBCONTRATO</th>
				</tr>

				<tr ng-repeat="eq in mytr.subcontratos | orderBy: 'codigo' ">
					<td>{{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<td>{{ eq.facturable?'SI':'NO' }}</td>
					<td>{{ eq.unidad }}</td>
					<td> {{eq.cantidad}} </td>
					<td> {{eq.duracion}} </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ ( eq.facturable?(eq.cantidad * eq.duracion)*eq.tarifa:0 ) | currency:'$':0 }}
					</td>
					<td>{{ eq.fecha_agregado }}</td>
				</tr>
				<tr>
					<td colspan="6" rowspan="" style="text-align: right">Sutotal de recursos: </td>
					<td colspan="3" rowspan="" headers=""><big><b>{{ (tr.eqsubtotal+tr.actsubtotal+tr.persubtotal+tr.msubtotal+tr.otrsubtotal+tr.subactsubtotal) | currency:'$':0 }}</b></big></td>
				</tr>

			</tbody>
		</table>
	</div>

</section>
