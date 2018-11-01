<table id="cabecera" cellpadding="0" cellspacing="0" border="1">
  <thead>
    <tr class="font10">
      <th colspan="1"> <img src="<?= base_url('assets/img/termotecnica.jpg') ?>" style="max-width: 70px" alt=""> </th>
      <th colspan="5">REPORTE DIARIO DE TIEMPO TRABAJADO Y ACTIVIDADES DE OBRA EJECUTADA</th>
      <th rowspan="1">CONTRATO: <br> MA-0032887</th>
    </tr>
  </thead>
  <tbody class="font8">
    <tr>
      <td rowspan="2"  colspan="1">
        O.T. No.:
        <div class="">
          <?= $r->nombre_ot ?>
        </div>
      </td>
      <td rowspan="2"  colspan="4">
        EJECUCIÓN DE OBRAS Y TRABAJOS DE MANTENIMIENTO DE SISTEMAS DE TRANSPORTE DE HIDROCARBUROS
      </td>
      <td rowspan="2" colspan="1" style="padding:0">
            <table style="" cellpadding="0" cellspacing="0" >
                <thead>
                  <tr>
                    <th>DD</th>
                    <th>MM</th>
                    <th>AA</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= date('d', strtotime($r->fecha_reporte)) ?></td>
                    <td><?= date('m', strtotime($r->fecha_reporte)) ?></td>
                    <td><?= date('Y', strtotime($r->fecha_reporte)) ?></td>
                  </tr>
                </tbody>
            </table>
      </td>
      <td>Día: <?= $semanadias[ date('w', strtotime($r->fecha_reporte)) ]  ?></td>
    </tr>
    <tr>
      <td>
        Festivo: <?= $r->festivo?'SI':'NO'; ?>
      </td>
    </tr>
  </tbody>
</table>

<table  class="font8" cellpadding="0" cellspacing="0" border="1">
  <thead>
    <tr style="background: #EEE">
      <th colspan="7">Descripción de actividad de la orden de trabajo</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="7"><?= substr( $r->actividad, 0, 390) ?></td>
    </tr>
  </tbody>

  <thead>
    <tr style="background: #EEE">
      <th colspan="7">Información  de localización</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        Planta/Estación:<?= isset($json_r->planta)?$json_r->planta:''; ?>
      </td>
      <td>Base: <?= $r->nombre_base ?></td>
      <td>C.O.: <?= $r->base_idbase ?></td>
      <td>K.P.: <?= isset($json_r->pk)?$json_r->pk:''; ?></td>
      <td colspan="2">Abscisa: <?= $r->abscisa ?></td>
      <td>Vereda: <?= isset($r->vereda)?$r->vereda:''; ?></td>
    </tr>
    <tr>
      <td>Municipio: <?= isset($json_r->municipio)?$json_r->municipio:$r->municipio; ?></td>
      <td colspan="1">Coordenadas GPS: <?= isset($json_r->coordenadas)?$json_r->coordenadas:''; ?></td>
      <td colspan="3">Linea: <?= isset($json_r->Linea)? $json_r->Linea: $r->nombre_especialidad ; ?></td>
      <td colspan="2">Centro Costo ECP: <?= $r->cc_ecp ?></td>
    </tr>
  </tbody>
</table>

<table class="font8" cellpadding="0" cellspacing="0" border="1">
  <thead>
    <tr style="background: #EEE">
      <th>Condiciones climaticas</th>
      <th>Noche Anterior</th>
      <th>Terreno</th>
      <th>Seguridad Ambiental</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:0">
          <table class="inner" cellpadding="0" cellspacing="0" >
            <thead>
              <tr>
                <th>Hora inicio</th>
                <th>Hora final</th>
                <th>Total horas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> <?= isset($json_r->hr_inicio_lluvia )?$json_r->hr_inicio_lluvia :' - '; ?> </td>
                <td> <?= isset($json_r->hr_fin_lluvia)?$json_r->hr_fin_lluvia:' - '; ?></td>
                <td> <?= isset($json_r->total_hr_clima)?$json_r->total_hr_clima:' - '; ?></td>
              </tr>
            </tbody>
          </table>
      </td>
      <td><?= isset($json_r->noche_anterior)?($json_r->noche_anterior):(' - '); ?></td>
      <td><?= isset($json_r->terreno)?$json_r->terreno:''; ?></td>
      <td><?= isset($json_r->seguridad_ambiental)?$json_r->seguridad_ambiental:''; ?></td>
    </tr>
  </tbody>
</table>
