<section>

  <h5>Resumen de cantidades a la fecha</h5>

  <table class="mytabla">
    <thead>
      <tr>
        <th>Codigo</th>
        <th>Item</th>
        <th>Descripcion</th>
        <th>Tarifa</th>
        <th>Cantidad total plan</th>
        <th>Duracion total plan</th>
        <th>Total planeado (Gral.)</th>
        <th>Cantidad ejecudata en RD</th>
        <th>Total ejecutado</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items->result() as $k => $v): ?>
        <tr style="<?= ( $v->cant_ejecutada > ($v->cant_total_plan * $v->dura_total_plan) )?'background:#F95E5E; color:#FFF':''; ?>">
          <td><?= $v->codigo ?></td>
          <td><?= $v->itemc_item ?></td>
          <td><?= $v->descripcion ?></td>
          <td>$ <?= number_format($v->tarifa )?></td>
          <td><?= $v->cant_total_plan ?></td>
          <td><?= $v->dura_total_plan ?></td>
          <td>$ <?= number_format( ( $v->facturable? ( $v->tarifa * ($v->cant_total_plan * $v->dura_total_plan) ) :0 ) ) ?></td>
          <td><?= $v->cant_ejecutada ?></td>
          <td>$ <?= number_format($v->cant_ejecutada*$v->tarifa) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
