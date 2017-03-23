<table cellspacing="0">
  <thead>
    <tr>
      <th style="border:1px solid #888; font-size: 11px;">Orden</th>
      <th style="border:1px solid #888; font-size: 11px;">Item</th>
      <th style="border:1px solid #888; font-size: 11px;">Codigo f.</th>
      <th style="border:1px solid #888; font-size: 11px;">Descripción</th>
      <th style="border:1px solid #888; font-size: 11px;">Sector/Línea</th>
      <th style="border:1px solid #888; font-size: 11px;">Facturable</th>
      <th style="border:1px solid #888; font-size: 11px;">Cantidad Planeada total</th>
      <th style="border:1px solid #888; font-size: 11px;">Cantidad cantidad ejecutanda</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
      <?php if ($item->facturable && $item->cantidad_planeada < $item->cant_ejecutada): ?>
        <tr>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->nombre_ot ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->itemc_item ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->codigo ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->descripcion ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->idsector_item_tarea ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->facturable?"Sí":"No"; ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->cantidad_planeada ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->cant_ejecutada?></td>
        </tr>
      <?php elseif (!$item->facturable && $item->cantidad_planeada < $item->cant_ejecutada_nofact): ?>
        <tr>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->nombre_ot ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->itemc_item ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->codigo ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->descripcion ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->idsector_item_tarea ?></td>
          <td style="border:1px solid #888; font-size: 11px; color:blue"><?= $item->facturable?"Sí":"No"; ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->cantidad_planeada ?></td>
          <td style="border:1px solid #888; font-size: 11px;"><?= $item->cant_ejecutada_nofact ?></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>

<br>
