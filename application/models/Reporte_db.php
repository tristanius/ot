<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($repo)
  {
    $this->load->database('ot');
    $data = array(
      'fecha_reporte' => $repo->fecha_reporte,
      'valido'=> FALSE,
      'festivo'=>$repo->festivo,
      'OT_idOT'=>$repo->idOT,
      'json_r'=>json_encode($repo),
      'municipio'=>isset($repo->municipio)?$repo->municipio:'',
      'linea'=>isset($repo->linea)?$repo->linea:'',
      'sistema_reporte_ecp'=>isset($repo->sistema_reporte_ecp)?$repo->sistema_reporte_ecp:'',
      'estado'=>'ABIERTO',
      'validado_pyco'=>'PENDIENTE'
    );
    $this->db->insert('reporte_diario', $data);
    return $this->db->insert_id();
  }

  # Actualizar|
  public function update($repo)
  {
    $data = array(
      'fecha_reporte' => isset($repo->fecha)?($repo->fecha != $repo->info->fecha_reporte? $repo->info->fecha_reporte:  $repo->fecha):$repo->info->fecha_reporte,
      'valido'=> FALSE,
      'festivo'=>$repo->info->festivo,
      'OT_idOT'=>$repo->info->idOT,
      'json_r'=>json_encode($repo->info),
      'municipio'=>isset($repo->info->municipio)?$repo->info->municipio:'',
      'linea'=>isset($repo->info->linea)?$repo->info->linea:'',
      'sistema_reporte_ecp'=>isset($repo->info->sistema_reporte_ecp)?$repo->info->sistema_reporte_ecp:'',
      'estado'=>$repo->info->estado,
      'validado_pyco'=>isset($repo->info->validado_pyco)?$repo->info->validado_pyco:FALSE,
      'observaciones_pyco'=>isset($repo->observaciones_pyco)?json_encode($repo->observaciones_pyco):'',
    );
    $this->db->update('reporte_diario', $data, 'idreporte_diario = '.$repo->idreporte_diario);
  }

  # Insertar un recurso a un reporte con unas cantidades
   public function addRecursoRepo($recurso, $idrepo)
   {
     $data = array(
       'idreporte_diario' => $idrepo,
       'cantidad'=> isset($recurso->cantidad)? $recurso->cantidad: '0',
       'cant'=> isset($recurso->cantidad)? $recurso->cantidad: '0',
       'planeado'=> isset($recurso->planeado)?$recurso->planeado:'',
       'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
       'print'=> isset($recurso->print)?$recurso->print:TRUE,

       'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
       'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
       'hora_inicio2'=> isset($recurso->hora_inicio2)? $recurso->hora_inicio2: '',
       'hora_fin2'=> isset($recurso->hora_fin2)? $recurso->hora_fin2: '',

       'horas_extra_dia'=> isset($recurso->horas_extra_dia)? $recurso->horas_extra_dia: '',
       'horas_extra_noc'=> isset($recurso->horas_extra_noc)? $recurso->horas_extra_noc: '',
       'horas_recargo'=> isset($recurso->horas_recargo)? $recurso->horas_recargo: '',
       'horas_ordinarias'=> isset($recurso->horas_ordinarias)? $recurso->horas_ordinarias: '',

       'racion'=> isset($recurso->racion)? $recurso->racion: '',
       'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
       'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
       'horas_operacion'=> isset($recurso->horas_operacion)? $recurso->horas_operacion: '',
       'horas_disponible'=> isset($recurso->horas_disponible)? $recurso->horas_disponible: '',
       'varado'=> isset($recurso->varado)? $recurso->varado: '',
       'horometro_ini'=> isset($recurso->horometro_ini)? $recurso->horometro_ini: '',
       'horometro_fin'=> isset($recurso->horometro_fin)? $recurso->horometro_fin: '',
       'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
       'itemf_iditemf'=> isset($recurso->itemf_iditemf)?$recurso->itemf_iditemf:NULL,
       'itemf_codigo'=> isset($recurso->codigo)?$recurso->codigo:NULL,
       'gasto_viaje_pr'=> isset($recurso->gasto_viaje_pr)?$recurso->gasto_viaje_pr:NULL,
       'gasto_viaje_lugar'=> isset($recurso->gasto_viaje_lugar)?$recurso->gasto_viaje_lugar:NULL,
       'idestado_labor'=>isset($recurso->idestado_labor)?$recurso->idestado_labor:NULL,
       'idsector_item_tarea'=>isset($recurso->idsector_item_tarea)?$recurso->idsector_item_tarea:1
     );
     $this->db->insert('recurso_reporte_diario', $data);
   }
  #Actualiar un recurso reporte
  public function editRecursoRepo($recurso, $idrepo)
  {
    $data = array(
      'idreporte_diario' => $idrepo,
      'cantidad'=> isset($recurso->cantidad)?$recurso->cantidad: '0',
      'cant'=> isset($recurso->cantidad)? $recurso->cantidad: '0',
      'planeado'=> isset($recurso->planeado)?$recurso->planeado:'',
      'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
	    'print'=> isset($recurso->print)?$recurso->print:TRUE,

      'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
      'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
      'hora_inicio2'=> isset($recurso->hora_inicio2)? $recurso->hora_inicio2: '',
      'hora_fin2'=> isset($recurso->hora_fin2)? $recurso->hora_fin2: '',

      'horas_extra_dia'=> isset($recurso->horas_extra_dia)? $recurso->horas_extra_dia: '',
      'horas_extra_noc'=> isset($recurso->horas_extra_noc)? $recurso->horas_extra_noc: '',
      'horas_recargo'=> isset($recurso->horas_recargo)? $recurso->horas_recargo: '',
      'horas_ordinarias'=> isset($recurso->horas_ordinarias)? $recurso->horas_ordinarias: '',

      'racion'=> isset($recurso->racion)? $recurso->racion: '',
      'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
      'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
      'horas_operacion'=> isset($recurso->horas_operacion)? $recurso->horas_operacion: '',
      'horas_disponible'=> isset($recurso->horas_disponible)? $recurso->horas_disponible: '',
      'varado'=> isset($recurso->varado)? $recurso->varado: '',
      'horometro_ini'=> isset($recurso->horometro_ini)? $recurso->horometro_ini: '',
      'horometro_fin'=> isset($recurso->horometro_fin)? $recurso->horometro_fin: '',
      'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
      'itemf_iditemf'=> isset($recurso->itemf_iditemf)?$recurso->itemf_iditemf:NULL,
      'itemf_codigo'=> isset($recurso->itemf_codigo)?$recurso->codigo:NULL,
      'gasto_viaje_pr'=> isset($recurso->gasto_viaje_pr)?$recurso->gasto_viaje_pr:NULL,
      'gasto_viaje_lugar'=> isset($recurso->gasto_viaje_lugar)?$recurso->gasto_viaje_lugar:NULL,
      'idestado_labor'=>isset($recurso->idestado_labor)?$recurso->idestado_labor:NULL,
      'idsector_item_tarea'=>isset($recurso->idsector_item_tarea)?$recurso->idsector_item_tarea:1
    );
    $this->db->update('recurso_reporte_diario', $data, 'idrecurso_reporte_diario = '.$recurso->idrecurso_reporte_diario);
  }
  public function recursoRepoFecha($idRecOt, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')
        ->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')->where('rrd.idrecurso_ot',$idRecOt)->where('rd.fecha_reporte',$fecha)->get();
  }
  public function recursoRepoFechaID($id, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')
        ->where('rrd.idrecurso_reporte_diario',$id)->where('rd.fecha_reporte',$fecha)->get();
  }

  public function recursoRepoFechaBy($tipo, $identificacion, $fecha, $idOT = NULL)
  {
    $this->load->database('ot');
    $this->db->select('OT.nombre_ot');
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso');
    $this->db->where('rd.fecha_reporte',$fecha);
    if (isset($idOT)) {
      $this->db->where('rd.OT_idOT <>', $idOT);
    }
    if ( $tipo=='equipos' ) {
      $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo');
      $this->db->where('e.codigo_siesa', $identificacion);
      $this->db->where('rrd.cantidad', 1);
    }elseif ($tipo == 'personal') {
      $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion');
      $this->db->where('p.identificacion', $identificacion);
      $this->db->where('rrd.cantidad', 1);
    }
    return $this->db->get();
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
    $this->db->where('OT.idOT', $idOT);
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

  public function getRecursos($idrepo, $tipo){
    $this->load->database('ot');
    $this->db->select('rrd.*, itf.itemc_item, itf.codigo, itf.descripcion, itf.unidad, itc.descripcion AS descripcion_item');
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario');
    $this->db->join('itemf AS itf', 'rrd.itemf_iditemf = itf.iditemf', 'LEFT');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc', 'LEFT');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot', 'LEFT');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso', 'LEFT');
    if ($tipo == 'personal') {
      $this->db->select('p.*, r.idrecurso, r.centro_costo, r.unidad_negocio, r.fecha_ingreso, rot.*, titc.BO, titc.CL');
      $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc');
      $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
      $this->db->where('rot.tipo', 'persona');
    }
    elseif ($tipo == "equipos") {
      $this->db->select('
        IFNULL( e.descripcion, rot.descripcion_temporal ) AS descripcion_equipo,
        IFNULL( e.codigo_siesa, rot.codigo_temporal ) AS codigo_siesa,
        IFNULL( e.referencia, "Temporal" ) AS referencia,
        e.ccosto, e.ccosto, desc_un, r.idrecurso, r.centro_costo, r.unidad_negocio, r.fecha_ingreso, rot.*, titc.BO, titc.CL');
      $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc');
      $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');
      $this->db->where('rot.tipo', 'equipo');
    }elseif ($tipo == 'actividades') {
      $this->db->select("
        (
        SELECT SUM(mrrd.cantidad) AS cant
        FROM reporte_diario AS mrd
        JOIN recurso_reporte_diario AS mrrd ON mrd.idreporte_diario = mrrd.idreporte_diario
        WHERE mrd.OT_idOT = rd.OT_idOT
        AND mrrd.itemf_iditemf = rrd.itemf_iditemf
        AND mrd.fecha_reporte < rd.fecha_reporte
        AND mrrd.idsector_item_tarea = rrd.idsector_item_tarea
        ) AS acumulado,
        sec.nombre_sector_item AS nom_sector,
      ");
      $this->db->join('sector_item_tarea AS sec', 'sec.idsector_item_tarea = rrd.idsector_item_tarea', 'LEFT');
      $this->db->where('rrd.idrecurso_ot', NULL);
    }
    $this->db->where('rrd.idreporte_diario', $idrepo);
    $this->db->order_by('itf.codigo', 'asc');
    //$this->db->order_by('rrd.facturable', 'desc');
    if ($tipo != 'actividades') {
      $this->db->order_by('titc.idtipo_itemc', 'desc');
    }
    return $this->db->get();
  }

  public function listaBy($idOT)
  {
    $this->load->database('ot');
    return $this->db->select(
        '
        rd.*,
        OT.nombre_ot,
        rd.fecha_registro AS fecha_estado_elaborado
        '
      )->from('reporte_diario AS rd')->join('OT', 'OT.idOT = rd.OT_idOT')->where('rd.OT_idOT', $idOT)->order_by('fecha_reporte','ASC')->get();
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
  public function getHistoryBy($idOT=NULL)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      ( select @rownum := @rownum + 1 from ( select @rownum := 0 ) d2 ) AS Fila,
      OT.nombre_ot AS No_OT,
      rd.fecha_reporte,
      rd.festivo,
      itf.codigo,
      rot.tipo,
      itf.itemc_item AS item,
      itf.descripcion,
      rrd.idsector_item_tarea,
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
      p.identificacion,
      p.nombre_completo,
      e.codigo_siesa,
      e.referencia,
      e.descripcion AS equipo
      '
    );
    $this->db->from('reporte_diario AS rd');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
    if (isset($idOT)) {
      $this->db->where('rd.OT_idOT', $idOT);
    }
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get();
  }

  # =============================================================================================================================
  public function deleteRecursoReporte($idrecurso_reporte_diario)
  {
    $this->load->database('ot');
    return $this->db->delete('recurso_reporte_diario', array('idrecurso_reporte_diario'=>$idrecurso_reporte_diario));
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
