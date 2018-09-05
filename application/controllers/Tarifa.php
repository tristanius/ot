<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarifa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("America/Bogota");
	}

	public function gestion()
	{
		// code...
	}

	public function get_by_vigencia( $idvigencia )
	{
		$this->load->model(array('tarifa_db'=>'tf'));
		$ret = new stdClass();
		$ret->tarifas = $this->tf->getBy( array('vg.idvigencia_tarifas'=>$idvigencia) )->result();
		$ret->status = TRUE;
		echo json_encode( $ret );
	}

	public function save($value='')
	{
		// code...
	}

	public function add($value='')
	{
		// code...
	}

	public function mod($value='')
	{
		// code...
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
