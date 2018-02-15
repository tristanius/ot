<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miscelanio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Bogota');
	}

	public function index()
	{

	}

	public function getMunicipios()
	{
		$post = json_decode(file_get_contents("php://input"));
		$this->load->model('miscelanio_db');
		$res = $this->miscelanio_db->getMunicipios($post->departamento);
		echo json_encode($res->result());
	}

	public function getVeredas()
	{
		$post = json_decode(file_get_contents("php://input"));
		$this->load->model('miscelanio_db');
		$res = $this->miscelanio_db->getVeredas($post->municipio);
		echo json_encode($res->result());
	}

	public function getMaps($id)
	{
		$this->load->database('ot');
		$res = $this->db->get_where('municipio',array('idpoblado'=>$id));
		$m = $res->row();
		echo '<a href="https://www.google.com.co/maps/@'.$m->latitud.','.$m->longitud.',12z" target="_blank"><small>Ver en Google Maps</small></a>';
		echo '<br>';
	}

	public function getTarifaGV($id)
	{
		$this->load->model('miscelanio_db','misc');
		$row = $this->misc->getTarifaGV_by($id)->row();
		echo json_encode($row);
	}

	public function cargarExcel()
	{
		$this->load->helper('excel');
		$data = readExcel('salarios_item2016.xlsx')->toArray(null,true,true,true);
		$this->load->model('tarifa_db');
		$header = array_shift($data);
		foreach ($data as $key=>$row){
			$tarifasItem = $this->tarifa_db->getTarifasByItemc($row['A']);
			foreach ($tarifasItem->result() as $fila) {
				$this->tarifa_db->updateSalario($fila->iditemf, $row['B'], $row['C']);
			}
		}
	}

	public function test()
	{
		/*
		$fstr = '19-03-2016';
		$dt = new DateTime( str_replace("/", "-",$fstr) );
		$date = $dt->format('d/m/Y');
		echo $date;*/
		echo date( 'Ymd', strtotime( '-1 day', strtotime('01-03-2016') ) );
	}

	public function getLog()
	{
		$post = json_decode( file_get_contents("php://input") );
		$this->load->database('ot');
		$log = $this->db->select('idlog_movimiento, idregistro, tabla, idusuario, nombre_usuario, movimiento, fecha, referencia')
			->from('log_movimiento')
			->where('idregistro',$post->idregistro)
			->where('tabla',$post->tabla)
			->get();
		$this->load->view('login/log', array('log'=>$log));
	}
	public function addLog()
	{
		$post = json_decode( file_get_contents("php://input") );
		$this->load->helper('log');
		if (isset($post->log)) {
			addLog(
				$post->log->idusuario,
				$post->log->nombre_usuario,
				$post->idregistro,
				$post->tabla,
				$post->descripcion,
				date('Y-m-d H:i:s'),
				isset($post->nota)?$post->nota:NULL
			);
		}
		echo 'Registro agregado';
	}
	#============================================================================================
	# Funciones de maestros
	# ===========================================================================================

	# subir personas
	public function formUpPersona(){
    $this->load->view('persona/uploadPerOT');
  }
	# subir equipos
	public function formUpEquipo(){
    $this->load->view('equipo/uploadEquOT');
  }

	#============================================================================================
	# Temporal
	# ===========================================================================================
	public function duplicarFrente($idreporte, $fechaDeseada, $idfrente)
	{
		$this->load->model('miscelanio_db', 'md');
		$this->load->model('reporte_db', 'rd');
		// reporte actual
		$repos = $this->rd->getBy(NULL, NULL, $idreporte);
		$repo = $repos->row();
		// recursos a duplicar
		$rows = $this->md->getRecReporteFrente($idreporte, $idfrente);
		// reporte a actualizar recursos
		$rds = $this->rd->getBy($repo->idOT, $fechaDeseada);
		$rd = $rds->row();
		foreach ($rows->result() as $key => $r) {
			$this->rd->addRecursoRepo($r, $rd->idreporte_diario);
			echo $r->idrecurso_reporte_diario;
		}
	}

}

/* End of file Miscelanio.php */
/* Location: ./application/controllers/Miscelanio.php */
