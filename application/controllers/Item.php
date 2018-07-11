<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/bogota");
	}

	# Gestión del maestro de items por contrato
	public function gestion($idcontrato=NULL)
	{
		$this->load->model('itemc_db','item');
		$tipos_itemc = $this->item->getTiposItemc()->result();
		$this->load->view('items/itemc/gestion', array('idcontrato'=>$idcontrato, 'tipos_itemc'=>$tipos_itemc));
	}

	# --------------------------------------------------------------------------
	# Procedimientos de almacenado de items
	public function save()
	{
		if($this->sesion_iniciada()){
			$post = json_decode( file_get_contents('php://input') );
			$item = $post->item;
			$idcontrato = $post->idcontrato;
			$this->load->model(array('itemc_db'=>'itc', 'itemf_db'=>'itf'));
			# primero verificamos si el itemc ya existes
			$this->itc->init_transact();
			if (isset( $item->iditemc )) {
				$this->itc->mod($item);
			}else{
				$item->iditemc = $this->itc->add($item, $idcontrato);
			}
			# verificamos tambien itemf
			if($item->iditemf){
				$this->itf->mod($item);
			}else{
				$item->iditemf = $this->itf->add($item);
			}
			$ret = new stdClass();
			$ret->status = $this->itc->transac_status();
			$ret->item = $item;
			$this->itc->end_transact();
			echo json_encode($ret);
    }
	}


	public function get_itemc($idcontrato)
	{
		if($this->sesion_iniciada()){
			$ret = new stdClass();
			$this->load->model('itemc_db','item');
			$this->load->model('contrato_db','c');
			$rows = $this->c->getBy('idcontrato',$idcontrato);
			if ($rows->num_rows() > 0) {
				$ret->contrato = $rows->row();
				$ret->items = $this->item->getByContrato($idcontrato)->result();
				$ret->status = TRUE;
			}else{
				$ret->status = FALSE;
			}
			echo json_encode($ret);
    }
	}


	# --------------------------------------------------------------------------
	private function sesion_iniciada()
	{
		$this->load->library('session');
		if($this->session->userdata("isess")){
			return TRUE;
		}
		return FALSE;
	}

}

/* End of file Item.php */
/* Location: ./application/controllers/Item.php */
