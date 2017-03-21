<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportepersonal_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  # =============================================================================================
  # CONSULTAS
  # =============================================================================================

  # Consultar Reporte por fecha y OT
  public function getBy($idOT, $fecha=NULL, $idrepo=NULL)
  {
    $this->load->database('ot');
    $this->db->from('reporte_diario AS rd');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('base','base.idbase = OT.base_idbase');
    $this->db->join('especialidad AS esp','esp.idespecialidad = OT.especialidad_idespecialidad');
    $this->db->where('OT.idOT', $idOT);
    if(isset($fecha)){
      $this->db->where('rd.fecha_reporte',$fecha);
    }elseif(isset($idrepo)) {
      $this->db->where('rd.idreporte_diario',$idrepo);
    }
    return $this->db->get();
  }
  # =====================================================================================
  # Obtener Registro del Dia
  public function getRegistroDia($idOT=NULL, $idReporte)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      ( select @rownum := @rownum + 1 from ( select @rownum := 0 ) d2 ) AS Fila,
      p.identificacion,
      p.nombre_completo,
      itf.descripcion,
      rrd.hora_inicio,
      rrd.hora_fin,
      rrd.hora_inicio2,
      rrd.hora_fin2,
      if(rd.festivo,0,rrd.horas_ordinarias),
      if(rd.festivo,rrd.horas_ordinarias,0),
      rrd.horas_extra_dia,
      rrd.horas_extra_noc,
      rrd.horas_recargo,
      "" as estado,
      rrd.gasto_viaje_pr,
      rrd.gasto_viaje_lugar,
      "" as firma,
'
    );
//      if(rd.festivo,rrd.horas_ordinarias,0) as horas_ordfestivas,
    $this->db->from('reporte_diario AS rd');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
    if (isset($idOT)) {
      //$this->db->where('rd.OT_idOT', $idOT);
      $this->db->where('rd.idReporte_diario', $idReporte);
      $this->db->where('rot.tipo', "persona");
    }
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
  }

  public function getDatosOT($idOT=NULL, $idReporte)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      OT.nombre_ot AS No_OT,
      OT.base_idbase as base,
      base.nombre_base,
      OT.actividad,
      rd.fecha_reporte,
      day(rd.fecha_reporte) as dia,
      month(rd.fecha_reporte) as mes,
      year(rd.fecha_reporte) as agno,
      dayofweek(rd.fecha_reporte) as dia_semana,
      rd.festivo,
      '
    );
    $this->db->from('reporte_diario AS rd');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('base', 'OT.base_idbase = base.idbase');
    if (isset($idOT)) {
      //$this->db->where('rd.OT_idOT', $idOT);
      $this->db->where('rd.idReporte_diario', $idReporte);
    }
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
  }

  public function testc()
  {
    $this->load->database('ot');
    return $this->db->select(' ( select @rownum := @rownum + 1 from ( select @rownum := 0 ) d2 ) AS t FROM reporte_diario ')->get();
  }

  public function tiempoLaboradoGeneral($mes, $year, $base)
  {

    $this->load->database('ot');
    return $this->db->select(
      '
      OT.nombre_ot,
      rd.fecha_reporte,
      p.identificacion,
      p.nombre_completo,
      itf.itemc_item,
      itf.codigo,
      itf.descripcion,
      if(rrd.facturable, "SI", "NO") AS facturable,
      rrd.hora_inicio AS turno1_inicio,
      rrd.hora_fin AS turno1_fin,
      rrd.hora_inicio2 AS turno2_inicio,
      rrd.hora_fin2 AS turno2_fin,
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
    )->from("recurso_reporte_diario AS rrd")
    ->join("itemf AS itf","itf.iditemf = rrd.itemf_iditemf")
    ->join("reporte_diario AS rd","rd.idreporte_diario = rrd.idreporte_diario")
    ->join("OT","OT.idOT = rd.OT_idOT")
    ->join("recurso_ot AS rot","rot.idrecurso_ot = rrd.idrecurso_ot")
    ->join("recurso AS r","r.idrecurso = rot.recurso_idrecurso")
    ->join("persona AS p","p.identificacion = r.persona_identificacion")
    ->where(" MONTH(rd.fecha_reporte) = ".$mes."  AND YEAR(rd.fecha_reporte) = ".$year." ")
    ->where("OT.base_idbase", $base)
    ->get();
  }

}
