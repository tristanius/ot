<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion_db extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index(){}

  public function informeFacturacion($f1=NULL, $f2=NULL, $idOT=NULL, $bases = NULL)
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
      OT.numero_sap,
      "" as tarea,
      "" as control_cambio,
      OT.cc_ecp as centro_costo,
      "" as cuenta_mayor,
      "" as sistema,
      OT.abscisa as pk,
      p.identificacion as cedula,
      p.nombre_completo,
      itf.itemc_item as item,
      itc.descripcion,
      if(length(titc.cl)>0,if(titc.cl="C","Convencional","Legal"),"") as conv_leg,
      if(length(titc.bo)>0,if(titc.bo="B","Basico","Opcional"),"") as clasifica_gral,
      titc.descripcion as clasifica_deta,
      if(rrd.facturable,"SI","NO") AS facturable,
      rrd.cantidad AS cant_und,
      tr.tarifa,
      itf.unidad,
      if(rrd.facturable, getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad), 0) as cantidad_total,
      if(rrd.facturable, getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) * tr.tarifa, 0) as valor_subtotal,
      if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr. tarifa, 0.18), 0) as a,
      if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.01), 0) as i,
      if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.04), 0) as u,
      if(rrd.facturable, getTotal(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.23), 0) as total,
      OT.locacion as lugar,
      OT.municipio,
      OT.zona,
      e.referencia as placa_equipo,
      rrd.horas_operacion,
      rrd.horas_disponible,
      e.codigo_siesa,
      e.referencia,
      rrd.nombre_operador,
      rrd.hora_inicio AS tr1_entrada,
      rrd.hora_fin AS tr1_salida,
      rrd.hora_inicio2 AS tr2_entrada,
      rrd.hora_fin2 AS tr2_salida,
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
      rd.validado_pyco AS estado_reporte
      '
    );
    //if(itf.unidad="hr",if((rrd.horas_operacion-4)>0,rrd.horas_operacion,4) ,if(rrd.horas_operacion=0,(itc.hrdisp/itc.basedisp),1)) as cantidad_total,
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
    $this->db->join('vigencia_tarifas AS vtarf', 'vtarf.idvigencia_tarifas = tr.idvigencia_tarifas');

    if (isset($idOT)) {
      $this->db->where('rd.OT_idOT', $idOT);
    }
    if (isset($f1) && isset($f2)) {
      $this->db->where("rd.fecha_reporte BETWEEN '".$f1."' AND '".$f2."' ");
    }
    if (isset($bases) && sizeof($bases) > 0) {
      $this->db->where_in('bs.idbase', $bases);
    }
    $this->db->where('vtarf.idvigencia_tarifas = (
      SELECT myvigencia.idvigencia_tarifas
      FROM vigencia_tarifas AS myvigencia
      WHERE myvigencia.fecha_inicio_vigencia <= rd.fecha_reporte
      ORDER BY myvigencia.fecha_inicio_vigencia DESC
      LIMIT 1
      )');
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
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
      OT.numero_sap,
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
      e.codigo_siesa,
      e.referencia AS ref_equipo,
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

  public function informePYCO($value='')
  {
    $this->load->database('ot');
    return $this->db->select('
      OT.nombre_ot,
      tr.nombre_tarea,
      IFNULL(tr.sap , OT.numero_sap) AS sap,
      b.nombre_base,
      if(OT.basica, "BASICA","-") AS ot_basica,
      OT.vereda,
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
    ->group_by('tr.idtarea_ot')
    ->get();
  }
  public function informeOtPyco()
  {
    $this->load->database('ot');
    return $this->db->select(
      '
      OT.nombre_ot,
      COUNT(tr.idtarea_ot) AS no_tareas,
      OT.estado_sap,
      if(OT.numero_sap="",tr.sap,OT.OT.numero_sap) AS numero_sap,
      if(OT.basica, "BASICA","NO BASICA") AS ot_basica,
      CONCAT( b.idbase, " - ", b.nombre_base ) AS base,
      OT.gerencia,
      OT.departamento_ecp,
      OT.vereda,
      OT.actividad,
      "" AS cuenta_mayor,
      MIN(tr.fecha_inicio) AS fecha_inicio_planeado,
      MAX(tr.fecha_fin) AS fecha_fin_planeado,
      DATEDIFF(MIN(tr.fecha_fin), MIN(tr.fecha_inicio) ) AS plazo_planeado,
      esp.nombre_especialidad,
      tp.nombre_tipo_ot,
      OT.estado_doc AS estado_ot,
      OT.fecha_inicio,
      OT.fecha_fin,
      DATEDIFF(tr.fecha_fin, tr.fecha_inicio ) AS plazo_ejecutado,
      tr.responsables,
      "" AS observaciones,
      ( SELECT  SUM(itt.valor_plan) FROM item_tarea_ot AS itt JOIN tarea_ot AS tar ON itt.tarea_ot_idtarea_ot = tar.idtarea_ot WHERE tar.OT_idOT = OT.idOT AND itemf_codigo LIKE "1%" ) AS actividad_apu,
      ( SELECT  SUM(itt.valor_plan) FROM item_tarea_ot AS itt JOIN tarea_ot AS tar ON itt.tarea_ot_idtarea_ot = tar.idtarea_ot WHERE tar.OT_idOT = OT.idOT AND itemf_codigo LIKE "2%" ) AS personal,
      ( SELECT  SUM(itt.valor_plan) FROM item_tarea_ot AS itt JOIN tarea_ot AS tar ON itt.tarea_ot_idtarea_ot = tar.idtarea_ot WHERE tar.OT_idOT = OT.idOT AND itemf_codigo LIKE "3%" ) AS equipo,
      regot.enero,
      regot.febrero,
      regot.marzo,
      regot.abril,
      regot.mayo,
      regot.junio,
      regot.julio,
      regot.agosto,
      regot.septiembre,
      regot.noviembre,
      regot.diciembre,
      "" AS total,
      "" AS total_directo_aiu,
      OT.presupuesto_porcent_ini AS porcentaje_utilidad_inicial,
      OT.presupuesto_porcent_fin AS porcentaje_utilidad_fin
      '
      )->from('OT')
      ->join('tarea_ot AS tr','tr.OT_idOT = OT.idOT')
      ->join('base AS b','b.idbase = OT.base_idbase')
      ->join('especialidad AS esp','esp.idespecialidad = OT.especialidad_idespecialidad')
      ->join('tipo_ot AS tp','tp.idtipo_ot = OT.tipo_ot_idtipo_ot')
      ->join('registro_mes_ot AS regot', 'regot.OT_idOT = OT.idOT',"LEFT")
      ->group_by('OT.idOT')->get();
  }


}
