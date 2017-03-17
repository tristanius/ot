<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>

  <style media="screen">
    table td, table th{
      margin: 0;
      padding: 2px;
      border: 1px solid #333;
      font-size: 9px;
    }

    table{
      border-collapse: collapse;
      margin-bottom: 4px;
      width: 100%;
    }
    table th{
      background: #13D620;
      text-align: center;
    }
    hr.salto {
      page-break-after: always;
      border: 0;
      margin: 0;
      padding: 0;
    }
  </style>

  <?php $this->load->view('ot/imprimir/anexos/gastos_viaje'); ?>

  <hr class="salto">

  <?php $this->load->view('ot/imprimir/anexos/horas_extra'); ?>


  </body>
</html>
