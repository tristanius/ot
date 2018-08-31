<?php $xid = rand(); ?>
<p>La tarifa(*) vista en este informe suele ser generalmente de la mas reciente vigencia de tarifas.</p>
<table id="resumenItemsGeneral<?= $xid ?>" class="mytabla font12 striped">
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
      <th>Facturable (Plan.) </th>
      <th>Planeado</th>
      <th>Cant. Fact.</th>
      <th>Cant. No Fact.</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($general->result() as $key => $item): ?>
      <tr class="<?= ($item->facturable=='SI' && ($item->cantidad_ejecuda_fact > $item->cantidad_planeada) )? 'red lighten-4':'' ?>">
        <td><?= $item->nombre_ot ?></td>
        <td><?= $item->item ?></td>
        <td><?= $item->codigo ?></td>
        <td>
          <div class="">
            <?= $item->descripcion ?>
          </div>
        </td>
        <td class="right-align"><?= number_format( $item->tarifa, 2) ?></td>
        <td><?= $item->cantidad ?></td>
        <td><?= $item->duracion ?></td>
        <td><?= $item->facturable ?></td>
        <td><?= $item->cantidad_planeada ?></td>
        <td class="<?= $item->facturable=='SI'?'':'grey lighten-2' ?>"><?= $item->cantidad_ejecuda_fact ?></td>
        <td class="<?= $item->facturable=='SI'?'grey lighten-2':'' ?>">
          <span class="<?= ($item->facturable!='SI' && ($item->cantidad_ejecuda_nofact > $item->cantidad_planeada) )? 'red-text':'' ?>"><?= $item->cantidad_ejecuda_nofact ?></span>
        </td>
        <td></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<button type="button" class="btn green" ng-click="exportar_tabla('#resumenItemsGeneral<?= $xid ?>')" >Exportar</button>
