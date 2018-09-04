<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vigencia extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index(){ }

  # Cargar la visualización del gestion de vigencias
  public function gestion($idcontrato=NULL)
  {
    $this->load->view('contrato/vigencias/gestion', array('idcontrato'=>$idcontrato));
  }

  # Consulta de vigencias por contrato
  public function get_By($idcontrato)
  {
    $this->load->model(array('vigencia_db'=>"vg"));
    $ret = new stdClass();
    $ret->vigencias = $this->vg->getBy( array('c.idcontrato'=>$idcontrato) )->result();
    $ret->status = TRUE;
    echo json_encode($ret);
  }
  # guardado de vigencias
  public function save($value='')
  {
    $this->load->model(array('vigencia_db'=>"vg"));
    $ret = new stdClass();
  }
  # Agregar una vigencia
  private function add($value='')
  {
  }
  # Modificar una vigencia
  private function mod($value='')
  {
  }


  # -----------------------------------------------------------------------------------
  # Get tarifas By Vigencia
  public function get_tarifas($idvigencia=NULL)
  {
    if(isset($idvigencia)){
      $this->load->model('vigencia_db', 'vg');
      $ret = new stdClass();
      $ret->items = new stdClass();
      $ret->items->actividad = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>1) )->result();
      $ret->items->personal = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>2) )->result();
      $ret->items->equipo = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>3) )->result();
      $ret->items->material = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>'material') )->result();
      $ret->items->otros = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>'otros') )->result();
      $ret->items->subcontratos = $this->vg->getItemsBy( array('tar.idvigencia_tarifas'=>$idvigencia, 'itf.tipo'=>'subcontrato') )->result();
      $vig = $this->vg->getBy(array('vg.idvigencia_tarifas'=>$idvigencia));
      if($vig->num_rows() > 0){
        $aiu = $vig->row();
        $ret->a = $aiu->a;
        $ret->i = $aiu->i;
        $ret->u = $aiu->u;
      }
      echo json_encode($ret);
    }
  }

}
