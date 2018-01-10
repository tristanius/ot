  <thead style="background: #FEFEFE">
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
    <?php
    $x=1;
    foreach ($recursos->equipos as $key => $e): ?>
      <tr>
        <td colspan="1"> <?= $x++; ?></td>
        <td colspan="3"> <?= $e->itemc_item ?>  </td>
        <td colspan="8"> <?= $e->descripcion ?> </td>
        <td colspan="1"> <?= ($e->BO=="B")?"SI":"" ?> </td>
        <td colspan="1"> <?= ($e->BO=="O")?"SI":"" ?> </td>
        <td colspan="5">  </td>
        <td colspan="1"> <?= $e->unidad ?> </td>
        <td colspan="1"> <?= $e->cantidad*1 ?> </td>
        <td colspan="4"> <?= ($e->horas_operacion>0) ? "Operativo" : ( ($e->horas_disponible>0) ? "Disponible" : ( ($e->varado==TRUE) ? "Varado" : " - " ) ) ?> </td>
        <td colspan="4"> <?= $e->referencia ?> </td>
        <td colspan="2"> <?= $e->horometro_ini ?> </td>
        <td colspan="2"> <?= $e->horometro_fin ?> </td>
        <td colspan="1"> <?= $e->horas_operacion ?> </td>
        <td colspan="1"> <?= $e->horas_disponible ?> </td>
        <td colspan="1"> <?= $e->varado?"SI":"" ?> </td>
      </tr>
    <?php endforeach; ?>

    <?php
    for ($i=0; $i <= ( 5-sizeof($recursos->equipos) ) ; $i++) {
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
  </tbody>
