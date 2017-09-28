<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set("America/Bogota");
  }

  function index()
  {

  }

  public function cargue_historico($value='')
  {
    $this->load->view('miscelanios/cargue_historico/form_upload');
  }

  public function upload_cague_historico($value='')
  {
    $this->crear_directorio('./uploads/cargue_historico');
    $config['upload_path'] = './uploads/cargue_historico/';
		$config['allowed_types'] = 'xlsx';
		$config['file_name'] = 'historico_fact'.$this->input->post('nombre_archivo');

    $this->load->library("upload",$config);
    $ret = new StdClass();
		if($this->upload->do_upload("file")){
			$info = $this->upload->data();
      $ret->return = '/uploads/cargue_historico/'.$info['file_name'];
      $ret->msj = 'Cargue exitoso';
      $ret->success = TRUE;
		}else{
      $ret->msj = 'Error al cargar: '.$this->upload->display_errors();
      $ret->success = FALSE;
		}

    echo json_encode($ret);
  }

  public function read_data_from()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->helper('xlsx');
    print_r( readXlsx(FCPATH.$post->path,NULL) );
  }

  public function read_data_from2()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->helper('xlsx');
    print_r( readXlsx(FCPATH."uploads/cargue_historico/historico_fact10.xlsx",NULL) );
  }

  public function loadRow($row)
  {

  }

  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }
  }

}
