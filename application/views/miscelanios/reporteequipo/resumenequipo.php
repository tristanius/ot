<?php
if(!$nodownload){
  //header('Content-Type: application/vnd.ms-excel');
  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  //header("Content-type:   application/x-msexcel; charset=utf-8");
  header('Content-Disposition: attachment;filename="reporteMensualEquipo.xls"');
  header('Cache-Control: max-age=0');
}
?>

<meta http-equiv="Content-type" content="application/excel; charset=utf-8" />
<style>
.f12{
  font-size: 12px;
}
.f14{
  font-size: 14px;
}
.f18{
  font-size: 18px;
}
.thT {
  background-color:#ccc;
}
</style>
<table border='0'>
  <thead>
     <tr><th colspan="37" class="f18">TERMOTECNICA COINDUSTRIAL</th></tr>
     <tr><th colspan="37" class="f12">PROYECTO DE MANTENIMIENTO MA-0032887</th></tr>
     <tr><th colspan="37" class="f12">RESUMEN MENSUAL DE EQUIPOS</th></tr>
     <tr><th colspan="37" class="f12">Periodo del <b><?= $inicio ?></b> al <b><?= $final ?></b></th></tr>
   </thead>
</table>

<table border='1'>
  <thead>
     <tr>
      <th class="thT">BASE</th>
      <th class="thT">CODIGO</th>
      <th class="thT">IDENTIFICACION</th>
      <th class="thT">DESCRIPCION DEL EQUIPO</th>
      <th class="thT">TIPO</th>
      <?php
        for ($i=1; $i<=31 ; $i++) {
          echo "<th class='thT'>".$i."</th>";
      }
      ?>
      <th class="thT">TOTAL MES</th>
      <th class="thT">ASIGNACION</th>
      <th class="thT">PROPIO</th>
      <th class="thT">FRENTE</th>
    </tr>
  </thead>
      <tbody>
        <?php
          $bg=true;
          $n = 5;
          $equipo_ant="";
          $equipo_act="";
        ?>
        <?php foreach ($rows->result() as $key => $fila): ?>
            <?php
              $equipo_act = $fila->codigo_siesa;
              if($equipo_act != $equipo_ant){
                  $bg = !$bg;
              }
              if ($bg){
                $bgcolor='#ddd';
              }else{
                $bgcolor='#fff';
              }
              $equipo_ant=$equipo_act;
              $n++;
            ?>
            <tr style='background-color:<?= $bgcolor ?>' >
            <?php foreach ($fila as $k => $v): ?>
              <?php if ( !($k>='v01' and $k<='v31') ): ?>
                <?php
                  switch ($k) {
                    case 'base':
                      echo "<td rowspan='2'>";
                      break;
                    case 'codigo':
                      echo "<td rowspan='2'>";
                      break;
                    case 'nombre_frente':
                      echo "<td rowspan='2'>";
                      break;
                    case 'propio':
                      echo "<td rowspan='2'>";
                      break;
                    case 'asignacion':
                      echo "<td rowspan='2'>";
                      break;
                    case 'd01':
                      echo "<td><b>HRT</b></td><td>";
                      break;
                    case 's01':
                      echo "<td><b>EST</b></td><td>";
                      break;
                    default:
                      echo '<td>';
                      break;
                  }
                  if ($k>='s01' and $k<='s31'){
                      $tempV='v'.substr($k,1,2);
                      if ($fila->$tempV>0){
                        echo 'V';
                      }else{
                        echo ($v>0)?'D':'';
                      }
                      if ($k == 's31') {
                        $n++;
                        echo '</td><td>=contar.si(f'.$n.':aj'.$n.';"=D")';
                      }
                  }elseif ($k>='d01' and $k<='d31'){
                      $v = $v * 1;
                      $v = is_float($v)?number_format($v,2):number_format($v);
                      echo  ($v>0)?'<b>'.$v.'</b>':'';
                      if ($k=='d31') {
                        echo "</td><td>=suma(f".$n.":aj".$n.")";
                      }
                  }else{
                      echo  $v;
                  }
                  echo "</td>";
                  if($k == 'nombre_frente'){
                    echo "</tr> <tr style='background-color:".$bgcolor."'>";
                  }
              ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
</table>
<div class="f12"><b>OBSERVACIONES:</b> <b>HRT:</b> HORAS TRABAJADAS, <b>EST:</b> ESTADO DEL EQUIPO, EL CUAL PUEDE SER: DISPONIBLE (<b>D</b>), VARADO (<b>V</b>)</div>
