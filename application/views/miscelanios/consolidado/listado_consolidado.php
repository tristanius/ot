<?php
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="consolidadoGeneral.xls"');
  header('Cache-Control: max-age=0');
?>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  </head>
  <body>

    <table id="info_rd_condensado" class="mytabla" >

      <caption style="border:1px solid #333" colspan="10">
        Consolidado de frentes y actividades generado en: <?= date('Y-m-d')?>
      </caption>

      <thead>
        <tr style="background: #6FA5ED">
          <th>Orden</th>
          <th>Frente</th>
          <th>Fecha</th>
          <th>Item</th>
          <th>Descripción</th>
          <th>UND</th>
          <th>Asociado</th>
          <th>Total frente</th>
          <th>Cantidad asociada</th>
          <th></th>
        </tr>
      </thead>

      <?php foreach ($reportes->result() as $key => $rd): ?>

        <?php if ( isset($rd->condensado) ): ?>

            <?php $data = json_decode($rd->condensado) ?>

            <?php if (isset($data->frentes)): ?>

              <?php foreach ($data->frentes as $key => $frente): ?>
              <tbody>
                <tr>
                  <td colspan="10"> <b> <?=  $frente->nombre.' '.$frente->ubicacion ?> </b>  </td>
                </tr>

                <?php foreach ($frente->items as $key => $it): ?>
                <tr>
                  <td><?= $it->nombre_ot ?></td>
                  <td><?= $it->nombre_frente ?></td>
                  <td><?= $it->fecha_reporte ?></td>
                  <td><?= $it->itemc_item ?></td>
                  <td class="tableexport-string"> <span> <?= $it->descripcion ?> </span> </td>
                  <td><?= $it->unidad ?></td>
                  <td><?= $it->item_asociado.' ('.$it->descripcion_asociada.') '; ?></td>
                  <td><?= is_float($it->total)?number_format($it->total, 4):number_format($it->total) ?></td>
                  <td>
                    <?php if ($data->guardado): ?>
                      <?= is_float($it->cantidad_asociada)?number_format($it->cantidad_asociada, 4):number_format($it->cantidad_asociada) ?>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($it->alerta): ?>
                      <span style="color:red">La cantidad ingresada supera los valores maximos reportados del item en este frente.</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>

              </tbody>
              <?php endforeach; ?>

            <?php endif; ?>

        <?php endif; ?>

      <?php endforeach; ?>
    </table>

  </body>
</html>
