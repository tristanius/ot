<table class="mytabla" border='1'>
  <tbody>
    <?php foreach ($filas as $key => $value): ?>
      <tr>
        <?php foreach ($value as $k => $v): ?>
          <td >
            <?= $v ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
