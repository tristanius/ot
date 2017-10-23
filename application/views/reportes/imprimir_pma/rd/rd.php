<?php
  if($export==TRUE){
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="prueba.xls"');
    header('Cache-Control: max-age=0');
  }
?>
<!DOCTYPE html>
<html>
  <?php $this->load->view('reportes/imprimir_pma/rd/head'); ?>
  <body>
    <script type="text/php">
    if ( isset($pdf) ) {
      $font = $fontMetrics->get_font("Helvetica");
      $size = 7;
      $y = $pdf->get_height() - 25;
      $x = 30;//$pdf->get_width() - 15 - $fontMetrics->get_text_width("1/1", $font, $size);
      $pdf->page_text($x, $y, " Pagina {PAGE_NUM} de {PAGE_COUNT} ", $font, $size);
    }
    </script>
    <?php
    $this->load->view('reportes/imprimir_pma/rd/header', array('r'=>$r, 'json_r'=>$json_r) );
    $this->load->view('reportes/imprimir_pma/rd/personal', array( 'personal'=>$recursos->personal ) ); //, array('personal' => $recusos->personal  ) );
    $this->load->view('reportes/imprimir_pma/rd/equipos_apu', array( 'equipos' => $recursos->equipos, 'apu'=>$recursos->actividades ) ); //, array('equipos' => $recursos->equipos, 'apu'=>$recursos->apu  ) );
    ?>
    <br>
    <?php
    $this->load->view('reportes/imprimir_pma/rd/info_adicional', array('json_r'=>$json_r));
    ?>
  </body>
</html>
