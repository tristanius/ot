<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportepersonal extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index(){ }
  #===========================================================================================================
  # add
  public function tiempolaborado($idOT, $idReporte)
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('Reportepersonal_db', 'repoper');
    $rows = $this->repoper->getBy($idOT, $idReporte);
    if($rows->num_rows() > 0){
      echo 'invalid';
    }else{
      $rowsPersonas = $this->repoper->getRegistroDia($idOT,$idReporte);
      $rowOT = $this->repoper->getDatosOT($idOT,$idReporte);
      $this->load->view('miscelanios/reportepersonal/reportepersonal',
        array('elpersonal'=>$rowsPersonas,'laOT'=>$rowOT,'nodownload'=>false)
      );
    }
  }
}
