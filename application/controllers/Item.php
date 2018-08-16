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
	# Importar items
	public function import()
	{
		$this->directorioBase();
		$path = '/uploads/items/cargue/'.date("Ymd");
		$config['upload_path'] = '.'.$path;
    $config['allowed_types'] = 'xlsx';
		$config['file_name'] = 'cargue.xlsx';
    $ret = new stdClass();
    $this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('myfile') ) {
      $ret->error = $this->upload->display_errors();
      $ret->status = FALSE;
      echo json_encode($ret);
    }
    else {
			$udata = $this->upload->data();
			$this->import_data_file('/uploads/items/cargue/'.date("Ymd").'/'.$udata['file_name']);
		}
	}

	private function import_data_file($path)
	{
		$this->load->helper('xlsx');
		$reader = getReader();
		$reader->open(FCPATH.$path);
		$this->load->model( array( 'itemc_db'=>'itc', 'itemf_db'=>'itf' ) );
		foreach ($reader->getSheetIterator() as $sheet) {
			$j=0;
			foreach ($sheet->getRowIterator() as $row) {
				$this->import_set_data($row);
				if($j > 100000)
			  	break;
			}
    }
    $reader->close();
	}

	private function import_set_data($row)
	{
		print_r($row);
	}

	private function directorioBase()
	{
		$this->crear_directorio('./uploads/items');
		$this->crear_directorio('./uploads/items/cargue');
		$this->crear_directorio('./uploads/items/cargue/'.date("Ymd"));
	}

	private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
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
