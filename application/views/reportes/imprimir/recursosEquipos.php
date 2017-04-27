  <table class="font8 recursos" cellpadding="0" cellspacing="0" border="1">
    <thead style="background:#EEE">
      <tr>
        <th rowspan="2">Item</th>
        <th rowspan="2">Cod. Siesa</th>
        <th rowspan="2">Ref./AF</th>
        <th rowspan="2">Equipo</th>
        <th rowspan="2">Operador / Conductor</th>
        <th rowspan="2">Cant.</th>
        <th rowspan="2">UND</th>
        <th colspan="2">Horometro</th>
        <th colspan="3">Reporte horas</th>
      </tr>
      <tr>
        <th>Inicial</th>
        <th>Final</th>

        <th>OPER.</th>
        <th>DISP.</th>
        <th>VAR.</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recursos->equipos as $key => $v): ?>
        <?php  if(  $v->facturable || $v->print ): ?>
          <tr>
            <td><?= $v->itemc_item ?></td>
            <td><?= ltrim($v->codigo_siesa, '0') ?></td>
            <td><?= $v->referencia ?></td>
            <td> <p><?= $v->descripcion ?></p> </td>
            <td> <span><?= $v->nombre_operador ?></span> </td>
            <td><?= ($v->cantidad == 0)?'-':$v->cantidad*1; ?></td>
            <td><?= $v->unidad ?></td>
            <td><?= $v->horometro_ini ?></td>
            <td><?= $v->horometro_fin ?></td>
            <td><?= $v->horas_operacion ?></td>
            <td><?= ($v->horas_disponible == 0)?'-':$v->horas_disponible; ?></td>
            <td><?= (isset($v->varado) && $v->varado )?'SI':''; ?></td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
