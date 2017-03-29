<?php
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$nombre.'.xls"');
  header('Cache-Control: max-age=0');
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<table class="mytabla" border='1'>
  <thead>
    <tr style="background:#1586bf; color:#FFF">
      <?php foreach ($rows->list_fields() as $val): ?>
        <th> <?= str_ireplace('_',' ',$val)  ?> </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows->result() as $key => $value): ?>
      <?php $r = json_decode($value->responsable_pyco); $i=0; ?>
      <tr style="max-height: 45px;" height="45">
        <?php foreach ($value as $k => $v): ?>
            <?php $i++; ?>
            <?php if ($k == "responsable_pyco" ): ?>
              <td> <?= $r->pyco ?> </td>
            <?php elseif($k == "ing_residente" || $k == "facturador"): ?>
              <td> <?= $r->$k ?></td>
            <?php elseif($i>=25 && $i<=41): ?>
              <td> <?= number_format($v*1,2) ?></td>
            <?php else: ?>
              <td><?= $v ?></td>
            <?php endif; ?>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
