
	<section id="resumen" ng-init="calcularSubtotales()">
		<div ng-repeat="mytr in ot.tareas">
			<!--<button type="button" class="" ng-click="delete_tarea('<?= site_url('OT/delete_tarea') ?>' ,tr)">Borrar</button>-->
			<h5> {{mytr.nombre_tarea}} </h5>
			<div class="">

				<table class="mytabla" style="width:auto; max-width:none">
					<tr>
						<th>Fecha inicio planeada:</th><td> <span ng-bind="mytr.fecha_inicio"></span> </td>
					</tr>
					<tr>
						<th>Fecha fin planeada:</th><td><span ng-bind="mytr.fecha_fin"></span></td>
					</tr>
				</table>

				<div class="row">
					<fieldset class="col l4 s12" style="padding: 3px;">
						<legend>SAP Incial</legend>
						<table class="mytabla">
							<tr>
								<th>#</th>
								<th>SAP/Control:</th>
								<th>Tipo:</th>
								<th>Clase: </th>
							</tr>
							<tr>
								<td>1</td>
								<td><span style="Color:#052460" ng-bind="mytr.sap"></span> </td>
								<td> <span style="Color:#052460" ng-bind="mytr.tipo_sap"></span> </td>
								<td> <span style="Color:#052460" ng-bind="mytr.clase_sap"></span> </td>
							</tr>
						</table>
					</fieldset>

					<fieldset class="col l4 s12" style="padding: 3px;">
						<legend>SAP PAGO</legend>
						<table class="mytabla">
							<tr>
								<th>#</th>
								<th>SAP/Control:</th>
								<th>Tipo:</th>
								<th>Clase: </th>
							</tr>
							<tr>
								<td>1</td>
								<td> <span style="Color:#052460"  ng-bind="mytr.sap_pago"></span> </td>
								<td> <span style="Color:#052460" ng-bind="mytr.tipo_sap_pago"></span> </td>
								<td> <span style="Color:#052460" ng-bind="mytr.clase_sap_pago"></span> </td>
							</tr>
						</table>
					</fieldset>
				</div>
			</div>
			<?php $this->load->view('ot/forms/resumen/planeacion'); ?>
			<?php $this->load->view('ot/forms/resumen/indirectos_ot'); ?>
			<br class="clear-left">
			<hr style="border:1px solid #33c633">
			<br>
		</div>
	</section>
