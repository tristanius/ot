<table border="1">
  <thead>
    <tr>
      <th rowspan="2">No.</th>
			<th rowspan="2" class="item">ITEM</th>
			<th rowspan="2">NÚMERO DE CÉDULA</th>
			<th rowspan="2" colspan='2'>NOMBRES Y APELLIDOS COMPLETOS</th>
			<th rowspan="2">CARGO</th>
			<th colspan="2">HORARIO LABORADO</th>
			<th colspan="2" rowspan="2">FIRMA</th>
		</tr>
		<tr>
			<th>HORA INICIAL</th>
			<th>HORA FINAL</th>
		</tr>
  </thead>
  <tbody>
    <?php
    $y = 1;
    foreach ($personal as $key => $p):
    ?>
    <tr>
      <td rowspan="2" style="text-align:center"><?= $y++; ?></td>
      <td rowspan="2" style="text-align:center"><?= $p->itemc_item ?></td>
      <td rowspan="2" style="text-align:center"><?= $p->identificacion ?></td>
      <td rowspan="2" style="text-align:center" colspan='2'><?= $p->nombre_completo ?></td>
      <td rowspan="2" style="text-align:center"><?= $p->descripcion ?></td>
      <td style="text-align:center"><?= $p->hora_inicio  ?></td>
      <td style="text-align:center"><?= $p->hora_fin ?></td>
      <td colspan="2" style="text-align:center" rowspan="2"></td>
    </tr>
    <tr>
      <td style="text-align:center"><?= $p->hora_inicio2  ?></td>
      <td style="text-align:center"><?= $p->hora_fin2 ?></td>
    </tr>
    <?php endforeach; ?>

    <?php
      for ($i=0; $i <= ( 11-sizeof($personal) ) ; $i++) {
      ?>
      <tr>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
        <td rowspan="2" colspan='2'></td>
        <td rowspan="2"></td>
        <td></td>
        <td></td>
        <td colspan="2"  rowspan="2"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <?php
      }
    ?>
  </tbody>
</table>
