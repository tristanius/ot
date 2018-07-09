<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/bogota");
	}

	public function gestion($idcontrato=NULL)
	{
		$this->load->view('items/itemc/gestion', array('idcontrato'=>$idcontrato));
	}

	public function get_itemc($idcontrato)
	{
		$ret = new stdClass();
		$this->load->model('itemc_db','item');
		$ret->items = $this->item->getByContrato($idcontrato)->result();
		$ret->status = TRUE;
		echo json_encode($ret);
	}

}

/* End of file Item.php */
/* Location: ./application/controllers/Item.php */
