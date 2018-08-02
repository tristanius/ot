<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vigencia extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }

  public function get_tarifas($idvigencia=NULL)
  {
    if(isset($idvigencia)){
      $this->load->model('vigencia_db', 'vg');
      $ret = new stdClass();
      $ret->actividad = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>1) )->result();
      $ret->personal = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>2) )->result();
      $ret->equipo = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>3) )->result();
      $ret->material = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>'material') )->result();
      $ret->otros = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>'otros') )->result();
      echo json_encode($ret);
    }
  }

}
