<?php $xid = rand(); ?>
<p>La tarifa(*) vista en este informe suele ser generalmente de la mas reciente vigencia de tarifas.</p>
<table id="resumenItemsGeneral<?= $xid ?>" class="mytabla font12">
  <caption> <h5>Vista general de cantidades por item</h5> </caption>
  <thead>
    <tr>
      <th colspan="1">Orden</th>
      <th colspan="4">Item</th>
      <th colspan="4">Planeado</th>
      <th colspan="3">Ejecutado</th>
    </tr>
    <tr>
      <th>Orden</th>
      <th>Item</th>
      <th>Codigo</th>
      <th>Descripción</th>
      <th>Tarifa (*)</th>
      <th>Cant.</th>
      <th>Duración</th>
      <th>Planeado Fact.</th>
      <th>Planeado No Fact.</th>
      <th>Cant. Fact.</th>
      <th>Cant. No Fact.</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($general->result() as $key => $item): ?>
      <tr class="<?= ($item->planeado_fact < $item->ejecutado_fact)?'red lighten-5':''; ?>" >
        <td><?= $item->nombre_ot ?></td>
        <td><?= $item->item ?></td>
        <td><?= $item->codigo ?></td>
        <td><?= $item->descripcion ?></td>
        <td class="right-align"><?= number_format( $item->tarifa, 2) ?></td>
        <td><?= $item->cantidad ?></td>
        <td><?= $item->duracion ?></td>
        <td class="<?= ($item->planeado_fact < $item->ejecutado_fact)?'red white-text':''; ?>"> <?= $item->planeado_fact ?> </td>
        <td class="<?= ($item->planeado_no_fact < $item->ejecutado_no_fact)?'deep-orange darken-2 white-text':''; ?>"> <?= $item->planeado_no_fact ?> </td>
        <td class="<?= ($item->planeado_fact < $item->ejecutado_fact)?'red white-text':''; ?>"> <?= $item->ejecutado_fact ?> </td>
        <td class="<?= ($item->planeado_no_fact < $item->ejecutado_no_fact)?'deep-orange darken-2 white-text':''; ?>"> <?= $item->ejecutado_no_fact ?> </td>
        <td></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<button type="button" class="btn green" ng-click="exportar_tabla('#resumenItemsGeneral<?= $xid ?>')" >Exportar</button>
