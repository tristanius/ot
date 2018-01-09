  <thead>
    <tr>
      <th colspan="36">ACTIVIDADES DE MANTENIMIENTO</th>
    </tr>
    <tr>
      <th colspan="1">Codigo</th>
      <th colspan="26">Actividad</th>
      <th colspan="3">Unidad</th>
      <th colspan="3">canditad día</th>
      <th colspan="3">Cantidad Acumulada</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($recursos->actividades as $key => $v): ?>
    <tr>
      <td> <?= $v->itemc_item ?> </td>
      <td> <p><?= $v->descripcion.($v->idsector_item_tarea != 1?' ('.$v->nom_sector.')':'') ?></p> </td>
      <td> <?= $v->unidad ?> </td>
      <td> <?= $v->cantidad*1 ?> </td>
      <td> <?= $v->acumulado+($v->cantidad*1) ?> </td>
    </tr>
    <?php endforeach; ?>
    <?php
    for ($i=0; $i <= ( 6-sizeof($recursos->actividades) ) ; $i++) {
    ?>
    <tr>
      <td colspan="1"> - </td>
      <td colspan="26"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <?php
    }
    ?>
    <tr class="noborder" style="height:0px; padding:0px;">
      <?php
      for ($i=0; $i <= 35; $i++) {
      ?>
      <td style="height:0px; padding:0px;"> </td>
      <?php
      }
      ?>
    </tr>
  </tbody>
