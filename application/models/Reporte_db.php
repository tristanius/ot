<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($repo, $usuario=NULL)
  {
    $this->load->database('ot');
    $data = array(
      'fecha_reporte' => $repo->fecha_reporte,
      'festivo'=>isset($repo->festivo)?$repo->festivo:FALSE,
      'OT_idOT'=>$repo->idOT,
      'json_r'=>json_encode($repo),
      'municipio'=>isset($repo->municipio)?$repo->municipio:'',
      'linea'=>isset($repo->linea)?$repo->linea:'',
      'sistema_reporte_ecp'=>isset($repo->sistema_reporte_ecp)?$repo->sistema_reporte_ecp:'',
      'estado'=>'ABIERTO',
      'validado_pyco'=>'PENDIENTE',
      'usuario_creacion'=>$usuario
    );
    $this->db->insert('reporte_diario', $data);
    return $this->db->insert_id();
  }

  # Actualizar|
  public function update($repo)
  {
    $this->load->database('ot');
    $data = array(
      'fecha_reporte' => isset($repo->fecha)?$repo->fecha:$repo->info->fecha_reporte,
      'festivo'=>isset($repo->info->festivo)?$repo->info->festivo:$repo->festivo,
      'OT_idOT'=>$repo->idOT,
      'json_r'=>json_encode($repo->info),
      'municipio'=>isset($repo->info->municipio)?$repo->info->municipio:'',
      'linea'=>isset($repo->info->linea)?$repo->info->linea:'',
      'sistema_reporte_ecp'=>isset($repo->info->sistema_reporte_ecp)?$repo->info->sistema_reporte_ecp:'',
      'estado'=>$repo->info->estado,
      'validado_pyco'=>isset($repo->info->validado_pyco)?$repo->info->validado_pyco:FALSE,
      'observaciones_pyco'=>isset($repo->observaciones_pyco)?json_encode($repo->observaciones_pyco):'',
    );
    $this->db->update('reporte_diario', $data, 'idreporte_diario = '.$repo->idreporte_diario);
    return ( $this->db->affected_rows() > 0 )?TRUE:FALSE;
  }

  # Actualiar el estado de un reporte
  public function updateEstado($idreporte_diario, $estado, $validacion, $fecha=NULL, $usuari=NULLo)
  {
    $this->load->database('ot');
    $this->db->update('reporte_diario', array('estado'=>$estado, 'validado_pyco'=>$validacion), 'idreporte_diario = '.$idreporte_diario);
    return $this->db->affected_rows();
  }

  # =============================================================================================
  # CONSULTAS
  # =============================================================================================
  # Consultar Reporte por fecha y OT
  public function getBy($idOT=NULL, $fecha=NULL, $idrepo=NULL)
  {
    $this->load->database('ot');
    $this->db->from('reporte_diario AS rd');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('base','base.idbase = OT.base_idbase');
    $this->db->join('especialidad AS esp','esp.idespecialidad = OT.especialidad_idespecialidad');
    $this->db->join('tipo_ot AS tp_ot','tp_ot.idtipo_ot = OT.tipo_ot_idtipo_ot');
    if(isset($idOT)){
      $this->db->where('OT.idOT', $idOT);
    }
    if(isset($fecha)){
      $this->db->where('rd.fecha_reporte',$fecha);
    }elseif(isset($idrepo)) {
      $this->db->where('rd.idreporte_diario',$idrepo);
    }
    return $this->db->get();
  }

  # Consultar Reporte por id
  public function get($idrepo)
  {
    $this->load->database('ot');
    //return $this->db->get_where('reporte_diario', array('idreporte_diario'=>$idrepo));
    return $this->db->select('*')->from('reporte_diario AS rd')->join('OT','OT.idOT = rd.OT_idOT')->where('rd.idreporte_diario',$idrepo)->get();
  }
  // Listado de reoportes de una OT
  public function listaBy($idOT)
  {
    $this->load->database('ot');
    return $this->db->select(
        '
        rd.*,
        OT.nombre_ot,
        rd.fecha_registro,
        (
          SELECT lm.fecha
          FROM log_movimiento AS lm
          WHERE lm.referencia = "RD ELABORADO"
          AND lm.idregistro = rd.idreporte_diario
          AND lm.tabla = "reporte_diario" GROUP BY lm.referencia
        ) AS fecha_estado_elaborado
        '
      )->from('reporte_diario AS rd')->join('OT', 'OT.idOT = rd.OT_idOT')->where('rd.OT_idOT', $idOT)->order_by('fecha_reporte','ASC')->get();
  }

  public function getBy($where)
  {
    $this->load->database('ot');
    return $this->db->select('rd.*, OT.idOT, OT.nombre_ot')->from('rerpote_diario AS rd')->join('OT', 'rd.OT_idOT = OT.idOT')->where($where)->get();
  }

  # =====================================================================================
  # Obtener reportes por estado
  public function getEstadosBy($idOT=NULL, $obj){
    $this->load->database('ot');
    $sel = 'OT.base_idbase AS CO,
        OT.nombre_ot AS NoOrden,
      ';
    for ($i=1; $i <= $obj->dias; $i++) {
      $sel.="
      (
        SELECT repo.validado_pyco
        FROM reporte_diario AS repo
        WHERE repo.OT_idOT = OT.idOT AND repo.fecha_reporte = '".$obj->year."-".$obj->mes."-".$i."'
      ) AS d".$i.",";
    }
    $sel .= "
      MAX(tr.fecha_fin) AS fecha_fin,
      if( (SELECT MAX(repo.fecha_reporte) FROM reporte_diario AS repo WHERE repo.OT_idOT = OT.idOT ) > MAX(tr.fecha_fin), 'Fecha Excedida','fecha en margen' ) AS estado_fecha
    ";
    $this->db->select($sel);
    $this->db->from('OT');
    $this->db->join('tarea_ot AS tr', 'OT.idOT = tr.OT_idOT');
    if (count($obj->bases) > 0) {
			$this->db->where_in('OT.base_idbase', $obj->bases);
		}
    if (isset($obj->nombre_ot)) {
      $this->db->like('OT.nombre_ot', $obj->nombre_ot);
    }
    $this->db->where("
      ( SELECT COUNT(rd.idreporte_diario) FROM reporte_diario As rd WHERE rd.OT_idOT = OT.idOT AND MONTH( rd.fecha_reporte ) = ".$obj->mes." AND YEAR(rd.fecha_reporte) = ".$obj->year." ) > 1
    ");
    $this->db->group_by('OT.idOT');
    return $this->db->get();
  }
  # =====================================================================================
  # Obtener historial de la OT
  public function getHistoryBy($idOT=NULL, $production = NULL)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      ( select @rownum := @rownum + 1 from ( select @rownum := 0 ) d2 ) AS Fila,
      OT.nombre_ot AS No_OT,
      rd.fecha_reporte,
      rd.festivo,
      itf.codigo,
      tip.grupo_mayor AS tipo_recurso,
      itf.itemc_item AS item,
      itf.descripcion,
      rrd.facturable,
      rrd.print,
      rrd.cantidad,
      getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) as cantidad_final,
      rrd.hora_inicio,
      rrd.hora_fin,
      rrd.hora_inicio2,
      rrd.hora_fin2,
      rrd.horas_extra_dia,
      rrd.horas_extra_noc,
      rrd.horas_recargo,
      rrd.horas_ordinarias,
      rrd.hr_almuerzo,
      rrd.racion,
      rrd.nombre_operador,
      rrd.horas_operacion,
      rrd.horas_disponible,
      rrd.horometro_ini,
      rrd.horometro_fin,
      rrd.varado,
      rrd.gasto_viaje_pr,
      rrd.gasto_viaje_lugar,
      CONCAT(frente.nombre, " ", frente.ubicacion ) AS frente,
      rrd.item_asociado,
      p.identificacion,
      p.nombre_completo,
      e.codigo_siesa,
      if( e.referencia IS NULL, rot.codigo_temporal, e.referencia ) AS referencia,
      if( e.descripcion IS NULL , rot.descripcion_temporal, e.descripcion ) AS equipo,
      rot.propietario_observacion AS asignado_a,
      IF( rot.propietario_recurso, "SI", "NO" ) AS propio,
      avance.abscisa_ini, avance.abscisa_fin, avance.tipo_instalacion, avance.tipo_ejecucion,
      avance.ubicacion, avance.margen, avance.MH_inicio, avance.MH_fin, avance.longitud,
      avance.ancho, avance.alto,  avance.cant_elementos, avance.cant_varillas,
      avance.diametro_acero, avance.peso_und, avance.a_cargo, avance.calidad
      '
    );
    $this->db->from('reporte_diario AS rd');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
    $this->db->join('avance_reporte AS avance', 'avance.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario','LEFT');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
    $this->db->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc');
    $this->db->join('tipo_itemc AS tip', 'tip.idtipo_itemc = itc.idtipo_itemc', 'LEFT');
    $this->db->join('frente_ot AS frente', 'frente.idfrente_ot = rrd.idfrente_ot', 'LEFT');
    if (isset($idOT)) {
      $this->db->where('rd.OT_idOT', $idOT);
    }
    if (isset($production)) {
      $this->db->group_start();
        $this->db->where('rrd.facturable', TRUE);
        $this->db->or_where('rrd.print', TRUE);
      $this->db->group_end();
    }
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
  }

  # Numero de reportes por Orden en un mes
	public function consulta_num_reportes($obj, $having=FALSE)
	{
		$this->load->database('ot');
		$this->db->select(
			'
			(
				SELECT COUNT(rd.idreporte_diario) AS result
				FROM reporte_diario AS rd
				WHERE OT.idOT = rd.OT_idOT
				AND MONTH(rd.fecha_reporte) = '.$obj->mes.'
				AND YEAR(rd.fecha_reporte) = '.$obj->year.'
			) AS num_reportes,
			OT.idOT,
			OT.base_idbase,
			OT.nombre_ot,
			OT.estado_doc,
			base.nombre_base
			'
		);
		$this->db->from('OT');
		$this->db->join('base', 'OT.base_idbase = base.idbase');
		$this->db->where_in('OT.', $obj->bases);
		if ($having) {
			$this->db->having('num_rerpotes >', 0);
		}
		$this->db->order_by('num_rerpotes', 'desc');
		return $this->db->get();
	}

  # ======================================================================================
  # Frentes
  # ======================================================================================
  public function getRecusoReportesByFrente($idOT, $idfrente, $group=TRUE, $idreporte=NULL)
  {
    $this->load->database('ot');
    if($group){
      $this->db->select('OT.idOT, OT.nombre_ot, rd.idreporte_diario, rd.fecha_reporte, ft.idfrente_ot, ft.nombre AS nombre_frente');
    }else{
      $this->db->select('rrd.*, itf.itemc_item, itf.codigo, itf.descripcion, itf.unidad, itc.descripcion AS descripcion_item,
      rot.propietario_recurso, rot.propietario_observacion, rrd.item_asociado,
      ft.nombre AS nombre_frente, ft.ubicacion AS ubicacion_frente');
    }
    $this->db->from('reporte_diario AS rd')
      ->join('recurso_reporte_diario AS rrd', 'rd.idreporte_diario = rrd.idreporte_diario')
      ->join('frente_ot AS ft','ft.idfrente_ot = rrd.idfrente_ot')
      ->join('OT','OT.idOT = rd.OT_idOT')
      ->where('OT.idOT',$idOT)
      ->where('ft.idfrente_ot',$idfrente);
    if($group && isset($idreporte)){
      $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
      $this->db->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc');
      $this->db->join('recurso_ot AS rot', 'rrd.idrecurso_ot = rot.idrecurso_ot', 'left');
      $this->db->where('rd.idreporte_diario', $idreporte);
    }else{
      $this->db->group_by('rd.idreporte_diario');
    }
    return $this->db->get();
  }

  # ======================================================================================
  # TRANSACTION
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
		}
		else{
		        $this->db->trans_commit();
		}
		return $status;
	}
}
