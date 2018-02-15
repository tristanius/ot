<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miscelanio_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function getDepartamentos($value='')
	{
		$this->load->database('ot');
		$this->db->select('departamento');
		$this->db->from('municipio');
		$this->db->group_by('departamento');
		return $this->db->get();
	}

	public function getMunicipios($depart='')
	{
		$this->load->database('ot');
		$this->db->select('municipio');
		$this->db->from('municipio');
		$this->db->where('departamento',$depart);
		$this->db->group_by('municipio');
		return $this->db->get();
	}

	public function getVeredas($muni='')
	{
		$this->load->database('ot');
		$this->db->select('*');
		$this->db->from('municipio');
		$this->db->where('municipio',$muni);
		return $this->db->get();
	}

	public function getEspecialidadesOT()
	{
		$this->load->database('ot');
		return $this->db->get('especialidad');
	}
	public function getSectorItems()
	{
		$this->load->database('ot');
		return $this->db->get('sector_item_tarea');
	}
	public function getEstadosLabor($tipo='persona')
	{
		$this->load->database('ot');
		return $this->db->get_where('estado_labor',array('grupo' => $tipo ));
	}
	public function getTiposOT()
	{
		$this->load->database('ot');
		return $this->db->get('tipo_ot');
	}

	public function getTarifasGV()
	{
		$this->load->database('ot');
		return $this->db->get_where('tarifas_gv', array('estado'=>TRUE));
	}

	public function getTarifaGV_by($id)
	{
		$this->load->database('ot');
		return $this->db->select('*')
				->from('tarifas_gv')
				->where('idtarifa_gv',$id)
				->where('estado',TRUE)
				->get();
	}

	public function getDataEstados()
	{
		$this->load->database('ot');
		return $this->db->get('validacion_doc');
	}


	public function sabanaPlaneacion()
	{
		$this->load->database('ot');
		return $this->db->select('
				OT.nombre_ot,
				tr.nombre_tarea,
				OT.numero_sap,
				OT.base_idbase,
				OT.vereda,
				OT.descripcion,
				OT.cuenta_mayor,
				esp.nombre_especialidad,

			')
			->from('')
			->join();
	}

	public function getBasesBySector()
	{
		$this->load->database('ot');
		$sectores = $this->db->select('sector')->from('base')->group_by('sector')->get()->result();
		foreach ($sectores as $key => $val) {
			$val->bases = $this->db->get_where('base', array('sector'=>$val->sector))->result();
		}
		return $sectores;
	}

	public function setAllCostosMes()
	{
		$this->load->database('ot');
		$ots = $this->db->get('OT');
		foreach ($ots->result() as $k => $v) {
			$rows = $this->db->get_where('costo_mes_ot', array('OT_idOT'=>$v->idOT));
			if($rows->num_rows() <= 0){
				$this->db->insert('costo_mes_ot', array('OT_idOT'=>$v->idOT, 'year'=>date('y')));
			}
		}
	}
	#============================================================================================
	# Temporal
	# ===========================================================================================
	public function getRecReporteFrente($idreporte, $idfrente)
	{
		$this->load->database('ot');
		return $this->db->from('reporte_diario AS rd ')
			->join('recurso_reporte_diario AS rrd','rrd.idreporte_diario  = rd.idreporte_diario')
			->where('rd.idreporte_diario',$idreporte)
			->where('rrd.idfrente_ot', $idfrente)
			->get();
	}
}

/* End of file Miscelanio_db.php */
/* Location: ./application/models/Miscelanio_db.php */
