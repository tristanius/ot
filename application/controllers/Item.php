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
		$this->load->view('contrato/items/itemc/gestion', array('idcontrato'=>$idcontrato, 'tipos_itemc'=>$tipos_itemc));
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
		;
		$path = $this->directorioBase();
		$config['upload_path'] = '.'.$path;
    $config['allowed_types'] = 'xlsx';
		$config['file_name'] = 'cargue.xlsx';

		$idcontrato = $this->input->post('idcontrato');

    $ret = new stdClass();
    $this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('myfile') ) {
      $ret->error = $this->upload->display_errors();
      $ret->status = FALSE;
      echo json_encode($ret);
    } else {
			$udata = $this->upload->data();
			$ret = $this->import_data_file( $path.'/'.$udata['file_name'], $idcontrato );
			echo json_encode($ret);
		}
	}

	private function import_data_file($path, $idcontrato)
	{
		$this->load->helper('xlsx');
		$reader = getReader();
		$reader->open(FCPATH.$path);

		$this->load->model( array( 'itemc_db'=>'itc', 'itemf_db'=>'itf' ) );
		$this->itc->init_transact();

		$resultados = array();
		$ret = new stdClass();
		$ret->status =TRUE;

		foreach ($reader->getSheetIterator() as $sheet) {
			$j=0;
			foreach ($sheet->getRowIterator() as $row) {
				if( $j > 0 ){
					$item = $this->getItemSchema($row, $idcontrato);
					if(isset($item)){
						$row['resultado'] = $this->addItem(); # Metodo creado para simplificar el codigo
					}else{
						$row['resultado'] = 'No se pudo formar la estructura del item.';
						$ret->status = FALSE;
					}
					array_push($resultados, $row);
				}
				$j++;
			}
    }
		if($this->itc->transac_status() === FALSE || !$ret->status){
			$this->itc->rollback();
		}else{
			$this->itc->commit();
		}
    $reader->close();
		$ret->resultados = $resultados;
		return $ret;
	}

	private function getItemSchema($row, $idcontrato)
	{
		try {
			$it = new stdClass();
			$it->item = $row[0];
			$it->codigo = $row[1];
			$it->descripcion = $row[2];
			$it->descripcion_interna = $row[3];
			$it->unidad = $row[4];
			$it->tipo = isset($row[5])? strtolower($row[5]) :NULL;
			$it->idtipo_itemc = $row[6];
			$it->basedisp = isset($row[7])?$row[7]:NULL;
			$it->hrdisp = isset($row[8])?$row[8]:NULL;
			$it->und_minima = isset($row[9])?$row[9]:NULL;
			$it->idusuario = $this->session->userdata('idusuario');
			$it->incidencia = isset($row[10])?$row[10]:NULL;
			$it->grupo = isset($row[11])?$row[11]:NULL;
			$it->idcontrato = $idcontrato;
			return $it;
		} catch (Exception $e) {
			return NULL;
		}

	}

	public function addItem($item, $idcontrato)
	{
		$tipo = $item->tipo;
		$items = $this->itc->getBy( array('itemc.item'=>$item->item, 'itemc.idcontrato'=>$idcontrato, 'itemc.tipo'=>$item->tipo) );
		if ( $items->num_rows() <= 0 ) {
			$item->iditemc = $this->itc->add($item, $idcontrato); # Agregamos el item de contrato y obtenemos el ID
			$this->itf->add($item); # Agregamos el item de factutracion interna
			return 'Item OK, por agregar.';
		}
		return 'Item y tipo ya existentes en el contrato.';
	}
	private function directorioBase()
	{
		$this->crear_directorio('./uploads/items');
		$this->crear_directorio('./uploads/items/cargue');
		$path = '/uploads/items/cargue/'.date("Ymd");
		$this->crear_directorio('.'.$path);
		return $path;
	}

	private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

	# Exportar items por contrato
	public function export_by($idcontrato)
	{
		if( $this->sesion_iniciada() ){
			$this->load->helper('xlsxwriter');
	    $this->load->helper('download');
	    $this->load->model('itemc_db', 'item');
	    $production = ( isset($fact) && $fact==1 )?TRUE:NULL;
	    $rows = $this->item->getByContrato($idcontrato);
			$file = 'ListItems'.date('Ymdhis');
	    xlsx($rows->result_array(), $rows->list_fields(), './downloads/items/'.$file.'.xlsx', 'Items', array('cantidad_final'));
	    force_download('./downloads/items/'.$file.'.xlsx', NULL);
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
