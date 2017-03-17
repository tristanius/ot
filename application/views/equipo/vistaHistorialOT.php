<div style="background:#FFF">
  <div>
    <button type="button" onclick="$('#consultaEquipo').toggleClass('nodisplay');" class="btn orange mini-btn"> Cerrar </button>
  </div>
  <table>
    <caption>Resument por equipo</caption>
    <thead>
      <tr>
        <th>Equipo siesa</th>
        <th>Orden</th>
        <th>Fecha de registro a la OT</th>
        <th>Codigo item</th>
        <th>Descripcion item</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows->result() as $key => $value): ?>
        <tr>
          <td><?= $value->codigo_siesa ?></td>
          <td><?= $value->nombre_ot ?></td>
          <td><?= $value->fecha_registro ?> </td>
          <td><?= $value->itemc_item ?></td>
          <td><?= $value->descripcion ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
