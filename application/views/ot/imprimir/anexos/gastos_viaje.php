<table>
  <thead>
    <tr>
      <td colspan="2"> <img src="<?= base_url('assets/img/termotecnica.jpg') ?>" style="width:100px"  alt=""> </td>
      <td colspan="7" style="text-align:center; font-size: 20px"> <h4>Gastos de viaje</h4> </td>
    </tr>
    <tr>
      <th>No. OT: </th>
      <th><?= $nombre_ot ?></th>
      <th colspan='7'></th>
    </tr>
    <tr>
      <th>Item</th>
      <th>Personal</th>
      <th>Cant. Personas</th>
      <th>Días requeridos</th>
      <th>Alojamiento</th>
      <th>Alimentacion</th>
      <th>Miscelanios</th>
      <th>Transporte</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($viaticos->json_viaticos as $key => $val): ?>
      <?php if (isset($val->cantidad_gv) && isset($val->duracion_gv) && $val->cantidad_gv > 0 && $val->duracion_gv > 0): ?>
        <tr>
          <td><?= $val->itemc_item ?></td>
          <td><?= getItemC($val->itemc_item)->descripcion ?></td>
          <td><?= $val->cantidad_gv ?></td>
          <td><?= $val->duracion_gv ?></td>
          <td>$ <?= number_format($val->alojamiento) ?></td>
          <td>$ <?= number_format($val->alimentacion) ?></td>
          <td>$ <?= number_format($val->miscelanios) ?></td>
          <td>$ <?= number_format($val->transporte) ?></td>
          <td>$ <?= number_format($val->alojamiento + $val->alimentacion + $val->miscelanios + $val->transporte) ?></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
    <tr>
      <td colspan="9"> OBSERVACIONES:<br></td>
    </tr>
  </tbody>
</table>
