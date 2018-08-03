<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ot_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	public function getBases( $tipo=NULL,  $sector=NULL )
	{
		$this->load->database('ot');
		$bases = NULL;
		if ( isset($tipo) && $tipo == 'departamento') {
			$bases = $this->db->from('base')->where('idsector', $sector )->get();
		}elseif (isset($tipo) && $tipo == 'co') {
			$bases = $this->db->from('base')->where('nombre_base', $sector )->get();
		} else {
			$bases = $this->db->get('base');
		}
		return $bases;
	}
	// Registrar una nueva OT.
	public function add(
		$nombre_ot, $ccosto, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad, $justificacion,
		$locacion, $abscisa, $departamento, $municipio, $vereda, $cc_ecp, $json, $clasificacion_ot, $gerencia, $departamento_ecp, $nombre_departamento_ecp=NULL,
		$estado_doc, $ot_legalizada, $fecha_inicio, $fecha_fin, $presupuesto_fecha_ini, $presupuesto_porcent_ini, $presupuesto_fecha_fin, $presupuesto_porcent_fin,
		$fecha_creacion_cc=NULL,  $basica = NULL, $idcontrato=NULL
	){
		$this->load->database('ot');
		$data = array(
			"nombre_ot"=>$nombre_ot,
			'ccosto'=>$ccosto,
			'base_idbase'=>$base,
			"zona"=>$zona,
			"fecha_creacion"=>$fecha_creacion,
			"especialidad_idespecialidad"=>$especialidad,
			"tipo_ot_idtipo_ot"=>$tipo_ot,
			"actividad"=>$actividad,
			"justificacion"=>$justificacion,
			"locacion"=>$locacion,
			"abscisa"=>$abscisa,
			"departamento"=>$departamento,
			"municipio"=>$municipio,
			"vereda"=>$vereda,
			"cc_ecp"=>$cc_ecp,
			'json'=>$json,
			'clasificacion_ot'=>$clasificacion_ot,
			'gerencia'=>$gerencia,
			'departamento_ecp'=>$departamento_ecp,
			'nombre_departamento_ecp'=>$nombre_departamento_ecp,
			'estado_doc'=>$estado_doc,
			"ot_legalizada"=>$ot_legalizada,
			"fecha_inicio"=>$fecha_inicio,
			"fecha_fin"=>$fecha_fin,
			"presupuesto_fecha_ini"=>$presupuesto_fecha_ini,
			"presupuesto_porcent_ini"=>$presupuesto_porcent_ini,
			"presupuesto_fecha_fin"=>$presupuesto_fecha_fin,
			"presupuesto_porcent_fin"=>$presupuesto_porcent_fin,
			"fecha_creacion_cc"=>$fecha_creacion_cc,
			"basica" =>$basica,
			"idcontrato" =>$idcontrato
		);
		$this->db->insert('OT', $data);
		return $this->db->insert_id();
	}
	//Editar daos info de una OT.
	public function update(
		$idot, $nombre_ot, $ccosto, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad,
		$justificacion, $locacion, $abscisa, $departamento, $municipio, $vereda, $cc_ecp,  $json, $clasificacion_ot, $gerencia, $departamento_ecp, $nombre_departamento_ecp=NULL,
		$estado_doc, $ot_legalizada, $fecha_inicio, $fecha_fin, $presupuesto_fecha_ini, $presupuesto_porcent_ini, $presupuesto_fecha_fin, $presupuesto_porcent_fin,
		$fecha_creacion_cc=NULL, $basica = NULL, $idcontrato =NULL
	) {
		$this->load->database('ot');
		$data = array(
			"nombre_ot"=>$nombre_ot,
			'ccosto'=>$ccosto,
			'base_idbase'=>$base,
			"zona"=>$zona,
			"fecha_creacion"=>$fecha_creacion,
			"especialidad_idespecialidad"=>$especialidad,
			"tipo_ot_idtipo_ot"=>$tipo_ot,
			"actividad"=>$actividad,
			"justificacion"=>$justificacion,
			"locacion"=>$locacion,
			"abscisa"=>$abscisa,
			"departamento"=>$departamento,
			"municipio"=>$municipio,
			"vereda"=>$vereda,
			'cc_ecp'=>$cc_ecp,
			'json'=>$json,
			'clasificacion_ot'=>$clasificacion_ot,
			'gerencia'=>$gerencia,
			'departamento_ecp'=>$departamento_ecp,
			'nombre_departamento_ecp'=>$nombre_departamento_ecp,
			'estado_doc'=>$estado_doc,
			"ot_legalizada"=>$ot_legalizada,
			"fecha_inicio"=>$fecha_inicio,
			"fecha_fin"=>$fecha_fin,
			"presupuesto_fecha_ini"=>$presupuesto_fecha_ini,
			"presupuesto_porcent_ini"=>$presupuesto_porcent_ini,
			"presupuesto_fecha_fin"=>$presupuesto_fecha_fin,
			"presupuesto_porcent_fin"=>$presupuesto_porcent_fin,
			"fecha_creacion_cc"=>$fecha_creacion_cc,
			"basica" =>$basica,
			"idcontrato" =>$idcontrato
		);
		return $this->db->update('OT', $data, "idOT =".$idot);
	}

	#=============================================================================
	# Insertando información adicional
	public function addRendimientoMesAMes()
	{
		//$this->db->insert('', $data);
	}
	#=============================================================================

	// obetener información de una OT
	public function getData($idot){
		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('tipo_ot AS tp', 'OT.tipo_ot_idtipo_ot = tp.idtipo_ot');
		$this->db->join('contrato AS c', 'c.idcontrato = OT.idcontrato');
		$this->db->where('OT.idOT', $idot);
		return $this->db->get();
	}
	//Obtener un listado de todas las OT
	public function getAllOTs($base = NULL, $nom = NULL, $estado = NULL){
		$this->load->database('ot');
		$this->db->select('OT.*, esp.*, b.*, tp.*, (SELECT count(tr.idtarea_ot) FROM tarea_ot AS tr WHERE tr.OT_idOT = OT.idOT) AS num_tareas');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('tipo_ot AS tp', 'tp.idtipo_ot = OT.tipo_ot_idtipo_ot');
		if (isset($base)) {
			$this->db->where('b.idbase', $base);
		}
		if (isset($nom)) {
			$this->db->like('OT.nombre_ot', $nom);
		}
		if (isset($estado)) {
			$this->db->where('OT.estado_doc', $estado);
		}
		return $this->db->get();
	}

	#Obtiene una tarea de una OT
	public function getTarea($idOt, $idTarea)
	{
		$this->load->database('ot');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $idOt);
		$this->db->where('idtarea_ot', $idTarea);
		return $this->db->get();
	}

	public function getTarea1($idOT)
	{
		$this->load->database('ot');
		$this->db->select('MIN(idtarea_ot) AS idtarea_ot');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $idOT);
		return $this->db->get();
	}
	# Obtiene un listado de taras
	public function getTareas($id, $arr_tareas=NULL)
	{
		$this->load->database('ot');
		$this->db->select('tr.*');
		$this->db->from('tarea_ot AS tr');
		$this->db->where('OT_idOT', $id);
		if (isset($arr_tareas)) {
			$this->db->where_in('idtarea_ot', $arr_tareas);
		}
		return $this->db->get();
	}


	# ============================================================================

	# Frentes de TRABAJO

	public function addFrenteOT($frente)
	{
		$this->load->database('ot');
		$frente = (array) $frente;
		$frente['usuario'] = isset($frente['usuario'] )?json_encode($frente['usuario']):NULL;
		$this->db->insert('frente_ot', $frente);
		return $this->db->insert_id();
	}
	public function modFrenteOT($frente, $idfrente)
	{
		$this->load->database('ot');
		$frente = (array) $frente;
		$frente['usuario'] = isset($frente['usuario'] )?json_encode($frente['usuario']):NULL;
		return $this->db->update('frente_ot', $frente, 'idfrente_ot = '.$idfrente);
	}

	public function getFrentesOT($idot)
	{
		$this->load->database('ot');
		return $this->db->get_where('frente_ot', array('OT_idOT'=>$idot));
	}

	public function delFrenteOT($idfrente)
	{
		$this->load->database('ot');
		return $this->db->delete('frente_ot', array('idfrente',$idfrente));
	}

	public function getPlanByFrentes($id)
	{
		$this->load->database('ot');
		$this->db->select(
			'OT.nombre_ot,
			itf.descripcion,
			itf.codigo,
			itf.itemc_item,
			f.nombre AS nombre_frente,
			f.ubicacion AS ubicacion_frente
			'
		);
		$this->db->from('OT');
		$this->db->join('tarea_ot AS tr', 'tr.OT_idOT = OT.idOT');
		$this->db->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot');
		$this->db->join('frente_ot AS f', 'f.idfrente_ot = itt.idfrente_ot', 'left');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->where('OT.idOT', $id);
		$this->db->group_by('itf.codigo');
		$this->db->order_by("itt.iditem_tarea_ot", "asc");
		$this->db->order_by('itf.itemc_item', 'asc');
		return $this->db->get();
	}

	#=============================================================================

	# Obetener una Ot por un campo especificado por parametro
	public function getOtBy($campo, $valorbuscado)
	{
		$this->load->database('ot');
		return $this->db->from('OT')->like( $campo, $valorbuscado )->get();
	}

	# ===========================================================================
	# Consulta de items de OT
	# ===========================================================================

	# Obtener items por tipo de un OT
	public function getItemByTipeOT($idOT, $tipo=NULL)	{
		$this->load->database('ot');
		$this->db->select(
				'
				itc.item,
				itt.iditem_tarea_ot,
				itt.facturable,
				itf.iditemf,
				itf.itemc_iditemc,
				itf.itemc_item,
				itf.codigo,
				itf.descripcion,
				OT.nombre_ot,
				tot.nombre_tarea,
				itc.unidad,
				itc.descripcion AS descripcion_itemc,
				itc.idtipo_itemc,
				titc.grupo_mayor,
				titc.BO,
				titc.CL,
				SUM(itt.cantidad) AS planeado,
				itt.idfrente_ot,
				itt.subtarifa
				'
			);
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
		$this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc');
		$this->db->join('tarea_ot AS tot', 'itt.tarea_ot_idtarea_ot = tot.idtarea_ot');
		$this->db->join('OT', 'OT.idOT = tot.OT_idOT');
		$this->db->where('OT.idOT', $idOT);
		if (isset($tipo)) {
			$this->db->where('itf.tipo', $tipo);
		}
		$this->db->group_by('itf.iditemf');
		return $this->db->get();
	}
	# Obtener listado de items por OT
	public function getItemsBy($idOT)
	{
		$this->load->database('ot');
		$this->db->select('*');
		$this->db->from('item_tarea_ot AS itt');
	}

	//

	#==================================================================================================

	# resumen por OT de items
	public function getResumenCantItems($idOT)
	{
		$this->load->database('ot');
		return $this->db->select(
			'
				OT.idOT,
				OT.nombre_ot,
				tr.nombre_tarea,
				tr.fecha_inicio,
				tr.fecha_fin,
				tr.idtarea_ot,
				itt.iditem_tarea_ot,
				itt.unidad,
				itt.tarifa,
				itt.facturable,
				SUM(itt.cantidad) AS cant_total_plan,
				SUM(itt.duracion) AS dura_total_plan,
				SUM(itt.valor_plan),
				(
					SELECT SUM(rrd.cantidad)
					FROM recurso_reporte_diario AS rrd
					JOIN reporte_diario AS rd ON rrd.idreporte_diario = rd.idreporte_diario
					WHERE rd.OT_idOT = OT.idOT
					AND rrd.facturable = itt.facturable
					AND rrd.itemf_iditemf = itf.iditemf
				) AS cant_ejecutada,
				itf.*
			'
			)->from('item_tarea_ot AS itt')
			->join('tarea_ot AS tr','tr.idtarea_ot = itt.tarea_ot_idtarea_ot')
			->join('OT','OT.idOT = tr.OT_idOT')
			->join('itemf AS itf','itf.iditemf = itt.itemf_iditemf')
			->where('estado_tarifa',TRUE) //CORREGIR esto !!!!!!!!
			->where('OT.idOT',$idOT)
			->group_by('itf.iditemf')
			->order_by('itf.codigo','ASC')
			->get();
	}

	public function informeCargues($value='')
	{
		$this->load->database('ot');
		return $this->db->select('
				OT.nombre_ot,
				OT.base_idbase,
				OT.estado_doc As  estado,
				(
				  SELECT SUM(itt.cantidad)
				  FROM item_tarea_ot AS itt
				  JOIN tarea_ot AS tr ON itt.tarea_ot_idtarea_ot = tr.idtarea_ot
				  JOIN itemf AS itf ON itf.iditemf = itt.itemf_iditemf
				  WHERE tr.OT_idOT = OT.idOT
				  AND itf.tipo = 2
				) AS  personal_planeado,
				(
					SELECT COUNT(rot.idrecurso_ot)
					FROM recurso_ot AS rot
					JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
					JOIN persona AS p ON p.identificacion = r.persona_identificacion
					WHERE rot.OT_idOT = OT.idOT
				) AS personal_cargado,
				(
					SELECT SUM(itt.cantidad)
					FROM item_tarea_ot AS itt
					JOIN tarea_ot AS tr ON itt.tarea_ot_idtarea_ot = tr.idtarea_ot
					JOIN itemf AS itf ON itf.iditemf = itt.itemf_iditemf
					WHERE tr.OT_idOT = OT.idOT
					AND itf.tipo = 3
				) As equipo_planeado,
				(
					SELECT COUNT(rot.idrecurso_ot)
					FROM recurso_ot AS rot
					JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
					JOIN equipo AS e ON e.idequipo = r.equipo_idequipo
					WHERE rot.OT_idOT = OT.idOT
				) AS equipo_cargado
			')
			->from('OT')
			->group_by('OT.idOT')
			->get();
	}

	public function resumenOT($idOt='', $frentes=NULL)
	{
		$this->load->database('ot');
		$this->db->select('
				titc.descripcion AS tipo_itemc,
				OT.idOT,
				OT.nombre_ot,
				tr.nombre_tarea,
				tr.fecha_inicio,
				tr.fecha_fin,
				tr.idtarea_ot,
				itt.iditem_tarea_ot,
				itt.unidad,
				itt.tarifa,
				itt.facturable,
				itt.idsector_item_tarea,
				SUM(itt.cantidad_planeada) AS cantidad_planeada,
				itf.*
			')
			->from('OT')
			->join('tarea_ot AS tr', 'tr.OT_idOT = OT.idOT')
			->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
			->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf')
			->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc')
			->join('tipo_itemc AS titc', 'titc.idtipo_itemc = itc.idtipo_itemc')
			->where('OT.idOT',$idOt)
			->group_by('itf.codigo')
			->group_by('itt.facturable')
			->group_by('itt.idsector_item_tarea');
		$this->db->order_by('itf.tipo', 'ASC');
		if(isset($frentes)){
			$this->db->select('ft.nombre AS nombre_frente');
			$this->db->select('
				(
					SELECT SUM( getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) )
					FROM recurso_reporte_diario AS rrd
					JOIN reporte_diario AS rd ON rrd.idreporte_diario = rd.idreporte_diario
					WHERE rd.OT_idOT = OT.idOT
					AND rrd.facturable = TRUE
					AND rrd.cantidad > 0
					AND rrd.itemf_iditemf = itf.iditemf
					AND itt.idsector_item_tarea = rrd.idsector_item_tarea
					AND ft.idfrente_ot = rrd.idfrente_ot
				) AS cant_ejecutada,
				(
					SELECT SUM( getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) )
					FROM recurso_reporte_diario AS rrd
					JOIN reporte_diario AS rd ON rrd.idreporte_diario = rd.idreporte_diario
					WHERE rd.OT_idOT = OT.idOT
					AND rrd.facturable = FALSE
					AND rrd.cantidad > 0
					AND rrd.itemf_iditemf = itf.iditemf
					AND itt.idsector_item_tarea = rrd.idsector_item_tarea
					AND ft.idfrente_ot = rrd.idfrente_ot
				) AS cant_ejecutada_nofact,
			');
			$this->db->join('frente_ot AS ft', 'ft.idfrente_ot = itt.idfrente_ot', 'left');
			$this->db->group_by('ft.idfrente_ot');
			$this->db->order_by('itt.idfrente_ot', 'ASC');
		}else {
			$this->db->select('
				(
					SELECT SUM( getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) )
					FROM recurso_reporte_diario AS rrd
					JOIN reporte_diario AS rd ON rrd.idreporte_diario = rd.idreporte_diario
					WHERE rd.OT_idOT = OT.idOT
					AND rrd.facturable = TRUE
					AND rrd.cantidad > 0
					AND rrd.itemf_iditemf = itf.iditemf
					AND itt.idsector_item_tarea = rrd.idsector_item_tarea
				) AS cant_ejecutada,
				(
					SELECT SUM( getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) )
					FROM recurso_reporte_diario AS rrd
					JOIN reporte_diario AS rd ON rrd.idreporte_diario = rd.idreporte_diario
					WHERE rd.OT_idOT = OT.idOT
					AND rrd.facturable = FALSE
					AND rrd.cantidad > 0
					AND rrd.itemf_iditemf = itf.iditemf
					AND itt.idsector_item_tarea = rrd.idsector_item_tarea
				) AS cant_ejecutada_nofact,
			');
		}
		$this->db->order_by('itf.codigo', 'ASC');
		return $this->db->get();
	}
	// Mejora en el resumen
	# =================================================================================
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

	# ===================================================================================
	# informe de cierre
	public function getInfoGeneral($nombre_ot=NULL, $co=NULL)
	{
		$this->load->database('ot');
		$this->db->select("
						ot.idOT,
						ot.nombre_ot,
						'' AS resumen_tareas,
						(SELECT GROUP_CONCAT(tarea_ot.sap SEPARATOR ',' ) FROM tarea_ot WHERE tarea_ot.OT_idOT = ot.idOT) AS SAP,
						b.nombre_base,
						ot.vereda,
						ot.actividad,
						( SELECT MIN(tarea_ot.fecha_inicio) FROM tarea_ot WHERE tarea_ot.OT_idOT = ot.idOT ) AS fecha_inicio_plan,
						( SELECT MAX(tarea_ot.fecha_fin) FROM tarea_ot WHERE tarea_ot.OT_idOT = ot.idOT ) AS fecha_fin_plan,
						ot.fecha_inicio,
						ot.fecha_fin,
						( SELECT SUM(tarea_ot.valor_recursos) FROM tarea_ot WHERE tarea_ot.OT_idOT = ot.idOT ) AS valor_costo_directo
					")->from('OT AS ot')
					->join('base AS b', 'b.idbase = ot.base_idbase');
		if (isset($nombre_ot)) {
			$this->db->where('nombre_ot', $nombre_ot);
		}
		if(isset($co)){
			$this->db->where('base_idbase', $co);
		}
		$this->db->order_by('ot.idOT', 'asc');
		return $this->db->get();
	}
}
/* End of file Ot_db.php */
/* Location: ./application/models/Ot_db.php */
