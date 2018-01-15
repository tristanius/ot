<table border="1">
  <thead>
    <tr>
      <th rowspan="2" colspan="2">
          <img src="<?= base_url('assets/img/pma.png') ?>" style="width:100px">
      </th>
      <th rowspan="2" colspan="7" class="f16">REPORTE DE PERSONAL TIEMPO LABORADO</th>
      <th colspan="1">Version: 1.0</th>
    </tr>
    <tr>
      <th colspan="1">Código:<br>P135-PYC-ADM-16-13-080</th>
    </tr>
    <tr>
      <th colspan="4">FECHA</th>
      <th colspan="2">NOMBRE DEL SUPERVISOR O LIDER DEL FRENTE:</th>
      <th colspan="4"></th>
    </tr>
    <tr>
      <th colspan="2">DIA</th>
      <th colspan="1">MES</th>
      <th colspan="1">AÑO</th>
      <th colspan="1" rowspan="2">LUGAR DE TRABAJO</th>
      <th colspan="1" rowspan="2"><?= isset($r->vereda)?$r->vereda:''; ?></th>
      <th colspan="2" rowspan="2">No. ORDEN DE TRABAJO:</th>
      <th colspan="2" rowspan="2"> <?= $r->nombre_ot ?> </th>
    </tr>
    <tr>
      <th colspan="2"><?= date('d', strtotime($r->fecha_reporte) ) ?></th>
      <th colspan="1"><?= date('m', strtotime($r->fecha_reporte) ) ?></th>
      <th colspan="1"><?= date('Y', strtotime($r->fecha_reporte) ) ?></th>
    </tr>
  </thead>
</table>
