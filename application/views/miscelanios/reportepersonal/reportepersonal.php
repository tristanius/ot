<?php
if(!$nodownload){
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="reportediariotiempo.xls"');
  header('Cache-Control: max-age=0');
}
$dias_semana = array("Domingo","Lunes", "Martes","Miercoles","Jueves","Viernes","Sabado");
$horasDia=0;
$swFormato=false;
?>

<meta http-equiv="Content-type" content="application/excel; charset=utf-8" />
<style>
th,td{
    font-size: 10px;
    min-height: 20px;
    width: 30%;
}
.thCentro {
  text-align: center;
}
.f12{
  font-size: 12px;
}
.f14{
  font-size: 14px;
}
.f16{
  font-size: 16px;
}

</style>
<table border='1'>
  <thead>
    <tr>
      <th rowspan="2" colspan="3"><img src="<?= base_url('assets/img/termotecnica.jpg') ?>" width="180" height="40"></th>
      <th rowspan="2" colspan="15" class="f16">REPORTE DIARIO DE TIEMPO LABORADO</th>
      <th>BASE</th>
      <th colspan="3" class="f16"><?= $laOT->row()->base_idbase ?></th>
<?php
            switch ($laOT->row()->nombre_base) {
                case 'Ayacucho':
                  $horasDia=9;
                  break;
                case 'Galan':
                  $horasDia=9;
                  break;
                case 'Sebastopol':
                  $horasDia=9;
                  break;
                default:
                  $horasDia=8;
            }
?>
    </tr>
    <tr>
      <th>DIA</th>
      <th colspan="3" class="f14"><?= $dias_semana[$laOT->row()->dia_semana-1] ?><?= $laOT->row()->festivo?" (Fest.)":"" ?></th>
    </tr>
    <tr>
    	<th rowspan="2" colspan="2">CONTRATO: <?= $contrato->no_contrato ?></th>
        <th colspan="2">O.T. No.</th>
        <th colspan="14">DESCRIPCION DE LA O.T.</th>
        <th rowspan="2" style="width:1.3cm;">FECHA</th>
        <th style="width:0.7cm;">DD</th>
        <th style="width:0.7cm;">MM</th>
        <th style="width:0.9cm;">AA</th>
    </tr>
    <tr>
    	<th colspan="2"><?= $laOT->row()->No_OT ?></th>
        <th colspan="14"><?= $laOT->row()->actividad ?></th>
        <th><?= $laOT->row()->dia ?></th>
        <th><?= $laOT->row()->mes ?></th>
        <th><?= $laOT->row()->agno ?></th>
    </tr>

    <tr>
      <th rowspan="2" style="width:0.9cm;">ITEM</th>
      <th rowspan="2" style="width:2cm;">CEDULA</th>
      <th rowspan="2" colspan="3" style="width:6cm;">NOMBRES Y APELLIDOS</th>
      <th rowspan="2" style="width:4.5cm;">CARGO</th>
      <th colspan="2">HORA JORNADA DE LA MAÑANA</th>
      <th colspan="2">HORA JORNADA DE LA TARDE</th>
      <th colspan="6">HORAS LABORADAS</th>
      <th colspan="2">GASTOS DE VIAJES</th>
      <th rowspan="2" colspan="4" style="width:3.5cm;">FIRMA DEL TRABAJADOR</th>
    </tr>
    <tr>
      <th class="thCentro" style="width:1.5cm;">INGRESO</th>
      <th class="thCentro" style="width:1.5cm;">SALIDA</th>
      <th class="thCentro" style="width:1.5cm;">INGRESO</th>
      <th class="thCentro" style="width:1.5cm;">SALIDA</th>
      <th class="thCentro" style="width:1.2cm;">HO</th>
      <th class="thCentro" style="width:0.8cm;">HOF</th>
      <th class="thCentro" style="width:0.8cm;">HED<?=$laOT->row()->festivo?"F":"" ?></th>
      <th class="thCentro" style="width:0.8cm;">HEN<?=$laOT->row()->festivo?"F":"" ?></th>
      <th class="thCentro" style="width:0.8cm;">HRN<?=$laOT->row()->festivo?"F":"" ?></th>
      <th class="thCentro" style="width:0.8cm;">NVD</th>
      <th class="thCentro" style="width:1.1cm;">PN/RT</th>
      <th class="thCentro" style="width:1.5cm;">LUGAR</th>
    </tr>
  </thead>
      <tbody>
        <?php foreach ($elpersonal->result() as $key => $value): ?>
          <tr>
            <?php foreach ($value as $k => $v): ?>
            <?php
            switch ($k) {
                case 'nombre_completo':
                  echo "<td colspan='3'>";
                  break;
                case 'firma':
                  echo "<td colspan='4'>";
                  break;
                default:
                  echo "<td  class='thCentro'>";
            }
            if ($k=='cantidad'){
                echo $value->horas_ordinarias;
             }else{
                $swFormato=false;
                switch ($k) {
                    case 'hora_inicio':
                      $swFormato=true;
                      break;
                    case 'hora_fin':
                      $swFormato=true;
                      break;
                    case 'hora_inicio2':
                      $swFormato=true;
                      break;
                    case 'hora_fin2':
                      $swFormato=true;
                      break;
                    default:
                      $swFormato=false;
                }
                if  ($swFormato){
                      if (strpos($v,":")==0 and is_numeric($v)){
                          echo ($v==24)?"00:00":$v.":00";
                      }else{
                        echo $v;
                      }
                }else{
                  echo $v;
                }
             }
             ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
  <tfoot>
    <tr>
      <td colspan="22" style="height:30px;">
NOVEDADES:  <b>A:</b> INCAPACIDAD ACCIDENTE DE TRABAJO, <b>E:</b> INCAPACIDAD ENFERMEDAD GENERAL,  <b>P:</b> PERMISO NO REMUNERADO, <b>R:</b> PERMISO REMUNERADO, <b>F:</b> AUSENCIA NO JUSTIFICADA, <b>LR:</b> LICENCIA REMUNERADA,
CONVENCIONES: <b>OD:</b> HORA DIURNA, <b>ON:</b> HORA NOCTURNA, <b>HED:</b> HORA EXTRA DIURNA,  <b>HEN:</b> HORA EXTRA NOCTURNA, <b>NVD:</b> NOVEDADES. EN LA CASILLA P/R, <b>PN:</b> PERNOCTADO, <b>RT:</b> RETORNO.
      </td>
    </tr>
    <tr>
      <td colspan="18">OBSERVACIONES:</td>
      <td colspan="4">V.B. ING. RESIDENTE O SUPERVISOR</td>
    </tr>
    <tr>
      <td colspan="18"></td>
      <td colspan="4">NOMBRE:</td>
    </tr>
    <tr>
      <td colspan="18"></td>
      <td colspan="4">CARGO:</td>
    </tr>
    <tr>
      <td colspan="18"></td>
      <td colspan="4">FIRMA:</td>
    </tr>
  </tfoot>
</table>
<div style="text-align: right;font-size:10px;">F-QAQC-CUT-41. Rev2</div>
