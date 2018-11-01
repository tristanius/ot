<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style media="screen">
      @page {
        margin: 30px;
        margin-top: 106px;
        margin-bottom: 35;
      }
      body { margin: 0px; font-family: 'Helvetica'}
      #cabecera{
        position: fixed;
        background: #FFF;
        left: 0px;
        right: 0px;
        top: -60px;
      }
      table{
        width: 100%;
        max-width: 100%;
      }
      table  table tr td, table  table tr th{
          border: 1px solid #777;
      }
      table, td, th {
        vertical-align: top;
        text-align: center;
      }
      table.nocenter td,table.nocenter th{
        text-align: left;
      }

      table.inner, table.inner td, table.inner th{
        vertical-align: top;
      }
      table.recursos td{
        vertical-align: middle;
        min-height: 1ex;
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
        font-size: 8px;
      }
      .w5{
        width: 5em;
      }
      .w8{
        width: 18px
      }
      .w15{
        width: 15em;
      }
      .w17{
        width: 17em;
      }
      .w18{
        width: 18em;
      }
      .w20{
        width: 20em;
      }
      .w25{
        width: 25em;
      }
    </style>
  </head>
  <body>
    <script type="text/php">
    if ( isset($pdf) ) {
      $font = $fontMetrics->get_font("Helvetica");
      $size = 7;
      $y = $pdf->get_height() - 25;
      $x = 30;//$pdf->get_width() - 15 - $fontMetrics->get_text_width("1/1", $font, $size);
      $pdf->page_text($x, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT} - Status: <?= $footer." ".( isset($partial)?"*":"" ) ?> ", $font, $size);
    }
    </script>
    <?php $this->load->view('reportes/imprimir_ili/info', array('r'=>$r, 'json_r'=>$json_r)); ?>
    <?php $this->load->view('reportes/imprimir_ili/recursosActividades', array('recursos'=>$recursos)); ?>
    <?php $this->load->view('reportes/imprimir_ili/observaciones', array('observaciones'=>$json_r->observaciones, 'json_r'=>$json_r)); ?>

  </body>
</html>
