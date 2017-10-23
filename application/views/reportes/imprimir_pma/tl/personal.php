<table border="1" >
  <thead>
    <tr>
      <th rowspan="2">No.</th>
			<th rowspan="2" class="item">ITEM</th>
			<th rowspan="2">NÚMERO DE CÉDULA</th>
			<th rowspan="2" colspan='2'>NOMBRES Y APELLIDOS COMPLETOS</th>
			<th rowspan="2">CARGO</th>
			<th colspan="2">HORARIO LABORADO</th>
			<th colspan="3" rowspan="2">FIRMA</th>
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
      <td rowspan="2"><?= $y++; ?></td>
      <td rowspan="2"><?= $p->itemc_item ?></td>
      <td rowspan="2"><?= $p->identificacion ?></td>
      <td rowspan="2" colspan='2'><?= $p->nombre_completo ?></td>
      <td rowspan="2"><?= $p->descripcion ?></td>
      <td><?= $p->hora_inicio  ?></td>
      <td><?= $p->hora_fin ?></td>
      <td colspan="3"  rowspan="2"></td>
    </tr>
    <tr>
      <td><?= $p->hora_inicio2  ?></td>
      <td><?= $p->hora_fin2 ?></td>
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
        <td colspan="3"  rowspan="2"></td>
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
