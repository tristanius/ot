<table class="font9 recursos" cellpadding="0" cellspacing="0" border="1">
  <thead style="background:#EEE">
    <tr>
      <th>Item</th>
      <th>Codigo</th>
      <th>Actividad</th>
      <th>Unidad</th>
      <th>canditad día</th>
      <th>Cantidad Acumulada</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($recursos->actividades as $key => $v): ?>
    <tr>
      <td> <?= $v->itemc_item ?></td>
      <td> <?= $v->codigo ?> </td>
      <td> <p><?= $v->descripcion.($v->idsector_item_tarea != 1?' ('.$v->nom_sector.')':'') ?></p> </td>
      <td> <?= $v->unidad ?> </td>
      <td> <?= $v->cantidad*1 ?> </td>
      <td> <?= $v->acumulado+($v->cantidad*1) ?> </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
