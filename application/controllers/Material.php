<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }

  #===============================================================================================
  #==================== PROCESO DE CARGA DE Material X OT DESDE UN ARCHIVO =======================
  #===============================================================================================
  public function formUploadByOT()
  {
    $this->load->view('material/uploadByOT');
  }

  public function uploadFileOT($value='')
  {
    $carpeta = "/equipos/".date("dmY")."/";
    $dir = "./uploads".$carpeta;
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->cargarMaterialOT( $this->getDataEquipo( $carpeta.$dataup['file_name'] ) ); //
    }else{
      echo  $this->upload->display_errors();
    }
  }

}
