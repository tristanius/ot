<p>

  <table class="mytabla">
    <caption>Movimientos</caption>
    <thead>
      <tr>
        <?php foreach ($log->list_fields() as $value): ?>
          <td><?= $value ?></td>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($log->result() as $key => $value): ?>
        <tr>
          <?php foreach ($value as $k => $v): ?>
            <td><?= $v ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</p>
