<?php
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xls"');
  header('Cache-Control: max-age=0');
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<table class="mytabla" border='1'>
  <thead>
    <tr>
      <th>Comentario</th>
      <th>Orden</th>
      <th>Item</th>
      <th>Descripción</th>
      <th>activo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($equipos->result() as $key => $value): ?>

      <?php
      for ($i=0; $i <= ( $value->cantidad-1 ) ; $i++) {
      ?>
      <tr>
        <td></td>
        <td><?= $value->nombre_ot ?></td>
        <td><?= $value->itemc_item ?></td>
        <td><?= $value->descripcion ?></td>
        <td> </td>
      </tr>
      <?php
      }
      ?>

    <?php endforeach; ?>
  </tbody>
</table>
