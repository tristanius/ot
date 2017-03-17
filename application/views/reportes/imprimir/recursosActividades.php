<table class="font9 recursos">
  <thead style="background:#EEE">
    <tr>
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
      <td> <?= $v->itemc_item ?> </td>
      <td> <?= $v->descripcion.($v->idsector_item_tarea != 1?' ('.$v->nom_sector.')':'') ?> </td>
      <td> <?= $v->unidad ?> </td>
      <td> <?= $v->cantidad*1 ?> </td>
      <td> <?= $v->acumulado+($v->cantidad*1) ?> </td>
    </tr>
    <?php endforeach; ?>
    <?php for ($i=0; $i <= (1 - sizeof($recursos->actividades) ); $i++) { ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td> - </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
