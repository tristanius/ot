<table border="1" id="header">
    <thead>
      <tr style="display:none">
        <?php
        for ($i=0; $i <= 34; $i++) {
        ?>
        <td> . </td>
        <?php
        }
        ?>
      </tr>
      <tr>
        <th rowspan="3" colspan="5"></th>
        <th colspan="30" class="f16">REPORTE DIARIO OT <?= $r->nombre_ot ?></th>
      </tr>
      <tr>
        <th colspan="29" class="f16">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="2">CODIGO</th>
        <th colspan="7">P135-PYC-ADM-16-13-007</th>
        <th>&nbsp;</th>
        <th colspan="14">version: 2.0</th>
        <th colspan="2">Hoja</th>
        <th>&nbsp;</th>
        <th>de</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <th colspan="4">FECHA:</th><td colspan="10"> <?= date('d/m/Y', strtotime( $r->fecha_reporte ) ) ?> </td>
        <th>&nbsp;</th>
        <th colspan="4">FESTIVO:</th><td colspan="7"> <?= $r->festivo?"SI":"NO"; ?> </td>
        <th>&nbsp;</th>
        <th colspan="2">ESPECIALIDAD:</th><td colspan="6"><?= $r->nombre_especialidad ?></td>
      </tr>
      <tr>
        <th colspan="4">LUGAR DE LOS TRABAJOS :</th><td colspan="10"> <?= isset($r->vereda)?$r->vereda:''; ?> </td>
        <th>&nbsp;</th>
        <th colspan="4">PK </th><td colspan="7"> <?= isset($json_r->pk)?$json_r->pk:''; ?></td>
        <th>&nbsp;</th>
        <th colspan="2">BASE:</th><td colspan="6"><?= $r->nombre_base ?></td>
      </tr>

      <tr>
        <th colspan="4">Equipos intervenidos:</th><th colspan="10"></th>
        <th>&nbsp;</th>
        <th colspan="4">COORDENADA:</th><td colspan="7"> <?= isset($json_r->coordenadas)?$json_r->coordenadas:''; ?></td>
        <th>&nbsp;</th>
        <th colspan="2">TIPO DE MTTO:</th><td colspan="6"><?= $r->nombre_tipo_ot ?></td>
      </tr>
  </thead>
</table>
