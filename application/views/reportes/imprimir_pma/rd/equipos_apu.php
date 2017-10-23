
<table border="1">
  <thead>
    <tr>
      <th colspan="19">EQUIPO</th>
      <th colspan="16">ACTIVIDAD DE MANTENIMIENTO</th>
    </tr>
    <tr>
      <th colspan="2">CODIGO</th>
      <th colspan="6">DESCRIPCION</th>
      <th colspan="1">BAS.</th>
      <th colspan="1">VAR.</th>
      <th colspan="1">BASE</th>
      <th colspan="1">UND.</th>
      <th colspan="1">CANT.</th>
      <th colspan="2">ESTADO</th>
      <th colspan="2">PLACA</th>
      <th colspan="2">No. HORAS</th>
      <th colspan="2">CODIGO</th>
      <th colspan="8">ACTIVIDAD DE MANTENIMIENTO</th>
      <th colspan="2">UNIDAD</th>
      <th colspan="2">CANT.</th>
      <th colspan="2">ACUM.</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $rows = combinarEquiposReporte( $equipos, $apu);
    foreach ($rows as $key => $r): ?>
      <tr>
        <td colspan="2"><?= !isset( $r["e"] )?" - ":$r["e"]->itemc_item ?></td>
        <td colspan="6"><?=  !isset( $r["e"] )?" - ":$r["e"]->descripcion ?></td>
        <td colspan="1"> <?= !isset( $r["e"] )?" - ":( $r["e"]->BO=="B")?"SI":"NO"; ?> </td>
        <td colspan="1"> <?= !isset( $r["e"] )?" - ":( $r["e"]->BO=="O")?"SI":"NO"; ?> </td>
        <td colspan="1"> </td>
        <td colspan="1"> <?=  !isset( $r["e"] )?" - ":$r["e"]->unidad ?> </td>
        <td colspan="1"> <?=  !isset( $r["e"] )?" - ":$r["e"]->cantidad*1 ?></td>
        <td colspan="2"> <?=  !isset( $r["e"] )?" - ":$r["e"]->horas_operacion>0?"Operativo": (  $r["e"]->horas_disponible?"Disponible": (  $r["e"]->varado?"Varado":" - " ) ); ?> </td>
        <td colspan="2"> <?=  !isset( $r["e"] )?" - ":$r["e"]->referencia ?> </td>
        <td colspan="2"> <?=  !isset( $r["e"] )?" - ":$r["e"]->horas_operacion>0? $r["e"]->horas_operacion: $r["e"]->horas_disponible ?> </td>
        <td colspan="2"> <?= !isset( $r["a"] )?" - ":$r['a']->itemc_item ?> </td>
        <td colspan="8"> <?= !isset( $r["a"] )?" - ":$r['a']->descripcion ?> </td>
        <td colspan="2"> <?= !isset( $r["a"] )?" - ":$r['a']->unidad ?> </td>
        <td colspan="2"> <?= !isset( $r["a"] )?" - ":$r['a']->cantidad*1 ?> </td>
        <td colspan="2"> <?= !isset( $r["a"] )?" - ":$r['a']->acumulado+($r['a']->cantidad*1) ?> </td>
      </tr>
    <?php endforeach; ?>
    <?php
    for ($i=0; $i <= (7-sizeof($equipos)); $i++) {
    ?>
      <tr>
        <td colspan="2"></td>
        <td colspan="6"></td>
        <td colspan="1"></td>
        <td colspan="1"></td>
        <td colspan="1"></td>
        <td colspan="1"></td>
        <td colspan="1"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="8"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>
