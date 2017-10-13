<table border="1">
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
        <th rowspan="3" colspan="6"></th>
        <th colspan="29" class="f16">REPORTE DIARIO OT <?= $r->nombre_ot ?></th>
      </tr>
      <tr>
        <th colspan="29" class="f16">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="2">CODIGO</th>
        <th colspan="7">P135-PYC-ADM-16-13-007</th>
        <th>&nbsp;</th>
        <th colspan="14">version: 1.0</th>
        <th colspan="2">Hoja</th>
        <th>&nbsp;</th>
        <th>de</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <th colspan="4">FECHA:</th><th colspan="10"> <?= date('d/m/Y', strtotime( $r->fecha_reporte ) ) ?> </th>
        <th>&nbsp;</th>
        <th colspan="4">FESTIVO:</th><th colspan="7"> <?= $r->festivo?"SI":"NO"; ?> </th>
        <th>&nbsp;</th>
        <th colspan="2">ESPECIALIDAD:</th><th colspan="6"></th>
      </tr>
      <tr>
        <th colspan="4">No. OT SAP:</th><th colspan="10"></th>
        <th>&nbsp;</th>
        <th colspan="4"></th><th colspan="7"></th>
        <th>&nbsp;</th>
        <th colspan="2">BASE:</th><th colspan="6"></th>
      </tr>

      <tr>
        <th colspan="4">LUGAR DE LOS TRABAJOS :</th><th colspan="10">&nbsp;</th>
        <th>&nbsp;</th>
        <th colspan="4">COORDENADA:</th><th colspan="7"></th>
        <th>&nbsp;</th>
        <th colspan="2">TIPO DE MTTO:</th><th colspan="6"></th>
      </tr>
  </thead>
</table>
