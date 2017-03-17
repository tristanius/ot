<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporteequipomes extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index(){ }
  #===========================================================================================================
  # add
  public function reporteMes($year, $mes, $laBase=NULL)
  {
    $fechai = date('Y-m-d', strtotime($year.'-'.$mes.'-01'));
		$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
		$fechaf = date('Y-m-d',
			strtotime (
				'+'.($dias-1).' day',
				strtotime($fechai)
			)
		);
    $this->load->model('Reporteequipomes_db', 'requmes');
    $rows = $this->requmes->getBy($fechai, $fechaf);
    if($rows->num_rows() == 0){
      echo 'invalid';
    }else{
      $rowsHorasOperativas = $this->requmes->getHorasOper($fechai, $fechaf,$laBase);
      $this->load->view('miscelanios/reporteequipo/resumenequipo',
        array('lashoras'=>$rowsHorasOperativas,'nodownload'=>false,'inicio'=>$fechai,'final'=>$fechaf,'labase'=>$laBase)
      );
    }
  }

  public function reporteMesPyco($year, $mes, $laBase=NULL)
  {
    $fechai = date('Y-m-d', strtotime($year.'-'.$mes.'-01'));
		$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
		$fechaf = date('Y-m-d',
			strtotime (
				'+'.($dias-1).' day',
				strtotime($fechai)
			)
		);
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('Reporteequipomes_db', 'requmes');
    $rows = $this->requmes->getBy($fechai, $fechaf);
    if($rows->num_rows() == 0){
      echo 'invalid';
    }else{
      $rowsEquipos = $this->requmes->getPyco($fechai, $fechaf,$laBase);
      $this->load->view('miscelanios/reporteequipo/reportepyco',
        array('lashoras'=>$rowsEquipos,'nodownload'=>false,'inicio'=>$fechai,'final'=>$fechaf,'labase'=>$laBase)
      );
    }
  }}
