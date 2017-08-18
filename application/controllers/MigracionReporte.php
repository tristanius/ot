<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MigracionReporte extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }
  #==============================================================================#
  # MIGRACION DE REPORTES ENTEROS #
  #==============================================================================#
  public function cargueReportes($value='')
  {
    # code...
  }
  #==============================================================================#
  # MIGRACION DE RECURSOS INTERNOS A REPORTES DE OTRA OT #
  #==============================================================================#
  public function formRecursosReporte($value='')
  {
    $this->load->view('asociaciones\tranferenciaRecursos\form_tranferir_recursos');
  }
  public function cargueMigracionRecursos($value='')
  {
    $this->load->view('asociaciones\tranferenciaRecursos\cargueMigracionRecursos');
  }

  public function loadRecursosreporte($value='')
  {
    $this->crear_directorio("./uploads/migracionrecursos/");
    $config['upload_path'] = './uploads/migracionrecursos/';
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('userfile')){
      $error = array('error' => $this->upload->display_errors());
      $this->load->view('upload_form', $error);
    }else{
      $data = array('upload_data' => $this->upload->data());
      $this->load->view('upload_success', $data);
    }
  }

  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

  public function copyRD($value='')
  {
    # code...
  }

}
