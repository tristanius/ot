<?php
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$nombre.'.xls"');
  header('Cache-Control: max-age=0');
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<table class="mytabla" border='1'>
  <thead>
    <tr>
      <?php foreach ($rows->list_fields() as $val): ?>
        <th> <?= $val ?> </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows->result() as $key => $value): ?>
      <tr>
        <?php foreach ($value as $k => $v): ?>
          <td >
            <?= $v ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
