<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="InformeReportes.xls"');
header('Cache-Control: max-age=0');
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
            xmlns:w="urn:schemas-microsoft-com:office:excel"
            xmlns="http://www.w3.org/TR/REC-html40">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  </head>
  <body>

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
              <td style="min-width:15px">
                <?php
                if ($k != 'cantidad') {
                  echo ($k=='tipo' && ($v == '' || $v == NULL) )? 'Actividad' :$v;
                }else{
                  $v = $v * 1;
                  $v = is_float($v)?number_format($v,2):number_format($v);
                  echo  ($v>0)?'<b>'.$v.'</b>':'';
                }
                ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </body>
</html>
