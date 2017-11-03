<?php
if($download){
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="reportediariotiempo.xls"');
  header('Cache-Control: max-age=0');
}
?>
<html>
  <?php $this->load->view('reportes/imprimir_pma/tl/head'); ?>
  <body>
    <?php
    $this->load->view('reportes/imprimir_pma/tl/header');
    $this->load->view('reportes/imprimir_pma/tl/personal', array('personal'=>$personal));
    $this->load->view('reportes/imprimir_pma/tl/footer');
    ?>
  </body>
</html>
