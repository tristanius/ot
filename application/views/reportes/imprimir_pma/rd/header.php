<table border="1" id="cabecera">
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
        <th rowspan="3" colspan="3">
          <img src="<?= base_url('assets/img/pma.png') ?>" style="width:25ex">
        </th>
        <th colspan="32" class="f16 center">REPORTE DIARIO OT <?= $r->nombre_ot ?></th>
      </tr>
      <tr>
        <td colspan="32" class="center" >
          <small>
            EJECUCION DE OBRAS Y TRABAJOS DE MANTENIMIENTO DE SISTEMAS DE TRANSPORTE DE HIDROCARBUROS DURANTE LAS VIGENCIAS 2013 AL 2018- ZONA SUR
            CONTRATO NO. MA-0032889 Y SU ADICIONAL NO. 1 DE ECOPETROL Y EL CONTRATO DE CENIT NO. 8000002840
          </small>
        </td>
      </tr>
      <tr>
        <th colspan="3">CODIGO</th>
        <th colspan="7">P135-PYC-ADM-16-13-007</th>
        <th>&nbsp;</th>
        <th colspan="16">version: 2.0</th>
        <th colspan="2">Hoja</th>
        <th>&nbsp;</th>
        <th>de</th>
        <th>&nbsp;</th>
      </tr>
  </thead>
</table>

<table border="1" style="text-align: center">
  <tbody>
    <tr>
      <th colspan="4">FECHA:</th><td colspan="10"> <?= getFechaLarga( $r->fecha_reporte )  ?> </td>
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
  </tbody>
</table>
