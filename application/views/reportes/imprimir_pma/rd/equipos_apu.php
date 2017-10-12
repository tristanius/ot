<table border="1">
  <thead>
    <tr class="trLimpia"></tr>
    <tr>
      <th colspan="19">EQUIPO</th>
      <th colspan="16">ACTIVIDAD DE MANTENIMIENTO</th>
    </tr>
    <tr>
      <th colspan="2">CODIGO</th>
      <th colspan="6">DESCRIPCION</th>
      <th colspan="1">BAS.</th>
      <th colspan="1">VAR.</th>
      <th colspan="1">BASE</th>
      <th colspan="1">UND.</th>
      <th colspan="1">CANT.</th>
      <th colspan="2">ESTADO</th>
      <th colspan="2">PLACA</th>
      <th colspan="2">No. HORAS</th>
      <th colspan="2">CODIGO</th>
      <th colspan="8">ACTIVIDAD DE MANTENIMIENTO</th>
      <th colspan="2">UNIDAD</th>
      <th colspan="2">CANT.</th>
      <th colspan="2">ACUM.</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($equipos as $key => $e): ?>
      <tr>
        <td colspan="2"><?= $e->itemc_item ?></td>
        <td colspan="6"><?= $e->descripcion ?></td>
        <td colspan="1"> <?= ($e->BO=="B")?"SI":"NO"; ?> </td>
        <td colspan="1"> <?= ($e->BO=="O")?"SI":"NO"; ?> </td>
        <td colspan="1"> </td>
        <td colspan="1"> <?= $e->unidad ?> </td>
        <td colspan="1"> <?= $e->cantidad ?></td>
        <td colspan="2"> <?= $e->horas_operacion>0?"Operativo": ( $e->horas_disponible?"Disponible": ( $e->varado?"Varado":" - " ) ); ?> </td>
        <td colspan="2"> <?= $e->referencia ?> </td>
        <td colspan="2"> <?= $e->horas_operacion>0?$e->horas_operacion:$e->horas_disponible ?> </td>
        <td colspan="2">CODIGO</td>
        <td colspan="8">ACTIVIDAD DE MANTENIMIENTO</td>
        <td colspan="2">UNIDAD</td>
        <td colspan="2">CANT.</td>
        <td colspan="2">ACUM.</td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
