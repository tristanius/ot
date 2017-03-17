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

  public function form_tiempoLaboradoGeneral()
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $this->load->view('miscelanios/reportepersonal/form_tiempoLaborado', array("bases"=>$bases));
  }

  public function tiempoLaboradoGeneral()
  {
    $mes = $this->input->post("consultatiempoMes");
    $year = $this->input->post("consultatiempoYear");
    $base = $this->input->post("consultatiempoBase");
    $this->load->model('Reportepersonal_db', 'rper');
    $rows = $this->rper->tiempoLaboradoGeneral($mes, $year, $base);
    $this->load->view('miscelanios/excelGenerico', array("rows"=>$rows, "nombre"=>$base."Informetiempos".$year.$mes));
  }
}
