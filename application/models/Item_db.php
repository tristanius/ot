<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function add($cod, $descrip, $und, $tipo, $iditemc, $item)
	{
		$this->load->database('ot');
		$data = array(
			'codigo' => $cod,
			'descripcion' => $descrip,
			'unidad' => $und,
			'tipo' => $tipo,
			'itemc_iditemc'=>$iditemc,
			'itemc_item'=>$item
		);
		$this->db->insert('itemf', $data);
		return $this->db->insert_id();
	}

	public function addTarifa($tarifa, $fecha_inicio, $salario, $iditemf, $cod, $estadoTarifa = FALSE)
	{
		$this->load->database('ot');
		$data = array(
			'tarifa'=>$tarifa,
			'fechap'=>$fecha_inicio,
			'salario'=>$salario,
			'estado_salario'=> ($salario != 0 || $salario != '')?1:0,
			'itemf_codigo' => $cod,
			'itemf_iditemf'=>$iditemf,
			'estado_tarifa'=>$estadoTarifa
		);
		$this->db->insert('tarifa', $data);
	}

	public function getAll($value='')
	{
		$this->load->database('ot');
		$this->db->select(
			'itemf.iditemf,
			itemf.codigo,
			itemc.unidad AS unidad,
			itemc_item,
			itemf.iditemf,
			itemf.codigo,
			itemf.descripcion AS descripcion,
			itemf.itemc_item,
			itemf.tipo AS tipo_item,
			tarifa.salario,
			tarifa.estado_salario,
			tarifa.tarifa,
			titemc.CL,
			titemc.BO,
			0 AS add');
		$this->db->from('itemf');
		$this->db->join('itemc','itemf.itemc_iditemc = itemc.iditemc');
		$this->db->join('tipo_itemc AS titemc','titemc.idtipo_itemc = itemc.idtipo_itemc');
		$this->db->join('tarifa','tarifa.itemf_iditemf = itemf.iditemf');
		$this->db->where('tarifa.estado_tarifa', TRUE);
		//$this->db->where('tarifa.periodo_id = ( SELECT MAX(tarifa.periodo_id) as periodo FROM tarifa)', NULL, FALSE);
		return $this->db->get();
	}
	public function getByTipo($value='')
	{
		$this->load->database('ot');
		$this->db->select(
			'itemf.iditemf,
			itemf.codigo,
			itemc.unidad AS unidad,
			itemc_item,
			itemf.iditemf,
			itemf.codigo,
			itemf.descripcion AS descripcion,
			itemf.itemc_item,
			itemf.tipo AS tipo_item,
			tarifa.idtarifa,
			tarifa.idvigencia_tarifas,
			tarifa.salario,
			tarifa.estado_salario,
			tarifa.tarifa,
			titemc.CL,
			titemc.BO,
			v.descripcion_vigencia,
			0 AS add');
		$this->db->from('itemf');
		$this->db->join('itemc','itemf.itemc_iditemc = itemc.iditemc');
		$this->db->join('tipo_itemc AS titemc','titemc.idtipo_itemc = itemc.idtipo_itemc','LEFT');
		$this->db->join('tarifa','tarifa.itemf_iditemf = itemf.iditemf');
		$this->db->join('vigencia_tarifas AS v','v.idvigencia_tarifas = tarifa.idvigencia_tarifas');
		$this->db->where('itemf.tipo', $value);
		$this->db->where('v.estado', TRUE);
		// $this->db->where('tarifa.periodo_id = ( SELECT MAX(tarifa.periodo_id) as periodo FROM tarifa)', NULL, FALSE);
		$this->db->order_by('itemf.itemc_iditemc', 'asc');
		return $this->db->get();
	}
	# Guarda la un item planeado de una tarea de OT
	public function setItemTarea(
			$cantidad,
			$duracion,
			$unidad,
			$tarifa,
			$valor_plan,
			$fecha_creacion,
			$itemf_iditemf,
			$itemf_codigo,
			$idTr,
			$facturable,
			$sector,
			$idvigencia_tarifas
		){
		$data = array(
			'cantidad'=>$cantidad,
			'duracion'=>$duracion,
			'cantidad_planeada'=> ($cantidad * $duracion),
			'unidad'=>$unidad,
			'tarifa'=>$tarifa,
			'valor_plan'=>$valor_plan,
			'fecha_agregado'=>$fecha_creacion,
			'itemf_iditemf'=>$itemf_iditemf,
			'itemf_codigo'=>$itemf_codigo,
			'tarea_ot_idtarea_ot'=>$idTr,
			'facturable'=>$facturable,
			'idsector_item_tarea'=>$sector,
			'idvigencia_tarifas'=>$idvigencia_tarifas
		);
		$this->db->insert('item_tarea_ot', $data);
	}
	#Actuliza un items de una tarea perteneciente a una Orden de Trabajo
	public function updateItemTarea(
			$iditem_tarea_ot,
			$cantidad,
			$duracion,
			$unidad,
			$tarifa,
			$valor_plan,
			$fecha_creacion,
			$itemf_iditemf,
			$itemf_codigo,
			$idTr,
			$facturable,
			$sector,
			$idvigencia_tarifas
		){
		$data = array(
			'cantidad'=>$cantidad,
			'duracion'=>$duracion,
			'cantidad_planeada'=> ($cantidad * $duracion),
			'unidad'=>$unidad,
			'tarifa'=>$tarifa,
			'valor_plan'=>$valor_plan,
			//'fecha_agregado'=>$fecha_creacion,
			'itemf_iditemf'=>$itemf_iditemf,
			'itemf_codigo'=>$itemf_codigo,
			'tarea_ot_idtarea_ot'=>$idTr,
			'facturable'=>$facturable,
			'idsector_item_tarea'=>$sector,
			'idvigencia_tarifas'=>$idvigencia_tarifas
		);
		$this->db->update('item_tarea_ot', $data, 'iditem_tarea_ot = '.$iditem_tarea_ot);
	}

	# ================================================================================================
	# Consultas
	# ================================================================================================

	# Obtener items de una tarea especifica por tipo
	public function getItemsByTarea($idTarea, $idTipo_item, $fac = NULL)
	{
		$this->load->database('ot');
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
		$this->db->where('itt.tarea_ot_idtarea_ot', $idTarea);
		$this->db->where('itf.tipo', $idTipo_item);
		if (isset($fac) && $fac ) {
			$this->db->where('itt.facturable', TRUE);
		}
		$this->db->order_by('itf.codigo', 'asc');
		return $this->db->get();
	}

	public function getRecursosFromTarea($idOT, $idTarea)
	{
		$this->load->database('ot');
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
		$this->db->where('itt.tarea_ot_idtarea_ot', $idTarea);
		return $this->db->get();
	}

	public function getField($where, $select, $table)
	{
		$this->load->database('ot');
		$this->db->select($select)->from($table)->where($where);
		return $this->db->get();
	}


	public function getItemsBy($idTarea, $idTipo_item, $fac = NULL)
	{
		$this->load->database('ot');
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('tarea_ot AS tr', 'tr.idtarea_ot = itt.tarea_ot_idtarea_ot');
		$this->db->join('OT', 'OT.idOT = tr.OT_idOT');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
		$this->db->where('itt.tarea_ot_idtarea_ot', $idTarea);
		$this->db->where('itf.tipo', $idTipo_item);
		if (isset($fac) && $fac ) {
			$this->db->where('itt.facturable', TRUE);
		}
		$this->db->order_by('itf.codigo', 'asc');
		return $this->db->get();
	}

	# Obtiene las cantidades Maximas por item de una OT en un periodo
	public function get_ordenes_mes($obj, $byOT = FALSE)
	{
		$this->load->database('ot');
		$this->db->select(
			"
			OT.idOT,
			OT.nombre_ot,
			b.idbase,
			b.nombre_base,
			MIN(tr.fecha_inicio) AS fecha_inicio,
			MAX(tr.fecha_fin) AS fecha_fin
			"
		)->from('OT')
		->join('base AS b', 'b.idbase = OT.base_idbase')
		->join('tarea_ot AS tr','tr.OT_idOT = OT.idOT ')
		->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
		->join('itemf AS itf','itf.iditemf = itt.itemf_iditemf')
		->where('tr.fecha_inicio BETWEEN "'.$obj->fecha_i.'" AND "'.$obj->fecha_f.'" ')
		->order_by('OT.base_idbase','ASC')
		->group_by('OT.idOT');
		if (count($obj->bases) > 0) {
			$this->db->where_in('OT.base_idbase', $obj->bases);
		}
		if (isset($obj->nombre_ot) && $obj->nombre_ot != '') {
			$this->db->like('OT.nombre_ot', $obj->nombre_ot);
		}
		return $this->db->get();
	}

	#Obtiene las cantidades por día de cada item presentado en la OT
	public function getCantidadesDia($obj)
	{
		$this->load->database('ot');
		$this->db->select( $this->getSelectCantidadesDia( $obj->dias, $obj->mes, $obj->year) )->from('OT')
		->join('base AS b', 'b.idbase = OT.base_idbase')
		->join('tarea_ot AS tr','tr.OT_idOT = OT.idOT ')
		->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
		->join('itemf AS itf','itf.iditemf = itt.itemf_iditemf')
		->join('itemc AS itc','itc.iditemc = itf.itemc_iditemc')
		->where('tr.fecha_inicio BETWEEN "'.$obj->fecha_i.'" AND "'.$obj->fecha_f.'" ')
		->where('OT.idOT', $obj->idOT)
		->order_by('itf.codigo','ASC')
		->group_by('itf.codigo');
		return $this->db->get();
	}

	private function getSelectCantidadesDia($dias='', $mes, $year)
	{
		$sel = '
			OT.nombre_ot AS NoOrden,
			OT.base_idbase AS CO,
			b.nombre_base AS Base,
			itf.codigo,
			itf.descripcion,
		';

		for ($i=1; $i <= $dias ; $i++) {
			$sel .= '
			(
				SELECT
					ROUND(
						SUM(
							if(
								substring(itf.itemc_item,1,1)="3",
								if(
									itf.unidad="hr",
									if(
										(rrd.horas_operacion-4)>0,
										rrd.horas_operacion,
									4),
									if(
										rrd.horas_operacion=0,
										if(
											rrd.horas_disponible = 0,
											if((itc.hrdisp/itc.basedisp)=1,1,0),
											(itc.hrdisp/itc.basedisp) ),
									1)
								),
							1)*rrd.cantidad
						),
					3) as cantidad_total
				FROM	reporte_diario AS rd
				JOIN recurso_reporte_diario AS rrd ON rd.idreporte_diario = rrd.idreporte_diario
				WHERE rd.fecha_reporte = "'.$year.'-'.$mes.'-'.$i.'"
				AND rrd.itemf_iditemf = itf.iditemf
				AND rd.OT_idOT = OT.idOT
				GROUP BY rd.idreporte_diario, rrd.itemf_iditemf
			 ) AS d'.$i.', ';
		}
		$sel .='itf.itemc_item AS item';
		return $sel;
	}

	public function getItemfBy($campo, $valorB, $tabla)
	{
		$this->load->database('ot');
		return $this->db->get_where($tabla, array($campo=>$valorB,));
	}

	public function getItemfByvigencia($field,$val)
	{
		$this->load->database('ot');
		return $this->db->select('itf.*')->from('itemf AS itf')
							->join('tarifa AS tr','tr.itemf_iditemf = itf.iditemf')
							->join('vigencia_tarifas AS v', 'v.idvigencia_tarifas = tr.idvigencia_tarifas')
							->where('v.estado',TRUE)
							->where($field, $val)
							->get();
	}

	public function getVigenciasActivas($id=NULL, $status=TRUE)
	{
		$this->load->database('ot');
		if (isset($id)) {
			$this->db->where('vg.idvigencia_tarifas', $id);
		}else{
			$this->db->where('vg.estado',$status);
		}
		return $this->db->select('vg.*, CONCAT(vg.descripcion_vigencia, " By: ",  c.contratista ) AS descripcion_vigencia, c.no_contrato, c.contratista')
								->from('vigencia_tarifas AS vg')
								->join('contrato AS c','c.idcontrato = vg.idcontrato')
								->get();
	}

	public function getItemByOT($ot, $codigo=NULL, $item=NULL)
	{
		$this->load->database('ot');
		if(isset($codigo)){
			$this->db->like('itf.codigo',$codigo);
		}elseif (isset($item)) {
			$this->db->like('itf.itemc_item',$item);
		}
		return $this->db->select('OT.idOT, OT.nombre_ot, tr.idtarea_ot, tr.nombre_tarea, itt.*, itf.*, tarf.idtarifa, tarf.idvigencia_tarifas, tarf.estado_tarifa, tarf.tarifa, tarf.salario')
								->from('OT')
								->join('tarea_ot AS tr', 'tr.OT_idOT = OT.idOT')
								->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
								->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf')
								->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc')
								->join('tarifa  AS tarf', 'tarf.itemf_iditemf = itf.iditemf')
								->like('OT.nombre_ot',$ot)
								->order_by('itt.iditem_tarea_ot','DESC')
								->get();
	}

}

/* End of file Item_db.php */
/* Location: ./application/models/Item_db.php */
