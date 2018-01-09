  <thead>
    <tr>
      <th colspan="36">EQUIPOS</th>
    </tr>
    <tr>
      <th colspan="1" rowspan="2">REF</th>
      <th colspan="3" rowspan="2">CODIGO</th>
      <th colspan="8" rowspan="2">DESCRIPCION</th>
      <th colspan="1" rowspan="2">BAS.</th>
      <th colspan="1" rowspan="2">VAR.</th>
      <th colspan="5" rowspan="2">BASE</th>
      <th colspan="1" rowspan="2">UND.</th>
      <th colspan="1" rowspan="2">CANT.</th>
      <th colspan="4" rowspan="2">ESTADO</th>
      <th colspan="4" rowspan="2">PLACA</th>
      <th colspan="4">HORA/HOROMETRO</th>
      <th colspan="3">REPORTE HORAS</th>
    </tr>
    <tr>
      <th colspan="2">Inicial</th>
      <th colspan="2">Final</th>
      <th>Oper.</th>
      <th>Disp.</th>
      <th>Var</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="1">-</td>
      <td colspan="3"></td>
      <td colspan="8"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="5"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="4"></td>
      <td colspan="4"></td>
      <td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
    </tr>
    <?php
    for ($i=0; $i <= ( 5-sizeof($recursos->actividades) ) ; $i++) {
    ?>
    <tr>
      <td colspan="1">-</td>
      <td colspan="3"></td>
      <td colspan="8"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="5"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="4"></td>
      <td colspan="4"></td>
      <td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
    </tr>
    <?php
    }
    ?>
    <tr class="noborder" style="height:0px; padding:0px;">
      <?php
      for ($i=0; $i <= 35; $i++) {
      ?>
      <td style="height:0px; padding:0px;"> </td>
      <?php
      }
      ?>
    </tr>
  </tbody>
