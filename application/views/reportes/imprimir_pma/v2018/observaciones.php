<table class="font7" border="1" class="texto-central">
  <thead>
    <tr>
      <th>Actividades</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $x=0;
    if ( isset($json_r->actividades) ): ?>
      <?php foreach ($json_r->actividades as $key => $v): ?>
        <?php $x=$x+1; ?>
          <tr>
            <td> <?= $v->msj ?> <br> </td>
          </tr>
      <?php endforeach; ?>

    <?php endif; ?>

    <?php
    for ($i=0; $i <= (2-$x) ; $i++) {
    ?>
    <tr>
      <td> &nbsp; </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<table class="font7" border="1" class="texto-central">
  <thead>
    <tr>
      <th>Observaciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $y = 0;
    foreach ($observaciones as $key => $v): ?>
      <?php $y=$y+1; ?>
      <tr>
        <td> <?= $v->msj ?> <br> </td>
      </tr>
    <?php endforeach; ?>
    
      <tr>
        <td> &nbsp; </td>
      </tr>

  </tbody>
</table>

<table class="font7" border="1" style="">
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
<p class="font7">
  <br>
  <strong>** FIN DEL FORMATO **</strong>
</p>
