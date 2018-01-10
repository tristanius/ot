<div id="lateral">
  <img src="<?= base_url('assets/img/pma/lateral.png') ?>" style="width:100%">
  <br>
  <img src="<?= base_url('assets/img/pma/lateral.png') ?>" style="width:100%">
</div>

<table border="1" id="cabecera" class="font7">
  <thead class="font6">
    <tr>
      <th rowspan="3" colspan="4">
        <img src="<?= base_url('assets/img/pma.png') ?>" style="width:26ex">
      </th>
      <th colspan="32" class="">REPORTE DIARIO OT <?= $r->nombre_ot ?></th>
    </tr>
    <tr>
      <td colspan="32" class="centrar" >
          EJECUCION DE OBRAS Y TRABAJOS DE MANTENIMIENTO DE SISTEMAS DE TRANSPORTE DE HIDROCARBUROS DURANTE LAS VIGENCIAS 2013 AL 2018 - ZONA SUR
          CONTRATO NO. MA-0032889 Y SU ADICIONAL NO. 1 DE ECOPETROL Y EL CONTRATO DE CENIT NO. 8000002840
      </td>
    </tr>

    <tr>
      <th colspan="4">CODIGO</th>
      <th colspan="14">P135-P2001-PYC-ADM-16-13-005</th>
      <th colspan="14">version: 1.0</th>
    </tr>

    <tr style="text-align: center">
      <th colspan="4"> ORDEN DE TRABAJO No. </th>
      <th colspan="4"> ORDEN DE TRABAJO SAP </th>
      <th colspan="28"> DESCRIPCION DE LA OT: </th>
    </tr>
    <tr style="text-align: center;">
      <td colspan="4">
        <?= $r->nombre_ot ?>
        <div class="">
          <br>
        </div>
      </td>
      <td colspan="4">
        <?= $r->sap_tarea ?>
        <div class="">
          <br>
        </div>
      </td>
      <td colspan="28">
         <div style="height:22px; overflow:hidden">
           <?= $r->actividad ?>
         </div>
         <br>
      </td>
    </tr>
  </thead>
  <tbody  style="text-align: center" >
    <tr>
      <th colspan="4" class="right-align"> FECHA:</th>
      <td colspan="12"> <?= getFechaLarga( $r->fecha_reporte )  ?> </td>
      <th colspan="3" class="right-align" >FESTIVO:</th>
      <td colspan="7"> <?= $r->festivo?"SI":"NO"; ?> </td>
      <th colspan="3" class="right-align" >ESPECIALIDAD:</th>
      <td colspan="7"><?= $r->nombre_especialidad ?></td>
    </tr>
    <tr>
      <th colspan="4" class="right-align" >LUGAR DE LOS TRABAJOS :</th>
      <td colspan="12"> <?= isset($r->vereda)?$r->vereda:''; ?> </td>
      <th colspan="3" class="right-align" >PK </th>
      <td colspan="7"> <?= isset($json_r->pk)?$json_r->pk:''; ?></td>
      <th colspan="3" class="right-align" >BASE:</th>
      <td colspan="7"><?= $r->nombre_base ?></td>
    </tr>
    <tr>
      <th colspan="4" class="right-align" >Equipos intervenidos:</th>
      <th colspan="12"></th>
      <th colspan="3" class="right-align" >COORDENADA:</th>
      <td colspan="7"> <?= isset($json_r->coordenadas)?$json_r->coordenadas:''; ?></td>
      <th colspan="3" class="right-align" >TIPO DE MTTO:</th>
      <td colspan="7"><?= $r->nombre_tipo_ot ?></td>
    </tr>
    <tr style="display:none">
      <?php
      for ($i=0; $i <= 35; $i++) {
      ?>
      <td> </td>
      <?php
      }
      ?>
    </tr>
  </tbody>
</table>
