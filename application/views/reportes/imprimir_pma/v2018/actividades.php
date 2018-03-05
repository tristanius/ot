<table border="1" class="font7 texto-central" >
  <thead style="background: #FEFEFE">
    <tr>
      <th colspan="36">ACTIVIDADES DE MANTENIMIENTO</th>
    </tr>
    <tr>
      <th colspan="1">CODIGO</th>
      <th colspan="26">ACTIVIDAD DE MANTENIMIENTO</th>
      <th colspan="3">UNIDAD</th>
      <th colspan="3">CANTIDAD DÍA</th>
      <th colspan="3">CANTIDAD ACUMULADA</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($recursos->actividades as $key => $v): ?>
    <tr>
      <td colspan="1"> <?= $v->itemc_item ?> </td>
      <td colspan="26"> <p><?= $v->descripcion.($v->idsector_item_tarea != 1?' ('.$v->nom_sector.')':'') ?></p> </td>
      <td colspan="3"> <?= $v->unidad ?> </td>
      <td colspan="3"> <?= $v->cantidad*1 ?> </td>
      <td colspan="3"> <?= $v->acumulado+($v->cantidad*1) ?> </td>
    </tr>
    <?php endforeach; ?>
    <?php
    for ($i=0; $i <= ( 4-sizeof($recursos->actividades) ) ; $i++) {
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
  </tbody>
</table>
