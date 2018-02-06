<table style="font-size: 10px;" class="mytabla" border="1">
  <thead>
    <tr>
      <th>Frente</th>
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
      <th>Total ejecutado</th>
      <th>Cantidad ejecudata <br> NO facturable</th>
      <th>Total ejecutado NO fact</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $tipo_itemc = "";
      $acumulado_tipo = 0;
      $acumulado_general = 0;
      $numrows = $items->num_rows();
      $ind = 0 ;
    ?>
    <?php foreach ($items->result() as $k => $v): ?>
        <!-- contenido de la condicion -->
        <?php if ( $ind!=0 && $tipo_itemc != $v->tipo_itemc): ?>
          <tr>
            <th colspan="13" style="text-align:right">SubTotal de <?= $tipo_itemc ?>:</th>
            <th style="text-align: right">$ <?= number_format($acumulado_tipo) ?></th>
          </tr>
        <?php endif; ?>

        <?php if ($tipo_itemc != $v->tipo_itemc){ ?>
          <tr>
            <th style="background: #F4FBFC" colspan="14"><?= $v->tipo_itemc ?> </th>
          </tr>
          <!-- fin contenido de la condicion -->
          <?php
          $tipo_itemc = $v->tipo_itemc;
          $acumulado_tipo = 0;
        }
        ?>

        <tr style="<?= ( ( $v->facturable?$v->cant_ejecutada:$v->cant_ejecutada_nofact ) > ($v->cantidad_planeada) )?'background:#F95E5E; color:#FFF':''; ?>">
          <td><?= isset($v->nombre_frente)?$v->nombre_frente:''; ?></td>
          <td><?= $v->nombre_ot ?></td>
          <td><?= $v->codigo ?></td>
          <td><?= $v->itemc_item ?></td>
          <td><?= $v->descripcion ?></td>
          <td><?= $v->idsector_item_tarea ?></td>
          <td>$ <?= number_format($v->tarifa )?></td>
          <td style="border:1px green solid"><?= $v->facturable?'SI':'NO'; ?></td>
          <td><?= number_format($v->cantidad_planeada, 2) ?></td>
          <td>$ <?= number_format( ( $v->facturable? ( $v->tarifa * $v->cantidad_planeada ) :0 ), 2 ) ?></td>
          <td style="border:1px green solid; <?= !$v->facturable?'background:#EEE':''; ?>; color: #000;"> <?= number_format($v->cant_ejecutada, 2) ?></td>
          <td style="border:1px green solid; text-align: right; <?= $v->facturable?'background:#EEE':''; ?>; color: #000; ">$ <?= number_format($v->cant_ejecutada*$v->tarifa) ?></td>

          <td style="border:1px #777 solid; <?= $v->facturable?'background:#EEE':''; ?>; color: #000; "> <?= number_format($v->cant_ejecutada_nofact, 2) ?></td>
          <td style="border:1px green solid; text-align: right; <?= $v->facturable?'background:#EEE':''; ?>; color: #000; ">$ <?= number_format($v->cant_ejecutada_nofact*$v->tarifa) ?></td>
        </tr>

        <?php
        $acumulado_tipo += $v->facturable?$v->cant_ejecutada*$v->tarifa:0;
        $acumulado_general += $v->facturable?$v->cant_ejecutada*$v->tarifa:0;
        $ind ++;
        ?>

        <?php if ( $ind == $numrows): ?>
          <tr>
            <th colspan="13" style="text-align:right">SubTotal <?= $tipo_itemc ?>:</th>
            <th style="text-align: right">$ <?= number_format($acumulado_tipo) ?></th>
          </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
      <th style="text-align: right" colspan="13">Total</th>
      <th style="text-align: right">$ <?= number_format($acumulado_general) ?></th>
    </tr>
  </tbody>
</table>
