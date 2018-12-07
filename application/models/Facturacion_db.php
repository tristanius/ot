<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index(){}

  public function informeFacturacion($f1=NULL, $f2=NULL, $idOT=NULL, $bases = NULL, $tipo=1)
  {
    $this->load->database('ot');
    $this->db->select( $this->consultaTipo($tipo) );
    $this->db->from('reporte_diario AS rd');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario','LEFT');
    $this->db->join('avance_reporte AS avance', 'avance.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario','LEFT');

    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');

    $this->db->join('OT', 'OT.idOT = rd.OT_idOT','LEFT');
    $this->db->join('contrato AS c', 'c.idcontrato = OT.idcontrato','LEFT');

    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf','LEFT');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc','LEFT');
    $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc','LEFT');

    $this->db->join('base as bs', 'OT.base_idbase = bs.idbase','LEFT');
    $this->db->join('tipo_ot as tp', 'OT.tipo_ot_idtipo_ot = tp.idtipo_ot','LEFT');
    $this->db->join('especialidad as sp', 'OT.especialidad_idespecialidad = sp.idespecialidad','LEFT');
    $this->db->join('tarifa AS tr', 'itf.iditemf = tr.itemf_iditemf');
    $this->db->join('vigencia_tarifas AS vg', 'tr.idvigencia_tarifas = vg.idvigencia_tarifas');
    $this->db->join('frente_ot as ft', 'ft.idfrente_ot = rrd.idfrente_ot','LEFT');
    if (isset($idOT)) {
      $this->db->where('rd.OT_idOT', $idOT);
    }
    if (isset($f1) && isset($f2)) {
      $this->db->where("rd.fecha_reporte BETWEEN '".$f1."' AND '".$f2."' ");
    }
    if (isset($bases) && sizeof($bases) > 0) {
      $this->db->where_in('bs.idbase', $bases);
    }
    $this->db->where('tr.idtarifa = (
        SELECT mytar.idtarifa
        FROM tarifa AS mytar
        JOIN vigencia_tarifas AS vig ON vig.idvigencia_tarifas = mytar.idvigencia_tarifas
        WHERE mytar.itemf_iditemf = tr.itemf_iditemf
        AND rd.fecha_reporte >= vig.fecha_inicio_vigencia
        ORDER BY mytar.idvigencia_tarifas DESC
        LIMIT 1
    )');
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
  }

  private function consultaTipo($tipo)
  {
    if( $tipo == 3 ){
      return '
        year(rd.fecha_reporte) as año,
        month(rd.fecha_reporte) as mes,
        if(day(rd.fecha_reporte)<=15,1,2) as Quincena,
        c.no_contrato as contrato,
        OT.gerencia as gerencia,
        OT.departamento_ecp as departamento_ecp,
        bs.sector as sector,
        bs.nombre_base as nombre_CO,
        OT.base_idbase as CO,
        tp.nombre_tipo_ot as tipo_mtto,
        sp.nombre_especialidad as especialidad,
        itf.codigo AS codigo,
        titc.grupo_mayor AS tipo_un,
        rd.fecha_reporte,
        IF(rd.festivo, "SI", "NO") AS festivo,
        OT.nombre_ot AS No_OT,
        IFNULL(
          (
            SELECT mytr.sap
            FROM tarea_ot AS mytr
            JOIN item_tarea_ot as item_tr ON item_tr.tarea_ot_idtarea_ot = mytr.idtarea_ot
            WHERE mytr.OT_idOT = OT.idOT
            AND item_tr.itemf_iditemf = itf.iditemf
            AND (rd.fecha_reporte BETWEEN mytr.fecha_inicio AND mytr.fecha_fin)
            GROUP BY mytr.OT_idOT DESC
            ORDER BY mytr.idtarea_ot DESC
          ), ""
        ) as numero_sap,
        "" as tarea,
        itf.itemc_item as item,
        if(titc.grupo_mayor = "actividad", "ACTIVIDAD", rot.UN) as un_asociada,
        itc.descripcion,
        itf.unidad,
        titc.descripcion as clasificacion_item,
        if(rrd.facturable,"SI","NO") AS facturable,
        rrd.cantidad AS cant_und,
        tr.tarifa,
        (rrd.cantidad * tr.tarifa) as valor_subtotal,

        IFNULL((SELECT tarea_ot.a FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.a )*(rrd.cantidad * tr.tarifa) AS subtotal_a,
        IFNULL((SELECT tarea_ot.i FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.i )*(rrd.cantidad * tr.tarifa) AS subtotal_i,
        IFNULL((SELECT tarea_ot.u FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.u )*(rrd.cantidad * tr.tarifa) AS subtotal_u,

        rrd.cc AS cc_reportado,
        OT.departamento,
        OT.municipio
      ';
    }
    elseif( $tipo == 2) {
      return '
        c.no_contrato as contrato,
        year(rd.fecha_reporte) as año,
        month(rd.fecha_reporte) as mes,
        day(rd.fecha_reporte) as dia,
        OT.nombre_departamento_ecp as nombre_departamento,
        bs.nombre_base as base,
        IFNULL(
          (
            SELECT mytr.sap
            FROM tarea_ot AS mytr
            JOIN item_tarea_ot as item_tr ON item_tr.tarea_ot_idtarea_ot = mytr.idtarea_ot
            WHERE mytr.OT_idOT = OT.idOT
            AND item_tr.itemf_iditemf = itf.iditemf
            AND (rd.fecha_reporte BETWEEN mytr.fecha_inicio AND mytr.fecha_fin)
            GROUP BY mytr.OT_idOT DESC
            ORDER BY mytr.idtarea_ot DESC
          ), ""
        ) as numero_sap,
        OT.base_idbase as CO,
        itf.codigo,
        rd.fecha_reporte,
        IF(rd.festivo, "SI", "NO") AS festivo,
        OT.nombre_ot AS No_OT,
        OT.cc_ecp as cc_cliente_ot,
        ft.nombre AS Frente_OT,
        OT.locacion as lugar,
        OT.municipio,
        OT.abscisa as pk,
        itf.itemc_item as item,
        titc.grupo_mayor AS tipo,
        rrd.cc AS cc_reportado,
        IFNULL( rot.UN, r.unidad_negocio) AS UN,
        if(titc.grupo_mayor = "actividad", "ACTIVIDAD", rot.UN) as un_asociada,
        itc.descripcion,
        if(length(titc.cl)>0,if(titc.cl="C","Convencional","Legal"),"") as conv_leg,
        if(length(titc.bo)>0,if(titc.bo="B","Basico","Opcional"),"") as clasifica_gral,
        titc.descripcion as clasificacion_item,
        if(rrd.facturable,"SI","NO") AS facturable,
        tr.tarifa,
        itf.unidad,
        rrd.cantidad,
        (rrd.cantidad * tr.tarifa) as valor_subtotal,

        IFNULL((SELECT tarea_ot.a FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.a ) AS a,
        IFNULL((SELECT tarea_ot.i FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.i ) AS i,
        IFNULL((SELECT tarea_ot.u FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.u ) AS u,

        IFNULL((SELECT tarea_ot.a FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.a )*(rrd.cantidad * tr.tarifa) AS subtotal_a,
        IFNULL((SELECT tarea_ot.i FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.i )*(rrd.cantidad * tr.tarifa) AS subtotal_i,
        IFNULL((SELECT tarea_ot.u FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.u )*(rrd.cantidad * tr.tarifa) AS subtotal_u,

        p.identificacion as cedula,
        p.nombre_completo,
        e.referencia as placa_equipo,
        e.codigo_siesa,
        if(e.referencia IS NULL, rot.codigo_temporal, e.referencia) as referencia,
        rrd.nombre_operador,
        rrd.hora_inicio AS tr1_entrada,
        rrd.hora_fin AS tr1_salida,
        rrd.hora_inicio2 AS tr2_entrada,
        rrd.hora_fin2 AS tr2_salida,
        rd.validado_pyco AS estado_reporte,
        rot.propietario_observacion AS asignacion,
        IF(rot.propietario_recurso, "Propio", "externo") AS propietario,
        IF(rot.costo_und IS NULL, tr.tarifa, IF( rot.costo_und = 0, tr.tarifa, rot.costo_und ) ) AS costo_und
      ';
    }
    else{
      return 'year(rd.fecha_reporte) as año,
        month(rd.fecha_reporte) as mes,
        if(day(rd.fecha_reporte)<=15,1,2) as Quincena,
        c.no_contrato as contrato,
        OT.nombre_departamento_ecp as nombre_departamento,
        OT.departamento_ecp as departamento_ecp,
        bs.sector as sector,
        bs.nombre_base as base,
        OT.base_idbase as CO,
        tp.nombre_tipo_ot as tipo_mtto,
        sp.nombre_especialidad as especialidad,
        itf.codigo,
        titc.grupo_mayor AS tipo_un,
        rd.fecha_reporte,
        IF(rd.festivo, "SI", "NO") AS festivo,
        OT.nombre_ot AS No_OT,
        ft.nombre AS Frente_OT,
        IFNULL(
          (
            SELECT mytr.sap
            FROM tarea_ot AS mytr
            JOIN item_tarea_ot as item_tr ON item_tr.tarea_ot_idtarea_ot = mytr.idtarea_ot
            WHERE mytr.OT_idOT = OT.idOT
            AND item_tr.itemf_iditemf = itf.iditemf
            AND (rd.fecha_reporte BETWEEN mytr.fecha_inicio AND mytr.fecha_fin)
            GROUP BY mytr.OT_idOT DESC
            ORDER BY mytr.idtarea_ot DESC
          ), ""
        ) as numero_sap,
        "" as tarea,
        OT.cc_ecp as cc_cliente_ot,
        "" as cuenta_mayor,
        "" as sistema,
        OT.abscisa as pk,
        p.identificacion as cedula,
        p.nombre_completo,
        itf.itemc_item as item,
        if(titc.grupo_mayor = "actividad", "ACTIVIDAD", rot.UN) as un_asociada,
        itc.descripcion,
        if(length(titc.cl)>0,if(titc.cl="C","Convencional","Legal"),"") as conv_leg,
        if(length(titc.bo)>0,if(titc.bo="B","Basico","Opcional"),"") as clasifica_gral,
        titc.descripcion as clasificacion_item,
        if(rrd.facturable,"SI","NO") AS facturable,
        rrd.cantidad AS cant_und,
        tr.tarifa,
        IFNULL(tr.tarifa_subcontrato,tr.tarifa) AS tarifa_subcontrato,
        itf.unidad,
        if(rrd.facturable, getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad), 0) as cantidad_total,
        if(rrd.facturable, getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) * tr.tarifa, 0) as valor_subtotal,
        if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr. tarifa, 0.18), 0) as a,
        if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.01), 0) as i,
        if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.04), 0) as u,
        if(rrd.facturable, getTotal(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.23), 0) as total,
        OT.locacion as lugar,
        OT.municipio,
        OT.zona AS zona_orden,
        rrd.cc AS cc_reportado,
        e.referencia as placa_equipo,
        rrd.horas_operacion,
        rrd.horas_disponible,
        e.codigo_siesa,
        if(e.referencia IS NULL, rot.codigo_temporal, e.referencia) as referencia,
        rrd.nombre_operador,
        rrd.hora_inicio AS tr1_entrada,
        rrd.hora_fin AS tr1_salida,
        rrd.hora_inicio2 AS tr2_entrada,
        rrd.hora_fin2 AS tr2_salida,
        rrd.hr_almuerzo,
        if(!rd.festivo, rrd.horas_ordinarias, 0) AS HO,
        if(!rd.festivo, rrd.horas_extra_dia, 0) AS HED,
        if(!rd.festivo, rrd.horas_extra_noc, 0) AS HEN,
        if(!rd.festivo, rrd.horas_recargo, 0) AS recargo_noc,
        if(rd.festivo, rrd.horas_ordinarias, 0) AS HOF,
        if(rd.festivo, rrd.horas_extra_dia, 0) AS HEDF,
        if(rd.festivo, rrd.horas_extra_noc, 0) AS HENF,
        if(rd.festivo, rrd.horas_recargo, 0) AS recargo_noc_fest,
        rrd.racion,
        rrd.gasto_viaje_pr AS pernocto,
        rrd.gasto_viaje_lugar AS lugar_gasto_viaje,
        rd.validado_pyco AS estado_reporte,
        rot.propietario_observacion AS asignacion,
        IF(rot.propietario_recurso, "Propio", "externo") AS propietario,
        IFNULL(rot.costo_und, tr.tarifa) AS costo_und,
        IFNULL( rot.UN, r.unidad_negocio) AS UN';
    }
  }

  public function sabanaActa($idfactura)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      year(rd.fecha_reporte) as año,
      month(rd.fecha_reporte) as mes,
      if(day(rd.fecha_reporte)<=15,1,2) as Quincena,
      "MA0032887" as contrato,
      OT.gerencia as gerencia,
      "" as departamento,
      OT.departamento_ecp as departamento_ecp,
      bs.sector as sector,
      bs.nombre_base as base,
      OT.base_idbase as CO,
      tp.nombre_tipo_ot as tipo_mtto,
      sp.nombre_especialidad as especialidad,
      itf.codigo,
      titc.grupo_mayor AS UN,
      rd.fecha_reporte,
      rd.festivo,
      OT.nombre_ot AS No_OT,
      IFNULL(
        (
          SELECT mytr.sap
          FROM tarea_ot AS mytr
          JOIN item_tarea_ot as item_tr ON item_tr.tarea_ot_idtarea_ot = mytr.idtarea_ot
          WHERE mytr.OT_idOT = OT.idOT
          AND item_tr.itemf_iditemf = itf.iditemf
          AND (rd.fecha_reporte BETWEEN mytr.fecha_inicio AS mytr.fecha_fin)
          GROUP BY mytr.OT_idOT DESC
          ORDER BY mytr.idtarea_ot DESC
        ), ""
      ) as numero_sap,
      OT.cc_ecp as centro_costo,
      "" as cuenta_mayor,
      "" AS sistema,
      OT.abscisa as pk,
      itf.itemc_item as item,
      itc.descripcion,
      if(length(titc.cl)>0,if(titc.cl="C","Convencional","Legal"),"") as conv_leg,
      if(length(titc.bo)>0,if(titc.bo="B","Basico","Opcional"),"") as clasifica_gral,
      titc.descripcion as clasifica_deta,
      if(rrd.facturable,"SI","NO") AS facturable,
      rrd.cantidad AS cant_und,
      tr.tarifa,
      itf.unidad,
      frrd.cantidad_total,
      frrd.subtotal,
      frrd.a,
      frrd.i,
      frrd.u,
      frrd.total,
      OT.locacion as lugar,
      OT.municipio AS municipio,
      OT.zona,
      if(e.codigo_siesa IS NULL, rot.codigo_temporal, e.codigo_siesa) as codigo_siesa,
      if(e.referencia IS NULL, rot.codigo_temporal, e.referencia) as referencia,
      rrd.nombre_operador,
      rrd.horas_operacion AS operacion_equipo,
      rrd.horas_disponible AS disponibilidad_equipo,
      p.identificacion as cedula,
      p.nombre_completo,
      if(!rd.festivo, rrd.horas_ordinarias, 0) AS HO,
      if(!rd.festivo, rrd.horas_extra_dia, 0) AS HED,
      if(!rd.festivo, rrd.horas_extra_noc, 0) AS HEN,
      if(!rd.festivo, rrd.horas_recargo, 0) AS recargo_noc,
      if(rd.festivo, rrd.horas_ordinarias, 0) AS HOF,
      if(rd.festivo, rrd.horas_extra_dia, 0) AS HEDF,
      if(rd.festivo, rrd.horas_extra_noc, 0) AS HENF,
      if(rd.festivo, rrd.horas_recargo, 0) AS recargo_noc_fest,
      rrd.racion,
      rrd.gasto_viaje_pr AS pernocto,
      rrd.gasto_viaje_lugar AS lugar_gasto_viaje,
      frrd.estado,
      frrd.acta AS no_as,
      f.no_doc AS documento_factura
      '
    );
    $this->db->from('reporte_diario AS rd');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario','LEFT');

    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');

    $this->db->join('OT', 'OT.idOT = rd.OT_idOT','LEFT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf','LEFT');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc','LEFT');
    $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc','LEFT');

    $this->db->join('base as bs', 'OT.base_idbase = bs.idbase','LEFT');
    $this->db->join('tipo_ot as tp', 'OT.tipo_ot_idtipo_ot = tp.idtipo_ot','LEFT');
    $this->db->join('especialidad as sp', 'OT.especialidad_idespecialidad = sp.idespecialidad','LEFT');

    $this->db->join('tarifa AS tr', 'itf.iditemf = tr.itemf_iditemf');
    $this->db->join('factura_recurso_reporte AS frrd','frrd.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario');
    $this->db->join('factura AS f', 'f.idfactura = frrd.idfactura');
    $this->db->join('vigencia_tarifas AS vtar', 'f.idvigencia_tarifas = vtar.idvigencia_tarifas');

    $this->db->where('f.idfactura', $idfactura);
    $this->db->where('tr.idvigencia_tarifas = vtar.idvigencia_tarifas');

    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
  }

  public function informePYCO($where=NULL)
  {
    $this->load->database('ot');
    if(isset($where)){
      $this->db->where($where);
    }
    return $this->db->select('
      OT.nombre_ot,
      tr.nombre_tarea,
      tr.sap AS sap_inicial,
      tr.clase_sap,
      tr.sap_pago AS sap_principal,
      tr.clase_sap_pago AS clase_sap_principal,
      b.nombre_base,
      if(OT.basica, "BASICA","-") AS ot_basica,
      OT.vereda,
      OT.municipio,
      OT.actividad,
      OT.estado_doc,
      OT.ot_legalizada AS legalizacion,
      OT.gerencia,
      OT.presupuesto_fecha_ini AS fecha_inicial_presupuesto,
      OT.presupuesto_porcent_ini AS porcentaje_inicial,
      OT.presupuesto_fecha_fin AS fecha_fin_presupuesto,
      OT.presupuesto_porcent_fin AS porcentaje_final,
      OT.fecha_creacion_cc,
      OT.departamento_ecp as departamento_ecp,
      OT.cc_ecp,
      "" AS cuenta_mayor,
      e.nombre_especialidad,
      "" AS memorandos,
      tr.fecha_inicio,
      tr.fecha_fin,
      OT.estado_doc AS estado,
      tr.responsables,
      tr.requisitos_documentales,
      ( SELECT SUM(itt.valor_plan) AS actividades  FROM item_tarea_ot AS itt WHERE itemf_codigo LIKE "1%"  AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE) AS actividades,
      ( SELECT SUM(itt.valor_plan) AS personal  FROM item_tarea_ot AS itt WHERE itemf_codigo LIKE "2%"  AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE) AS personal,
      ( SELECT SUM(itt.valor_plan) AS equipo  FROM item_tarea_ot AS itt WHERE itemf_codigo LIKE "3%"  AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE) AS equipo,
      tr.json_viaticos,
      tr.json_horas_extra,
      tr.json_reembolsables,
    ')->from('OT')
    ->join('tarea_ot AS tr','tr.OT_idOT = OT.idOT')
    ->join('base AS b','b.idbase = OT.base_idbase')
    ->join('especialidad AS e','e.idespecialidad = OT.especialidad_idespecialidad')
    ->order_by('tr.idtarea_ot','DESC')
    ->group_by('tr.idtarea_ot')
    ->get();
  }
  public function informeOtPyco($where=NULL)
  {
    $this->load->database('ot');
    if(isset($where)){
      $this->db->where($where);
    }
    return $this->db->select(
      '
      OT.nombre_ot,
      COUNT(tr.idtarea_ot) AS no_tareas,
      OT.clasificacion_ot AS clasificacion,
      (SELECT taot.sap FROM tarea_ot AS taot WHERE taot.OT_idOT = OT.idOT GROUP BY taot.OT_idOT) AS numero_sap,
      if(OT.basica, "BASICA","NO BASICA") AS ot_basica,
      CONCAT( b.idbase, " - ", b.nombre_base ) AS CO,
      OT.gerencia,
      esp.nombre_especialidad,
      tp.nombre_tipo_ot,
      OT.estado_doc AS estado_ot,
      (
        SELECT SUM(itt.valor_plan) FROM item_tarea_ot AS itt
        JOIN itemf ON itemf.iditemf = itt.itemf_iditemf
        WHERE itemf.tipo = 1 AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE AND tr.OT_idOT = OT.idOT
      ) AS actividad_apu,
      (
        SELECT SUM(itt.valor_plan) FROM item_tarea_ot AS itt
        JOIN itemf ON itemf.iditemf = itt.itemf_iditemf
        WHERE itemf.tipo = 2 AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE AND tr.OT_idOT = OT.idOT
      ) AS personal,
      (
        SELECT SUM(itt.valor_plan) FROM item_tarea_ot AS itt
        JOIN itemf ON itemf.iditemf = itt.itemf_iditemf
        WHERE itemf.tipo = 3 AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE AND tr.OT_idOT = OT.idOT
      ) AS equipo,
      (
        SELECT SUM(itt.valor_plan) FROM item_tarea_ot AS itt
        JOIN itemf ON itemf.iditemf = itt.itemf_iditemf
        WHERE itemf.tipo = "material" AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE AND tr.OT_idOT = OT.idOT
      ) AS material,
      (
        SELECT SUM(itt.valor_plan) FROM item_tarea_ot AS itt
        JOIN itemf ON itemf.iditemf = itt.itemf_iditemf
        WHERE itemf.tipo = "otros" AND itt.tarea_ot_idtarea_ot = tr.idtarea_ot AND itt.facturable = TRUE AND tr.OT_idOT = OT.idOT
      ) AS otros,

      IFNULL((SELECT tarea_ot.a FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.a ) AS a,
      IFNULL((SELECT tarea_ot.i FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.i ) AS i,
      IFNULL((SELECT tarea_ot.u FROM tarea_ot WHERE tarea_ot.OT_idOT = OT.idOT ORDER BY tarea_ot.idtarea_ot ASC LIMIT 1), vg.u ) AS u,

      0 AS subtotal_directo,
      0 AS subtotal_a,
      0 AS subtotal_i,
      0 AS subtotal_u,
      0 AS total,

      OT.vereda,
      OT.municipio,
      OT.actividad,
      MIN(tr.fecha_inicio) AS inicio_planeado,
      MAX(tr.fecha_fin) AS fin_planeado,
      DATEDIFF(MIN(tr.fecha_fin), MIN(tr.fecha_inicio) ) AS duracion,
      (SELECT usuario_creacion FROM reporte_diario WHERE OT_idOT = OT.idOT GROUP BY OT_idOT) AS digitador,
      (SELECT COUNT(idreporte_diario) FROM reporte_diario WHERE OT_idOT = OT.idOT ) AS cant_reportes,
      OT.presupuesto_porcent_ini AS porcentaje_utilidad_inicial,
      OT.presupuesto_porcent_fin AS porcentaje_utilidad_fin,

      OT.fecha_inicio,
      OT.fecha_fin
      '
      )->from('OT')
      ->join('tarea_ot AS tr','tr.OT_idOT = OT.idOT')
      ->join('base AS b','b.idbase = OT.base_idbase')
      ->join('especialidad AS esp','esp.idespecialidad = OT.especialidad_idespecialidad')
      ->join('tipo_ot AS tp', 'tp.idtipo_ot = OT.tipo_ot_idtipo_ot')
      ->join('vigencia_tarifas AS vg','vg.idvigencia_tarifas = tr.idvigencia_tarifas',"LEFT")
      ->order_by('OT.idOT','DESC')
      ->group_by('OT.idOT')
      ->get();
  }
}
