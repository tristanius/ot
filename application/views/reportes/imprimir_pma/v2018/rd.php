<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <head>
      <meta charset="utf-8">
      <style media="screen">
        @page {
          margin: 27px;
          margin-top: 170px;
          margin-left: 45px;
        }
        body { margin: 0px; font-family: 'Helvetica';}
        table{
          width: 100%;
          max-width: 100%;
          border-collapse: collapse;
        }
        table  table tr td, table  table tr th{
            border: 1px solid #000;
        }
        table, td, th {
          vertical-align: top;
          min-width: 4ex;
        }
        #cabecera{
          position: fixed;
          background: #FFF;
          left: 0px;
          right: 0px;
          top: -140px;
          border: 1px solid #111;
        }
        #lateral{
          position: fixed;
          left: -15px;
          top: 0px;
          width: 15px;
          font-size: 6px;
        }
        .texto-central{
          text-align: center;
        }
        .texto-vertical-1 {
          writing-mode: vertical-lr;
          transform: rotate(180deg);
        }
        .texto-vertical-2 {
          word-wrap: break-word;
          text-align:center;
        }
        .font10 {
          font-size: 10px;
        }
        .font9, .font9 *{
          font-size: 9px;
        }
        .font8, .font8 *{
          font-size: 8px;
        }
        .font7, .font7 *{
          font-size: 7px;
        }
        .font6, .font6 *{
          font-size: 6px;
        }
        .right-align{
          text-align: right;
        }
        table tr.noborder{
          border: none;
        }
        .table-container{
          padding: 0px;
        }
        table.no-border tr, table.no-border tr td{
          border: none;
          border-color: #FFF;
        }
      </style>
    </head>
    <title></title>
  </head>
  <body>
    <script type="text/php">
    if ( isset($pdf) ) {
      $font = $fontMetrics->get_font("Helvetica");
      $size = 5;
      $y = $pdf->get_height() - 22;
      $x = 30;//$pdf->get_width() - 15 - $fontMetrics->get_text_width("1/1", $font, $size);
      $pdf->page_text($x, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT} ", $font, $size);
    }
    </script>
    <?php $this->load->view('reportes/imprimir_pma/v2018/header.php'); ?>
      <?php
      $this->load->view('reportes/imprimir_pma/v2018/personal', array('recursos'=>$recursos));
      $this->load->view('reportes/imprimir_pma/v2018/equipos', array('recursos'=>$recursos));
      $this->load->view('reportes/imprimir_pma/v2018/actividades', array('recursos'=>$recursos));
    ?>
    <?php $this->load->view('reportes/imprimir_pma/v2018/observaciones', array('observaciones'=>$json_r->observaciones, 'json_r'=>$json_r)); ?>
  </body>
</html>
