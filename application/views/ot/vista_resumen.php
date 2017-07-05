<section>

  <h5>Resumen de cantidades a la fecha</h5>

  <table style="font-size: 10px;" class="mytabla">
    <thead>
      <tr>
        <th>Orden</th>
        <th>Codigo</th>
        <th>Item</th>
        <th>Descripcion</th>
        <th>linea</th>
        <th>Tarifa</th>
        <th>Fact.</th>
        <th>Cantidad planeada</th>
        <th>Total planeado (Gral.)</th>
        <th>Cantidad ejecudata <br> facturable</th>
        <th>Cantidad ejecudata <br> NO facturable</th>
        <th>Total ejecutado</th>
      </tr>
    </thead>
    <tbody>
      <?php $tipo_itemc = ""; $acumulado_tipo = 0; ?>
      <?php foreach ($items->result() as $k => $v): ?>
          <!-- contenido de la condicion -->
          <?php if ($tipo_itemc != $v->tipo_itemc){ ?>
          <!-- contenido de la condicion -->
            <td colspan="10"><?= $v->tipo_itemc ?></td>
            <td>SubTotal:</td>
            <td></td>
          </tr>
          <!-- fin contenido de la condicion -->
          <?php
          $tipo_itemc = $v->tipo_itemc;
          }
          ?>

          <tr style="<?= ( $v->cant_ejecutada > ($v->cantidad_planeada) )?'background:#F95E5E; color:#FFF':''; ?>">
            <td><?= $v->nombre_ot ?></td>
            <td><?= $v->codigo ?></td>
            <td><?= $v->itemc_item ?></td>
            <td><?= $v->descripcion ?></td>
            <td><?= $v->idsector_item_tarea ?></td>
            <td>$ <?= number_format($v->tarifa )?></td>
            <td style="border:1px green solid"><?= $v->facturable?'SI':'NO'; ?></td>
            <td><?= number_format($v->cantidad_planeada, 2) ?></td>
            <td>$ <?= number_format( ( $v->facturable? ( $v->tarifa * $v->cantidad_planeada ) :0 ), 2 ) ?></td>
            <td style="border:1px green solid; <?= !$v->facturable?'background:#EEE; color:#999':''; ?>"> <?= number_format($v->cant_ejecutada, 2) ?></td>
            <td style="border:1px #777 solid; <?= $v->facturable?'background:#EEE; color:#999':''; ?> "> <?= number_format($v->cant_ejecutada_nofact, 2) ?></td>
            <td>$ <?= $v->facturable?number_format($v->cant_ejecutada*$v->tarifa):0; ?></td>
          </tr>

          <?php $acumulado_tipo += $v->facturable?$v->cant_ejecutada*$v->tarifa:0; ?>
      <?php endforeach; ?>
    </tbody>
  </table>


</section>
