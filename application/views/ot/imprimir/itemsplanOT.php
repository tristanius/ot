<tbody>
  <tr style="font-size: 1.5ex; background: #13D620;">
    <td><b>Item</b></td>
    <td class="td50"><b>Descripción</b></td>
    <td><b>Unidad de Medida</b></td>
    <td><b>Cant.</b></td>
    <td><b>Duración <br> (Días)</b> </td>
    <td><b>Total <br> Solicitado</b></td>
    <td><b>Valor Unitario</b></td>
    <td><b>Valor Planeado</b></td>
  </tr>
  <tr>
    <td style="background:#bbf29d"> <b><?= $no_gestion ?></b> </td>
    <td style="background:#bbf29d"> <b><?= $gestion ?></b> </td>
    <td colspan="6" style="background:#FFF"></td>
  </tr>
  <?php $valor_gestion = 0; ?>
  <?php foreach ($items->result() as $it): ?>
    <tr>
      <td> <?= $it->item ?></td>
      <td class="td50" style="background: #EEF2EA"> <?= $it->descripcion ?> </td>
      <td class="textcenter"> <?= $it->unidad ?> </td>
      <td class="textcenter" style="background: #EEF2EA"> <?= $it->cantidad ?> </td>
      <td class="textcenter" style="background: #EEF2EA"> <?= $it->duracion ?></td>
      <td class="textright"> <?= number_format( ($it->cantidad * $it->duracion), 2 ) ?> </td>
      <td class="textright">$ <?= number_format($it->tarifa) ?></td>
      <td class="textright">$ <?= number_format($it->valor_plan) ?> </td>
    </tr>
  <?php endforeach; ?>
  <tr>
    <td colspan="7" class="textcenter">
      SUB-TOTAL: <?= $gestion ?>
    </td>
    <td class="textright">
      $ <?= number_format($subTotal, 0) ?>
    </td>
  </tr>
</tbody>
