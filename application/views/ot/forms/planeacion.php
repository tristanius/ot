<section class="">
	<?php $this->load->view('ot/add/windowItems') ?>
	<?php $this->load->view('ot/forms/planeacion/opciones_rec') ?>

	<style media="screen">
		.ui-datepicker-div select{
			display: inline-block;
		}
	</style>

	<hr>

	<?php $this->load->view('ot/forms/planeacion/especificaciones') ?>

	<div class="col s12 overflowAuto">
		<table class="mytabla largWidth">
			<thead>
				<tr>
					<th>Item</th>
					<th>Cod.</th>
					<th>Descripción</th>
					<th style="max-width:70px; display:none">Sector</th>
					<th>Fact.</th>
					<th>UND</th>
					<th>Cantidad</th>
					<th>Duración</th>
					<th>Tarifa </th>
					<th class="font10" style="max-width:70px; display:none">Sub. Tarifa</th>
					<th>Valor calc.</th>
					<th>Frente</th>
					<th>Agregado</th>
				</tr>
			</thead>
			<tbody class="font11">

				<?php $this->load->view('ot/forms/planeacion/actividades') ?>

				<?php $this->load->view('ot/forms/planeacion/personal') ?>

				<?php $this->load->view('ot/forms/planeacion/equipos') ?>

				<!-- MATERIAL Y OTROS -->

				<?php $this->load->view('ot/forms/planeacion/materiales') ?>
				<?php $this->load->view('ot/forms/planeacion/otros') ?>

				<!-- subcontratos -->
				<?php $this->load->view('ot/forms/planeacion/subcontratos') ?>

				<tr>
					<td colspan="9" rowspan="" style="text-align: right">Sutotal de recursos: </td>
					<td colspan="3" rowspan="" headers=""><big><b>{{ (tr.eqsubtotal+tr.actsubtotal+tr.persubtotal+tr.msubtotal+tr.otrsubtotal) | currency:'$ ':0 }}</b></big></td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php $this->load->view('ot/forms/planeacion/aiu') ?>

</section>
