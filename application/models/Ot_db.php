<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ot_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
	}

	public function getBases($value='')
	{
		$this->load->database('ot');
		return $this->db->get('base');
	}
	// Registrar una nueva OT.
	public function add(
		$nombre_ot, $ccosto, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad, $justificacion,
		$locacion, $abscisa, $departamento, $municipio, $vereda, $cc_ecp, $json, $sap, $gerencia, $sistema_ecp, $estado_doc,
		$ot_legalizada, $fecha_inicio, $fecha_fin, $presupuesto_fecha_ini, $presupuesto_porcent_ini, $presupuesto_fecha_fin, $presupuesto_porcent_fin, $fecha_creacion_cc=NULL
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
			'numero_sap'=>$sap,
			'gerencia'=>$gerencia,
			'sistema_ecp'=>$sistema_ecp,
			'estado_doc'=>$estado_doc,
			"ot_legalizada"=>$ot_legalizada,
			"fecha_inicio"=>$fecha_inicio,
			"fecha_fin"=>$fecha_fin,
			"presupuesto_fecha_ini"=>$presupuesto_fecha_ini,
			"presupuesto_porcent_ini"=>$presupuesto_porcent_ini,
			"presupuesto_fecha_fin"=>$presupuesto_fecha_fin,
			"presupuesto_porcent_fin"=>$presupuesto_porcent_fin,
			"fecha_creacion_cc"=>$fecha_creacion_cc
		);
		$this->db->insert('OT', $data);
		return $this->db->insert_id();
	}
	//Editar daos info de una OT.
	public function update(
		$idot, $nombre_ot, $ccosto, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad,
		$justificacion, $locacion, $abscisa, $departamento, $municipio, $vereda, $cc_ecp,  $json, $sap, $gerencia, $sistema_ecp, $estado_doc,
		$ot_legalizada, $fecha_inicio, $fecha_fin, $presupuesto_fecha_ini, $presupuesto_porcent_ini, $presupuesto_fecha_fin, $presupuesto_porcent_fin, $fecha_creacion_cc=NULL
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
			'numero_sap'=>$sap,
			'gerencia'=>$gerencia,
			'sistema_ecp'=>$sistema_ecp,
			'estado_doc'=>$estado_doc,
			"ot_legalizada"=>$ot_legalizada,
			"fecha_inicio"=>$fecha_inicio,
			"fecha_fin"=>$fecha_fin,
			"presupuesto_fecha_ini"=>$presupuesto_fecha_ini,
			"presupuesto_porcent_ini"=>$presupuesto_porcent_ini,
			"presupuesto_fecha_fin"=>$presupuesto_fecha_fin,
			"presupuesto_porcent_fin"=>$presupuesto_porcent_fin,
			"fecha_creacion_cc"=>$fecha_creacion_cc
		);
		return $this->db->update('OT', $data, "idOT =".$idot);
	}
  	// obetener información de una OT
	public function getData($idot){
		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('tipo_ot AS tp', 'OT.tipo_ot_idtipo_ot = tp.idtipo_ot');
		$this->db->where('OT.idOT', $idot);
		return $this->db->get();

	}
	//Obtener un listado de todas las OT
	public function getAllOTs($base = NULL, $nom = NULL){
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
		$this->db->select('*');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $id);
		if (isset($arr_tareas)) {
			$this->db->where_in('idtarea_ot', $arr_tareas);
		}
		return $this->db->get();
	}

	#=============================================================================

	# Obetener una Ot por un campo especificado por parametro
	public function getOtBy($campo, $valorbuscado)
	{
		$this->load->database('ot');
		return $this->db->get_where('OT',array($campo=>$valorbuscado));
	}

	# ===========================================================================
	# Consulta de items de OT
	# ===========================================================================

	# Obetner items por tipo de un OT
	public function getItemByTipeOT($idOT, $tipo=NULL)	{
		$this->load->database('ot');
		$this->db->select(
				'
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
				SUM(itt.cantidad) AS planeado
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

	public function resumenOT($idOt='')
	{
		$this->load->database('ot');
		return $this->db->select('
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
				itf.*
			')
			->from('OT')
			->join('tarea_ot AS tr', 'tr.OT_idOT = OT.idOT')
			->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
			->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf')
			->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc')
			->where('OT.idOT',$idOt)
			->group_by('itf.codigo')
			->group_by('itt.facturable')
			->group_by('itt.idsector_item_tarea')
			->get();
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
}
/* End of file Ot_db.php */
/* Location: ./application/models/Ot_db.php */
