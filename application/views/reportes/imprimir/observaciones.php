<table class="font7 nocenter">
  <thead style="background:#EEE;">
    <tr>
      <th style="width:50%">Observaciones del Contratista</th>
      <th style="width:50%">Observaciones del Cliente</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($observaciones as $key => $v): ?>
      <tr>
        <td style="width:50%;"> <p><?= $v->msj ?></p> </td>
        <td style="width:50%"></td>
      </tr>
    <?php endforeach; ?>
    <?php
    for ($i=0; $i <= (1 -  sizeof($observaciones) ); $i++) {
    ?>
    <tr>
      <td> </td>
      <td> &nbsp;</td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
<table class="font9 nocenter">
  <thead style="background:#EEE">
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
