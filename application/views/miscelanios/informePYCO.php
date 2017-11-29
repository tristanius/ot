<?php
if(!$nodownload){
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="informePYCO.xls"');
  header('Cache-Control: max-age=0');
}
?>

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<table border='1'>
  <thead>
    <tr>
      <th>ORDEN</th>
      <th>TAREA</th>
      <th>SAP inicial</th>
      <th>Clase SAP</th>
      <th>SAP principal</th>
      <th>Clase SAP Princ.</th>
      <th>BASE</th>
      <th>VEREDA</th>
      <th>DESCRIPCION</th>
      <th>CUENTA MAYOR</th>
      <th>ESPECIALIDAD</th>
      <th>MEMORADOS</th>
      <th>FECHA INICIO OT</th>
      <th>FECHA FIN OT</th>
      <th>ESTADO</th>
      <th>F. INICIO FACT.</th>
      <th>F. FIN FACT.</th>

      <th>RESP. PYCO</th>
      <th>Ing. RESIDENTE</th>
      <th>GESTOR TECNICO (ECP)</th>
      <th>CARGO GESTOR TECNICO</th>
      <th>REGISTRO GESTOR TECNICO</th>
      <th>FACTURADOR</th>

      <th>OT FIRMADA</th>
      <th>OT SAP LIBERADA</th>
      <th>ACTA ACLARATORIA</th>
      <th>ACTA DE INICIO</th>
      <th>MATRIZ RAM</th>
      <th>AR</th>
      <th>MEMORANDO REEEMBOLSABLES</th>
      <th>FIRMADO	CRONOGRAMA</th>
      <th>PDT</th>
      <th>DISEÑOS</th>
      <th>PERMISOS INMOBILIARIOS</th>
      <th>PERMISOS AMBIENTALES</th>
      <th>SOCIALIZACION</th>
      <th>VISTA PRELIMINAR</th>

      <th>ACTIVIDAD DE MANTENIMIENTO</th>
      <th>PERSONAL</th>
      <th>EQUIPO</th>
      <th>COSTO DIRECTO</th>
      <th>AIU</th>
      <th>GASTOS DE VIAJE</th>
      <th>HORAS EXTRAS</th>
      <th>RACIONES</th>
      <th>AIU (4.58%)</th>
      <th>REEMBOLSABLES</th>
      <th>AIU (1%)</th>
      <th>TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows->result() as $v): ?>
      <tr>
        <td><?= $v->nombre_ot ?></td>
        <td><?= $v->nombre_tarea ?></td>
        <td><?= $v->sap_inicial ?></td>
        <td><?= $v->clase_sap ?></td>
        <td><?= $v->sap_principal ?></td>
        <td><?= $v->clase_sap_principal ?></td>
        <td><?= $v->nombre_base ?></td>
        <td><?= $v->vereda ?></td>
        <td><?= $v->actividad ?></td>
        <td><?= $v->cuenta_mayor ?></td>
        <td><?= $v->nombre_especialidad ?></td>
        <td><?= $v->memorandos ?></td>
        <td><?= $v->fecha_inicio ?></td>
        <td><?= $v->fecha_fin ?></td>
        <td><?= $v->estado ?></td>
        <td> </td>
        <td> </td>

        <?php $r = json_decode($v->responsables); ?>
        <td><?= isset($r->pyco)?$r->pyco:''; ?></td>
        <td><?= isset($r->ing_residente)?$r->ing_residente:''; ?></td>
        <td><?= isset($r->gestor_tecnico_ecp)?$r->gestor_tecnico_ecp:''; ?></td>
        <td><?= isset($r->cargo_gestor_tecnico)?$r->cargo_gestor_tecnico:''; ?></td>
        <td><?= isset($r->registro_gestor_tecnico)?$r->registro_gestor_tecnico:''; ?></td>
        <td><?= isset($r->facturador)?$r->facturador:''; ?></td>

        <?php $doc = json_decode($v->requisitos_documentales); ?>
        <td><?= isset($doc->OT_firmada)?$doc->OT_firmada:''; ?></td>
        <td><?= isset($doc->OT_SAP_liberada)?$doc->OT_SAP_liberada:''; ?></td>
        <td><?= isset($doc->acta_aclaratoria)?$doc->acta_aclaratoria:''; ?></td>
        <td><?= isset($doc->acta_inicio)?$doc->acta_inicio:''; ?></td>
        <td><?= isset($doc->matriz_ram)?$doc->matriz_ram:''; ?></td>
        <td><?= isset($doc->ar)?$doc->ar:''; ?></td>
        <td><?= isset($doc->memorando_reembolsables)?$doc->memorando_reembolsables:''; ?></td>
        <td><?= isset($doc->cronograma)?$doc->cronograma:''; ?></td>
        <td><?= isset($doc->pdt)?$doc->pdt:''; ?></td>
        <td><?= isset($doc->disenos)?$doc->disenos:''; ?></td>
        <td><?= isset($doc->permisos_inmobiliarios)?$doc->permisos_inmobiliarios:''; ?></td>
        <td><?= isset($doc->permisos_ambientales)?$doc->permisos_ambientales:''; ?></td>
        <td><?= isset($doc->socializacion)?$doc->socializacion:''; ?></td>
        <td><?= isset($doc->vista_preliminar)?$doc->vista_preliminar:''; ?></td>

        <td><?= number_format($v->actividades, 2, ',','.') ?></td>
        <td><?= number_format($v->personal, 2, ',','.') ?></td>
        <td><?= number_format($v->equipo, 2, ',','.' ) ?></td>
        <?php
        getFieldsPYCO($v);
        ?>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>
