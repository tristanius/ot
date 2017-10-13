<?php
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="prueba.xls"');
  header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
  <?php $this->load->view('reportes/imprimir_pma/rd/head'); ?>
  <body>
    <?php
    $this->load->view('reportes/imprimir_pma/rd/header', array('r'=>$r, 'json_r'=>$json_r) );
    $this->load->view('reportes/imprimir_pma/rd/personal', array( 'personal'=>$recursos->personal ) ); //, array('personal' => $recusos->personal  ) );
    $this->load->view('reportes/imprimir_pma/rd/equipos_apu', array( 'equipos' => $recursos->equipos, 'apu'=>$recursos->actividades ) ); //, array('equipos' => $recursos->equipos, 'apu'=>$recursos->apu  ) );
    ?>
  </body>
</html>
