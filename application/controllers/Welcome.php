<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		date_default_timezone_set('America/Bogota');
		header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
		header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
		header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE
		$this->load->helper('config');
		if ($this->sesion_iniciada()) {
			//print_r($this->session->userdata());
			$this->load->view('inicio/indice',array("content"=>$this->load->view('inicio/pestanas','',TRUE)));
		}else{
			redirect(app_termo());
			//$this->load->view('login/login');
		}
	}

	public function loadOptions()
	{
		$this->load->view('inicio/init');
	}

	private function sesion_iniciada()
	{
		$this->load->library('session');
		if($this->session->userdata("isess")){
			$this->permisos_visualizacion();
			return TRUE;
		}
		return FALSE;
	}

	public function permisos_visualizacion()
	{
		$this->load->library('session');
		$this->load->database('ot');
		$idbase = $this->session->userdata('base_idbase');
		$row = $this->db->from('base')->where( 'idbase', $idbase )->get()->row();
		$data = array(
			'sector' => $row->sector,
			'idsector' => $row->idsector
		);
		if ($this->session->userdata('tipo_visualizacion') == 'sector' ) {
			$data['bases'] = $this->db->from('base')->where( 'idsector', $row->idsector )->get()->result();
		}elseif ($this->session->userdata('tipo_visualizacion') == 'base' ) {
			$data['bases'] = $this->db->from('base')->where( 'idsector', $idbase )->get()->result();
		}elseif ($this->session->userdata('tipo_visualizacion') == 'general' ){
			$data['bases'] = $this->db->get('base')->result();
		}
		$this->session->set_userdata($data);
		$this->db->close();
	}

	public function corregirHoras($v1, $v2, $ot=NULL)
	{
		$this->load->database('ot');
		if (isset($ot)) {
			$this->db->where('OT.idOT', $ot);
		}else{
			$this->db->where('rrd.idrecurso_reporte_diario >',$v1);
			$this->db->where('rrd.idrecurso_reporte_diario <',$v2);
		}
		$data = $this->db->select("OT.nombre_ot, OT.base_idbase, rd.fecha_reporte, rrd.*")
	 			->from('recurso_reporte_diario AS rrd')
				->join("reporte_diario AS rd","rd.idreporte_diario = rrd.idreporte_diario")
				->join("OT","OT.idOT = rd.OT_idOT")
				->join("itemf AS itf","itf.iditemf = rrd.itemf_iditemf")
				->where('itf.tipo',2)
				->get();
		foreach ($data->result() as $key => $val) {
			$tiempo = 0;
			if ( is_numeric($val->hora_inicio) || is_numeric($val->hora_fin2) ) {
				if (is_numeric($val->hora_inicio)) {
					$tiempo += (is_numeric($val->hora_fin)?$val->hora_fin:0 ) - $val->hora_inicio;
				}
				if (is_numeric($val->hora_inicio2)) {
					$tiempo += (is_numeric($val->hora_fin2)?$val->hora_fin2:0 ) - $val->hora_inicio2;
				}
				if (!is_numeric($val->hora_fin) && !is_numeric($val->hora_inicio2)) {
					$tiempo = $val->hora_fin2 - $val->hora_inicio -($val->hr_almuerzo?0:1);
				}
			}elseif( $this->isHora($val->hora_inicio) || $this->isHora($val->hora_fin2) ){
				if ( $this->isHora($val->hora_inicio) ) {
					$tiempo += $this->getTiempo($val->hora_inicio, $val->hora_fin);
				}
				if ( $this->isHora($val->hora_inicio2) ) {
					$tiempo += $this->getTiempo($val->hora_inicio2, $val->hora_fin2);
				}
				if ( !$this->isHora($val->hora_inicio2) && !$this->isHora($val->hora_fin) ) {
					$tiempo = $this->getTiempo($val->hora_inicio, $val->hora_fin2) -($val->hr_almuerzo?1:0);
				}
			}else{
				echo '------------------------------------------------- '.$val->hora_inicio.'-'.$val->hora_fin.' | '.$val->hora_inicio2.'-'.$val->hora_fin2.'<br>';
			}
			if ($tiempo >= 10) {
				if($val->base_idbase == 172 || $val->base_idbase == 173 || $val->base_idbase == 174 || $val->base_idbase == 194 )
					$tiempo = 9;
				else
					$tiempo = 8;
			}
			$bandera = $this->db->update('recurso_reporte_diario', array('horas_ordinarias'=>$tiempo),'idrecurso_reporte_diario = '.$val->idrecurso_reporte_diario);
			if($bandera)
				echo  $tiempo.' '.$val->nombre_ot.': '.$val->hora_inicio.'-'.$val->hora_fin.' | '.$val->hora_inicio2.'-'.$val->hora_fin2."<br>";
		}
		echo "<a href='".site_url("welcome/corregirHoras/".($v1+1000)."/".($v2+1000)."/".(isset($ot)?$ot:""))."' > Siguiente </a>";
	}

	private function getTiempo($hr_inicio, $hr_fin)
	{
		$h1t1 = substr($hr_inicio,0,strpos($hr_inicio,':'));
		$min1t1 = substr($hr_inicio,strpos($hr_inicio,':')+1,2);
		$h2t1 = substr($hr_fin,0,strpos($hr_fin,':'));
		$min2t1 = substr($hr_fin,strpos($hr_fin,':')+1,2);
		return (is_numeric($h2t1)?$h2t1:0) - $h1t1 + ( ($min2t1 >= 45?1:0) - ($min1t1 >= 45?1:0) ) ;
	}

	private function isHora($val)
	{
		if ( strpos($val, ':')>0 && strlen($val)>3 ){
			#$v = substr($val,0,strpos($val,':'));
			#$v2 = substr($val,strpos($val,':')+1,2);
			#echo $v.' y '.$v2.'<br>';
			return true;
		}
		return false;
	}

	public function mytest()
	{
		$this->load->database('ot');
		$this->EE->db->save_queries = TRUE;
		$this->load->model('Facturacion_db','fac');
		$this->fac->informeFacturacion('2017-10-01','2017-10-15');
		echo $this->db->last_query();
	}
}
