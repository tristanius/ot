<?php
if(!$nodownload){
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="reporteMensualPersonal.xls"');
  header('Cache-Control: max-age=0');
}
?>

<meta http-equiv="Content-type" content="application/excel; charset=utf-8" />
<style>
table tr td, table tr th{
  border: 1px solid #AAA;
}
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
  background-color:#DDD;
  text-align:center;
}
<?php
	$nDias	= (strtotime($inicio)-strtotime($final))/86400;
	$nDias 	= abs($nDias)+1; $nDias = floor($nDias);
?>
</style>
<table border='0'>
  <thead>
     <tr><th colspan="<?= $nDias+6 ?>" class="f18">TERMOTECNICA COINDUSTRIAL</th></tr>
     <tr><th colspan="<?= $nDias+6 ?>" class="f12">PROYECTO DE MANTENIMIENTO MA-0032887</th></tr>
     <tr><th colspan="<?= $nDias+6 ?>" class="f12">RESUMEN MENSUAL DE PERSONAL</th></tr>
     <tr><th colspan="<?= $nDias+6 ?>" class="f12">Periodo del <b><?=$inicio ?></b> al <b><?=$final ?></b></th></tr>
   </thead>
</table>

<table border='1'>
  <thead>
     <tr>
      <th class='thT'>BASE</th>
      <th class='thT'>CODIGO</th>
      <th class='thT'>IDENTIFICACION</th>
      <th class='thT'>NOMBRE</th>
      <th class='thT'>OT</th>
      <?php
        for ($i=1; $i<=$nDias ; $i++) {
          echo "<th class='thT'>".$i."</th>";
      }
      ?>
      <th class='thT'>TOTAL MES</th>
      </tr>
  </thead>
      <tbody>
        <?php
          $fila=5;
          $SWper=true;
          $per_ant="";
          $PerAct="";
          foreach ($lashoras->result() as $key => $valoresFila):
              $PerAct = $valoresFila->identificacion;
              if($PerAct != $per_ant){
                  $SWper = !$SWper;
              }
              if ($SWper){
                  $bgcolor='#DDD';
               }else{
                  $bgcolor='#fff';
               }
               $per_ant=$PerAct;
               $fila++;
          ?>
            <tr style="background-color:<?= $bgcolor; ?>;" >
            <?php
            $contador = 0;
            foreach ($valoresFila as $k => $v):
                $ultimoDia='d'.$nDias;
                if ($k>='d01' and $k<='d31'){
                    if ($k<=$ultimoDia){
                      echo  "<td><b>";
                      switch ($v) {
                        case 1:
                          echo "<span style='color:#275b1f'>1</span>";
                          $contador++;
                          break;
                        case 2:
                          echo "<span style='color:brown'>1</span>";
                          $contador++;
                          break;
                        case 3:
                          echo "<span style='color:#275b1f'>D</span>";
                          $contador++;
                          break;
                        case 4:
                          echo "<span style='color:brown'>D</span>";
                          $contador++;
                          break;
                        case 5:
                          echo "AP";
                          $contador++;
                          break;
                        case 6:
                          echo "AS";
                          $contador++;
                          break;
                        case 7:
                          echo "IC";
                          $contador++;
                          break;
                        case 8:
                          echo "<span style='color:red'>I</span>";
                          $contador++;
                          break;
                        case 9:
                          echo "V";
                          $contador++;
                          break;
                        case 10:
                          echo "A";
                          //$contador++;
                          break;
                        case 11:
                          echo "S";
                          //$contador++;
                          break;
                        case 20:
                          echo "";
                          break;
                        default:
                          echo  ($v>0?$v:'');
                      }
                      echo  "</b></td>";
                    }
                }else{
                    echo  "<td>".$v."</td>";
                }
            endforeach;
            echo  "<td>".$contador."</td>";
            ?>
            </tr>
        <?php endforeach; ?>
      </tbody>
</table>
