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
      itf.itemc_item,
      itf.codigo,
      itf.iditemf,
      ft.nombre AS nombre_frente,
      ft.ubicacion AS ubicacion_frente,
      rot.propietario_observacion AS asignado_como,
      IF(rot.propietario_recurso,"SI","NO") AS propio'
    );
    // if(rd.festivo,rrd.horas_ordinarias,0) as horas_ordfestivas,
    $this->db->from('reporte_diario AS rd');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
    $this->db->join('frente_ot AS ft', 'ft.idfrente_ot = rrd.idfrente_ot', 'LEFT');
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
      OT.idcontrato
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

  public function tiempoLaboradoGeneral($ini, $fin, $base)
  {

    $this->load->database('ot');
    if(isset($base)){$this->db->where('OT.base_idbase', $base);}
    return $this->db->select(
      '
      OT.nombre_ot AS Orden,
      OT.base_idbase AS CO,
      rd.fecha_reporte,
      p.identificacion,
      p.nombre_completo,
      IFNULL(ft.nombre, OT.nombre_ot) AS Frente,
      IFNULL(ft.ubicacion, OT.nombre_ot) AS Ubicacion,
      itf.itemc_item,
      itf.codigo,
      titc.descripcion as clasificacion_item,
      if(titc.CL="L", "LEGAL", if(titc.CL="C","CONVENCIONAL", "NO DATA")) AS tipo_item,
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
      rot.propietario_observacion AS asignado_como,
      IF(rot.propietario_recurso,"SI","NO") AS propio,
      rd.validado_pyco AS estado_reporte,
      if(rrd.nomina=1, "SI","NO") AS en_nomina
      '
    )->from("recurso_reporte_diario AS rrd")
    ->join("itemf AS itf","itf.iditemf = rrd.itemf_iditemf")
    ->join("itemc AS itc","itc.iditemc = itf.itemc_iditemc")
    ->join("tipo_itemc AS titc","titc.idtipo_itemc = itc.idtipo_itemc")
    ->join("reporte_diario AS rd","rd.idreporte_diario = rrd.idreporte_diario")
    ->join("OT","OT.idOT = rd.OT_idOT")
    ->join("recurso_ot AS rot","rot.idrecurso_ot = rrd.idrecurso_ot")
    ->join("recurso AS r","r.idrecurso = rot.recurso_idrecurso")
    ->join("persona AS p","p.identificacion = r.persona_identificacion")
    ->join("frente_ot AS ft", "ft.idfrente_ot = rrd.idfrente_ot","LEFT")
    ->where("rd.fecha_reporte BETWEEN '".$ini."'  AND '".$fin."' ")
    ->get();
  }

  public function tiempoLaboradoGeneral2($ini, $fin, $args)
  {

    $this->load->database('ot');
    if( isset($args['base']) ){$this->db->where('OT.base_idbase', $args['base']);}
    if( isset($args['orden']) ){$this->db->where('OT.nombre_ot', $args['orden'] );}
    if( isset($args['identificacion']) ){ $this->db->where("p.identificacion", $args['identificacion']); }
    //$this->db->where_in('rd.validado_pyco', array('ELABORADO','VALIDO','VALIDADO','FIRMADO','CORREGIDO') );
    return $this->db->select(
      '
      OT.nombre_ot AS Orden,
      OT.base_idbase AS CO,
      IFNULL(ft.nombre, OT.nombre_ot) AS Frente_OT,
      IFNULL(ft.ubicacion, OT.nombre_ot) AS ubicacion,
      rd.fecha_reporte,
      p.identificacion,
      p.nombre_completo,
      itf.itemc_item,
      itf.codigo,
      titc.descripcion as clasificacion_item,
      if(titc.CL="L", "LEG", if(titc.CL="C","CONV", "NO DATA")) AS tipo_item,
      itf.descripcion,
      if(rrd.facturable, "SI", "NO") AS facturable,
      rrd.hora_inicio AS turno1_inicio,
      rrd.hora_fin AS turno1_fin,
      rrd.hora_inicio2 AS turno2_inicio,
      rrd.hora_fin2 AS turno2_fin,
      rrd.horas_ordinarias,
      rrd.horas_extra_dia,
      rrd.horas_extra_noc,
      rrd.horas_recargo,
      if(!rd.festivo, "SI", "NO") AS festivo,
      rrd.racion,
      rrd.gasto_viaje_pr AS pernocto,
      rrd.gasto_viaje_lugar AS lugar_gasto_viaje,
      rd.validado_pyco As estado_reporte,
      if(rrd.nomina=1, "SI","NO") AS en_nomina,
      rrd.usuario_nomina
      '
    )->from("recurso_reporte_diario AS rrd")
    ->join("itemf AS itf","itf.iditemf = rrd.itemf_iditemf")
    ->join("itemc AS itc","itc.iditemc = itf.itemc_iditemc")
    ->join("tipo_itemc AS titc","titc.idtipo_itemc = itc.idtipo_itemc")
    ->join("reporte_diario AS rd","rd.idreporte_diario = rrd.idreporte_diario")
    ->join("OT","OT.idOT = rd.OT_idOT")
    ->join("recurso_ot AS rot","rot.idrecurso_ot = rrd.idrecurso_ot")
    ->join("recurso AS r","r.idrecurso = rot.recurso_idrecurso")
    ->join("persona AS p","p.identificacion = r.persona_identificacion")
    ->join("frente_ot AS ft", "ft.idfrente_ot = rrd.idfrente_ot","LEFT")
    ->where("rd.fecha_reporte BETWEEN '".$ini."'  AND '".$fin."' ")
    ->get();
  }

  public function personalNomina($ini, $fin, $args, $bandera, $usuario)
  {
    $this->load->database('ot');
    $query = "UPDATE recurso_reporte_diario AS rrd
    JOIN reporte_diario AS rd ON rd.idreporte_diario = rrd.idreporte_diario
    JOIN OT ON OT.idOT = rd.OT_idOT
    JOIN recurso_ot AS rot ON rot.idrecurso_ot = rrd.idrecurso_ot
    JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
    SET rrd.nomina = ".$bandera.", rrd.usuario_nomina = '".$usuario."'
    WHERE ( rd.fecha_reporte BETWEEN '".$ini."' AND '".$fin."' )
    AND rrd.nomina = ".($bandera?0:1)."
    AND rot.propietario_recurso = TRUE
    AND rot.tipo = 'persona' ";
    $query .= $bandera?" AND rd.validado_pyco IN ('ACTUALIZADO', 'ELABORADO','VALIDO', 'VALIDADO' ,'FIRMADO','CORREGIDO', 'CORREGIR', 'CORREGIR HE', 'CORREGIR GV') ":"";
    if(isset($args['base'])){ $query .= " AND OT.base_idbase = ".$args['base']; }
    if(isset($args['orden'])){ $query .=" AND OT.nombre_ot = '".$args['orden']."'"; }
    if(isset($args['identificacion'])){ $query .=" AND r.persona_identificacion = '".$args['identificacion']."'"; }
    $this->db->query($query);
  }

  public function personalNominaUnoAUno($fecha, $ot, $identificacion, $bandera, $usuario )
  {
    $this->load->database('ot');
    $query = "UPDATE recurso_reporte_diario AS rrd
      JOIN reporte_diario AS rd ON rd.idreporte_diario = rrd.idreporte_diario
      JOIN OT ON OT.idOT = rd.OT_idOT
      JOIN recurso_ot AS rot ON rot.idrecurso_ot = rrd.idrecurso_ot
      JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
    SET rrd.nomina = ".$bandera.", rrd.usuario_nomina = '".$usuario."'
    WHERE rd.fecha_reporte = '".$fecha."'
    AND rd.validado_pyco IN ('ACTUALIZADO', 'ELABORADO','VALIDO', 'VALIDADO' ,'FIRMADO','CORREGIDO', 'CORREGIR', 'CORREGIR HE', 'CORREGIR GV')
    AND OT.nombre_ot = '".trim($ot)."'
    AND rrd.nomina = ".($bandera?0:1)."
    AND r.persona_identificacion = '".$identificacion."'
    AND rot.propietario_recurso = TRUE
    AND rot.tipo = 'persona' ";
    $this->db->query($query);
    return $this->db->affected_rows();
  }

  public function personalValidation($ini, $fin, $args, $bandera, $usuario)
  {
    $this->load->database('ot');
    $query = "UPDATE recurso_reporte_diario AS rrd
    JOIN reporte_diario AS rd ON rd.idreporte_diario = rrd.idreporte_diario
    JOIN OT ON OT.idOT = rd.OT_idOT
    JOIN recurso_ot AS rot ON rot.idrecurso_ot = rrd.idrecurso_ot
    JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
    SET rrd.validacion_he = ".$bandera.", rrd.usuario_validacion_he = '".$usuario."'
    WHERE ( rd.fecha_reporte BETWEEN '".$ini."' AND '".$fin."' )
    AND rrd.validacion_he = ".($bandera?0:1);
    $query .= $bandera?" AND rd.validado_pyco IN ('ACTUALIZADO','VALIDO', 'VALIDADO' ,'FIRMADO','CORREGIDO') ":"";
    if(isset($args['base'])){ $query .= " AND OT.base_idbase = ".$args['base']; }
    if(isset($args['orden'])){ $query .=" AND OT.nombre_ot = '".$args['orden']."'"; }
    if(isset($args['identificacion'])){ $query .=" AND r.persona_identificacion = '".$args['identificacion']."'"; }
    $this->db->query($query);
  }
  /// --------------------------------------

  public function getPerMes($mes, $year,$laBase)
  {
    $base = !isset($laBase)?'':'and OT.base_idbase = '.$laBase.' ';
    $this->load->database('ot');
    return $this->db->query(
      '
        select OT.base_idbase as base,
        rrd.itemf_codigo as codigo,
        p.identificacion,
        p.nombre_completo,
        OT.nombre_ot,
        rot.propietario_observacion AS asignacion,
        itf.descripcion,
        CONCAT( ft.ubicacion, ft.ubicacion ) AS ubicacion_frente,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-1 ) ) ) )  as d01,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-2 ) ) ) )  as d02,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-3 ) ) ) )  as d03,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-4 ) ) ) )  as d04,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-5 ) ) ) )  as d05,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-6 ) ) ) )  as d06,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-7 ) ) ) )  as d07,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-8 ) ) ) )  as d08,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-9 ) ) ) )  as d09,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-10 ) ) ) ) as d10,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-11 ) ) ) ) as d11,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-12 ) ) ) ) as d12,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-13 ) ) ) ) as d13,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-14 ) ) ) ) as d14,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-15 ) ) ) ) as d15,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-16 ) ) ) ) as d16,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-17 ) ) ) ) as d17,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-18 ) ) ) ) as d18,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-19 ) ) ) ) as d19,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-20 ) ) ) ) as d20,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-21 ) ) ) ) as d21,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-22 ) ) ) ) as d22,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-23 ) ) ) ) as d23,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-24 ) ) ) ) as d24,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-25 ) ) ) ) as d25,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-26 ) ) ) ) as d26,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-27 ) ) ) ) as d27,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-28 ) ) ) ) as d28,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-29 ) ) ) ) as d29,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-30 ) ) ) ) as d30,
        SUM( rrd.idestado_labor * ABS( 1-ABS( sign( DAY(rd.fecha_reporte )-31 ) ) ) ) as d31
        FROM reporte_diario AS rd
        JOIN OT ON OT.idOT = rd.OT_idOT
        JOIN recurso_reporte_diario AS rrd ON rrd.idreporte_diario = rd.idreporte_diario
        JOIN recurso_ot AS rot ON rot.idrecurso_ot = rrd.idrecurso_ot
        JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
        JOIN persona AS p ON p.identificacion = r.persona_identificacion
        JOIN frente_ot AS ft ON ft.idfrente_ot = rrd.idfrente_ot
        JOIN itemf AS itf ON itf.iditemf = rrd.itemf_iditemf
        where MONTH(rd.fecha_reporte) = '.$mes.' and
        YEAR(rd.fecha_reporte)  = '.$year.'
        '.$base.'
        group by p.identificacion,nombre_ot
        order by p.identificacion,nombre_ot
    '
    );
  }


  // TRANSACTION
  public function init_transact()
	{
		$this->load->database('ot');
		$this->db->trans_begin();
	}

	public function end_transact()
	{
		$this->load->database('ot');
		$status = $this->db->trans_status();
		if ($status === FALSE){
      $this->db->trans_rollback();
		}else{
      $this->db->trans_commit();
		}
		return $status;
	}
}
