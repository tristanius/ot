<table>
  <thead>
    <tr>
      <td colspan="2"> <img src="<?= base_url('assets/img/termotecnica.jpg') ?>" style="width:100px" alt=""> </td>
      <td colspan="13" style="text-align:center; font-size: 20px;"> Horas extras </td>
    </tr>
    <tr>
      <th>No. OT: </th>
      <th><?= $nombre_ot ?></th>
      <th colspan='13'></th>
    </tr>
    <tr>
      <th>Item</th>
      <th>Personal</th>
      <th class="texto-vertical" >Personal <br> Planeado</th>
      <th class="texto-vertical" >Cant. HED</th>
      <th class="texto-vertical" >Cant. HEN</th>
      <th class="texto-vertical" >Cant. HEFD</th>
      <th class="texto-vertical" >Cant. HEFN</th>
      <th class="texto-vertical" >Cant. HFR</th>
      <th class="texto-vertical" >Valor día</th>
      <th class="texto-vertical" >Valor. HED</th>
      <th class="texto-vertical" >Valor HEN</th>
      <th class="texto-vertical" >Valor HEFD</th>
      <th class="texto-vertical" >Valor HEFN</th>
      <th class="texto-vertical" >Valor HFR</th>
      <th class="texto-vertical" >Total</th>
  </thead>
  <tbody>
    <?php foreach ($horas_extra->json_horas_extra as $key => $val): ?>
      <?php if ($val->cantidad_he > 0): ?>
        <tr>
          <td><?= $val->itemc_item ?></td>
          <td><?= getItemC($val->itemc_item)->descripcion ?></td>
          <td style="text-align: center" ><?= $val->cantidad_he ?></td>
          <td style="text-align: center" ><?= $val->cantidad_hed!=0? $val->cantidad_hed: ''; ?></td>
          <td style="text-align: center" ><?= $val->cantidad_hen!=0? $val->cantidad_hen: ''; ?></td>
          <td style="text-align: center" ><?= $val->cantidad_hefd!=0? $val->cantidad_hefd: ''; ?></td>
          <td style="text-align: center" ><?= $val->cantidad_hefn!=0? $val->cantidad_hefn: ''; ?></td>
          <td style="text-align: center" ><?= $val->cantidad_hfr!=0? $val->cantidad_hfr: ''; ?></td>
          <td style="text-align: center" ><?= $val->salario!=0? '$ '.number_format($val->salario): ''; ?></td>
          <td style="text-align: center" ><?= $val->total_hed!=0? '$ '.number_format($val->total_hed):'-'; ?></td>
          <td style="text-align: center" ><?= $val->total_hen!=0? '$ '.number_format($val->total_hen):'-'; ?></td>
          <td style="text-align: center" ><?= $val->total_hefd!=0? '$ '.number_format($val->total_hefd):'-'; ?></td>
          <td style="text-align: center" ><?= $val->total_hefn!=0? '$ '.number_format($val->total_hefn):'-'; ?></td>
          <td style="text-align: center" ><?= $val->total_hfr!=0? '$ '.number_format($val->total_hfr):'-'; ?></td>
          <td style="text-align: center" >$ <?= number_format($val->total_hed +  $val->total_hen + $val->total_hefd + $val->total_hefn + $val->total_hfr) ?></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>

    <tr>
      <td colspan="15">OBSERVACIONES: <br></td>
    </tr>
  </tbody>
</table>
