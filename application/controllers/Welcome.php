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
			return TRUE;
		}
		return FALSE;
	}

	public function test($v1, $v2)
	{
		$this->load->database('ot');
		$data = $this->db->get_where('recurso_reporte_diario',array('idrecurso_reporte_diario >'=>$v1, 'idrecurso_reporte_diario <'=>$v2));
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
			}
			if ($tiempo > 10) {
				$tiempo = 10;
			}
			$this->db->update('recurso_reporte_diario', array('horas_ordinarias'=>$tiempo),'idrecurso_reporte_diario = '.$val->idrecurso_reporte_diario);
			//echo  $tiempo.': '.$val->hora_inicio.'-'.$val->hora_fin.' | '.$val->hora_inicio2.'-'.$val->hora_fin2."<br>";
		}
		echo 'Fin';
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
}
