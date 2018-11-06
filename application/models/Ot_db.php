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
		$this->db->from('tarea_ot as tr');
		$this->db->join('vigencia_tarifas AS vg', 'vg.idvigencia_tarifas = tr.idvigencia_tarifas', 'left');
		$this->db->where('OT_idOT', $idOt);
		$this->db->where('idtarea_ot', $idTarea);
		return $this->db->get();
	}
	# Obtiene un listado de taras
	public function getTareas($id, $arr_tareas=NULL)
	{
		$this->load->database('ot');
		$this->db->select('tr.*, IFNULL(tr.a, vg.a) AS a, IFNULL(tr.i, vg.i) AS i, IFNULL(tr.u, vg.u) AS u');
		$this->db->from('tarea_ot AS tr');
		$this->db->join('vigencia_tarifas AS vg', 'vg.idvigencia_tarifas = tr.idvigencia_tarifas', 'left');
		$this->db->where('OT_idOT', $id);
		if (isset($arr_tareas)) {
			$this->db->where_in('idtarea_ot', $arr_tareas);
		}
		return $this->db->get();
	}
	// funcion para obtener el numero SAP
  public function getSAP($idOT='', $fecha)
  {
    $this->load->database('ot');
    $rows = $this->db->select('tr.sap')
                ->from( 'OT' )
                ->join( 'tarea_ot AS tr', 'tr.OT_idOT = OT.idOT' )
                ->where( 'OT.idOT', $idOT )
                ->where( 'tr.fecha_inicio <= "'.$fecha.'"' )
                ->order_by('tr.idtarea_ot','DESC')
                ->get();
    if($rows->num_rows() > 0){
      return $rows->row()->sap;
    }
    return "";
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

	public function getBy($where)
	{
		$this->load->database('ot');
		foreach ($where as $key => $val) {
			if($key == 'OT.nombre_ot'){
				$this->db->like($key, $val);
			}else{
				$this->db->where($key, $val);
			}
		}
		return $this->db->from('OT')->get();
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

	#==================================================================================================

	# resumen por OT de items
	# Donde se usa?
	public function getResumenCantItems($idOT)
	{
		$this->load->database('ot');
	}

	# Donde se usa?
	public function resumenCantidades()
	{
		$this->load->database('ot');
		return $this->db->get();
	}

	public function resumenItems($idOT, $idfrente=NULL)
	{
		$this->load->database('ot');
		$this->db->select('OT.idOT, OT.nombre_ot, OT.estado_doc, ');
		$this->db->select('itf.iditemf, itc.item, itf.codigo, itf.descripcion,');
		$this->db->select('( SELECT tarifa.tarifa FROM tarifa WHERE tarifa.itemf_iditemf = itf.iditemf ORDER BY tarifa.idtarifa DESC LIMIT 1 ) AS tarifa, ');
		$this->db->select('tip.grupo_mayor AS tipo_item, IF(itt.facturable, "SI", "NO") AS facturable, ');
		$this->db->select('IFNULL( (SELECT	SUM(itt2.cantidad) FROM item_tarea_ot AS itt2 WHERE itt2.itemf_iditemf = itt.itemf_iditemf'.( isset($idfrente)? ' AND itt2.idfrente_ot = '.$idfrente : '' ).'), "-"	) AS cantidad, ');
		$this->db->select('IFNULL( (SELECT	SUM(itt2.duracion) FROM item_tarea_ot AS itt2 WHERE itt2.itemf_iditemf = itt.itemf_iditemf'.( isset($idfrente)? ' AND itt2.idfrente_ot = '.$idfrente : '' ).'), "-"	) AS duracion, ');
		$this->db->select('IFNULL( (SELECT	SUM(itt2.cantidad_planeada) FROM item_tarea_ot AS itt2 WHERE itt2.itemf_iditemf = itt.itemf_iditemf'.( isset($idfrente)? ' AND itt2.idfrente_ot = '.$idfrente : '' ).'), "-"	) AS cantidad_planeada,');
		if (isset($idfrente)) {
			$this->db->select('( SELECT CONCAT(ft.nombre, " - ", ft.ubicacion) FROM frente_ot AS ft WHERE ft.idfrente_ot = '.$idfrente.' ) AS frente, ');
		}
		$this->db->select('"0" AS cantidad_ejecuda_fact, "0" AS cantidad_ejecuda_nofact');
		$this->db->from('OT');
		$this->db->join('tarea_ot AS tarea', 'tarea.OT_idOT = OT.idOT');
		$this->db->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tarea.idtarea_ot');
		$this->db->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf');
		$this->db->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc');
		$this->db->join('tipo_itemc AS tip', 'tip.idtipo_itemc = itc.idtipo_itemc');
		$this->db->where('OT.idOT', $idOT);
		$this->db->group_by('itf.iditemf, itt.facturable');
		$this->db->order_by('itf.codigo','ASC');
		$this->db->order_by('itt.facturable', 'ASC');
		return $this->db->get();
	}

	public function getCantidadesItems($idOT, $idfrente = NULL)
	{
		$cantidades = new stdClass();
		$this->db->select('SUM(rrd.cantidad) AS cantidad, rrd.facturable, itf.iditemf');
		$this->db->from('recurso_reporte_diario AS rrd');
		$this->db->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario');
		$this->db->join('OT', 'OT.idOT = rd.OT_idOT');
		$this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
		$this->db->where('OT.idOT', $idOT);
		if (isset($idfrente)) {
			$this->db->where('rrd.idfrente_ot', $idfrente);
		}
		$this->db->group_by('rrd.itemf_iditemf, rrd.facturable');
		$this->db->order_by('itf.codigo','ASC');
		$this->db->order_by('rrd.facturable', 'ASC');
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

	public function getPlaneacion($where, $bases)
	{
		$this->load->database('ot');
		$select = 'OT.nombre_ot, IF(OT.basica, "SI", "NO") AS orden_primaria, tr.nombre_tarea, itt.fecha_ini AS inicio_item, itt.fecha_fin AS final_item, ';
		$select .= 'itf.codigo, itf.descripcion, itf.unidad, itf.itemc_item, itt.cantidad, itt.duracion, itt.cantidad_planeada, ';
		$select .= 'itt.tarifa, itt.subtarifa, tipo.descripcion AS tipo, tr.fecha_inicio AS inicio_tarea, tr.fecha_fin AS fin_tarea';
		$this->db->select($select);
		if (isset($where)) {
			$this->db->where($where);
		}
		if(isset($bases)){
			$this->db->or_where_in('OT.base_idbase', $bases);
		}
		return $this->db->from('OT')->join('tarea_ot AS tr','tr.OT_idOT = OT.idOT')
			->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
			->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf')
			->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc')
			->join('tipo_itemc AS tipo', 'tipo.idtipo_itemc = itc.idtipo_itemc')
			->join('vigencia_tarifas AS vg', 'vg.idvigencia_tarifas = itt.idvigencia_tarifas', 'LEFT')
			->join('tarifa AS tarf', 'tarf.itemf_iditemf = itt.itemf_iditemf','LEFT')
			->join('contrato AS c', 'c.idcontrato = OT.idcontrato')
			->get();
	}
}
/* End of file Ot_db.php */
/* Location: ./application/models/Ot_db.php */
