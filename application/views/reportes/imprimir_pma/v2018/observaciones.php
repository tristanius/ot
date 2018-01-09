<table class="font7" border="1">
  <thead>
    <tr>
      <th>Observaciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($observaciones as $key => $v): ?>
      <tr>
        <td> <p><?= $v->msj ?></p> </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<table class="font7" border="1">
  <thead>
    <tr>
      <th>Actividades</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($observaciones as $key => $v): ?>
      <tr>
        <td> <p><?= $v->msj ?></p> </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<table class="font7" border="1">
  <thead>
    <tr>
      <th> Elaborado por </th>
      <th> Representante del contratista</th>
      <th> Representante del cliente</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Nombre: <?= isset($json_r->elaborador_nombre)?$json_r->elaborador_nombre:''; ?></td>
      <td>Nombre: <?= isset($json_r->contratista_nombre)?$json_r->contratista_nombre:''; ?></td>
      <td>Nombre: <?= isset($json_r->ecopetrol_nombre)?$json_r->ecopetrol_nombre:''; ?></td>
    </tr>
    <tr>
      <td> <br> Firma: </td>
      <td> <br> Firma: </td>
      <td> <br> Firma: </td>
    </tr>
    <tr>
      <td>Cargo: <?= isset($json_r->elaborador_cargo)?$json_r->elaborador_cargo:''; ?></td>
      <td>Cargo: <?= isset($json_r->contratista_cargo)?$json_r->contratista_cargo:''; ?></td>
      <td>Cargo: <?= isset($json_r->ecopetrol_cargo)?'':''; ?></td>
    </tr>
  </tbody>
</table>
