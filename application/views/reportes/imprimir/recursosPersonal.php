<table class="font8 recursos">
  <thead style="background:#EEE">
    <tr>
      <th rowspan="2"> No.</th>
      <th rowspan="2" class="">identificacion</th>
      <th rowspan="2" class="w15">Nombre Completo</th>
      <th rowspan="2" class="">Item</th>
      <th rowspan="2" class="w17 font8">Cargo</th>
      <th rowspan="2" class="">C/L</th>
      <th rowspan="2" class="">B/O/N</th>
      <th rowspan="2" class="">Und.</th>
      <th colspan="2" class="" nowrap="nowrap">Horario</th>
      <th colspan="5" class="">Hr. trabajadas</th>
      <th rowspan="2" class="">Alm</th>
      <th rowspan="2" class="">Rac</th>
      <th colspan="2" class="">G. viaje</th>
    </tr>
    <tr>
      <th class="" nowrap="nowrap">Turno 1</th>
      <th class="" nowrap="nowrap">Turno 2</th>
      <th class="" style="padding:2px;">Día</th>
      <th class="" style="padding:2px;">H.O.</th>
      <th class="font8" style="padding:2px;">HED</th>
      <th class="font8" style="padding:2px;">HEN</th>
      <th class="font8" style="padding:2px;">HRN</th>
      <th>P/R</th>
      <th>Lugar</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $i = 0;
      $sumatoria = array('ho'=>0, 'hed'=>0, 'hen'=>0, 'hrn'=>0, 'rac'=>0 );
      foreach ($recursos->personal as $k => $v): ?>
      <?php
        $sumatoria['ho'] +=$v->horas_ordinarias;
        $sumatoria['hed'] +=$v->horas_extra_dia;
        $sumatoria['hen'] +=$v->horas_extra_noc;
        $sumatoria['hrn'] +=$v->horas_recargo;
        $sumatoria['rac'] +=$v->racion;
		    if(  (isset($v->facturable) && $v->facturable ) || ( isset($v->print) && $v->print) ){
			?>
			<tr>
			  <td><?php $i++; echo $i; ?></td>
			  <td><?= $v->identificacion ?></td>
			  <td><?= $v->nombre_completo ?></td>
			  <td><?= $v->itemc_item ?></td>
			  <td><?= $v->descripcion ?></td>
			  <td><?= $v->CL ?></td>
			  <td><?= (isset($v->facturable) && !$v->facturable)?'N':(isset($v->BO)?$v->BO:'') ?></td>
			  <td><?= $v->unidad ?></td>

        <td>
          <div  ><?= $v->hora_inicio ?></div>
          <div  ><?= ($v->hora_fin == 0)?'-':$v->hora_fin; ?></div>
        </td>
        <td>
         <div  ><?= ($v->hora_inicio2 == 0)?'-':$v->hora_inicio2; ?></div>
         <div  ><?= $v->hora_fin2 ?></div>
       </td>

			  <td><?= ($v->cantidad == 0)?'-':$v->cantidad*1; ?></td>
        <td><?= ($v->horas_ordinarias == 0)?'-':$v->horas_ordinarias; ?></td>
			  <td><?= ($v->horas_extra_dia == 0)?'-':$v->horas_extra_dia; ?></td>
			  <td><?= ($v->horas_extra_noc == 0)?'-':$v->horas_extra_noc; ?></td>
			  <td><?= ($v->horas_recargo == 0)?'-':$v->horas_recargo; ?></td>
			  <td><?= (isset($v->hr_almuerzo) && $v->hr_almuerzo>0)?'Sí':'No'; ?></td>
			  <td><?= isset($v->racion)?$v->racion:''; ?></td>
			  <td><?= isset($v->gasto_viaje_pr)?$v->gasto_viaje_pr:''; ?></td>
			  <td class="font8"><?= isset($v->gasto_viaje_lugar)?$v->gasto_viaje_lugar:''; ?></td>
			</tr>

			<?php
		}
		?>
      <?php endforeach; ?>
      <?php for ($i=0; $i <= (1 - sizeof($recursos->equipos) ); $i++) { ?>
        <tr>
          <td> - </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php } ?>
        <tr>
          <td colspan="9">
            Convenciones para novedadesd del personal: B: Basico/ O: Opcional / N: No Facturable/ D: Descanso compensario/ A: Ausente sin permiso/ I: Incapacidad por accidente de trabajo/
            IC: incapacidad por emfermedad común/ S: Sancionado/ ACSP: Ausente con permiso sin pago/ ACCP: Ausente con permiso con pago/ V: Vacaciones/ P: Pernoctó/ R: Retornó
          </td>
          <td>TOTAL:</td>
          <td></td>
          <td><?= $sumatoria['ho'] ?></td>
          <td><?= $sumatoria['hed'] ?></td>
          <td><?= $sumatoria['hen'] ?></td>
          <td><?= $sumatoria['hrn'] ?></td>
          <td></td>
          <td><?= $sumatoria['rac'] ?></td>
          <td></td>
          <td></td>
        </tr>
  </tbody>
</table>
