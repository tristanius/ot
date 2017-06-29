<?php
if(!$nodownload){
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="reporteMensualPyco.xls"');
  header('Cache-Control: max-age=0');
}
?>

<meta http-equiv="Content-type" content="application/excel; charset=utf-8" />
<style>
.f14{
  font-size: 14px;
}
.f18{
  font-size: 18px;
}
.thTitulo {
  background-color:#ccc;
}
.centrar{
  text-align: center;
}
</style>
<table border='0'>
  <thead>
    <tr><th colspan="14" class="f18">TERMOTECNICA COINDUSTRIAL</th></tr>
    <tr>
      <th class="f14" colspan="14">REPORTE MENSUAL DE EQUIPOS</th>
    </tr>
    <tr>
      <th class="f14" colspan="14">Fecha: del <b><?=$inicio ?></b> al <b><?=$final ?></b></th>
    </tr>
  </thead>
</table>
<table border='1'>
  <thead>
    <tr class="thTitulo">
      <th>No</th>
      <th>UN</th>
      <th>TIPO</th>
      <th>FECHA</th>
      <th>OT</th>
      <th>ITEM</th>
      <th>COD. SIESA</th>
      <th>DESCRIPCION EQUIPO</th>
      <th>REFERENCIA</th>
      <th>CO</th>
      <th>UNIDAD</th>
      <th>OPERATIVO</th>
      <th>VALOR OPERATIVO</th>
      <th>STAND BY</th>
      <th>VALOR STAND</th>
      <th>HR/KM inicial</th>
      <th>HR/KM Final</th>
    </tr>
  </thead>
  <tbody>
        <?php foreach ($lashoras->result() as $key => $valoresFila): ?>
            <tr>
            <?php foreach ($valoresFila as $k => $v):
                switch($k){
                  case 'horas':
                    echo ($v==1)?'<td class="centrar"><b>'.$v.'</b></td>':'<td>'.$v.'</td>';
                    break;
                  case 'disponible':
                    echo ($v==1)?'<td class="centrar"><b>'.$v.'</b></td>':'<td>'.$v.'</td>';
                    break;
                  case 'unidad':
                    echo '<td class="centrar">'.$v.'</td>';
                    break;
                  default :
                    echo '<td> '.$v.' </td>';
                }
              endforeach;
            ?>
            </tr>
        <?php endforeach; ?>
  </tbody>
</table>
