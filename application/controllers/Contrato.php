<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contrato extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }
  public function gestion($value='')
  {
    $this->load->view('contrato/gestion');
  }

  public function form($id=NULL)
  {
    $this->load->view('contrato/form', array('id'=>$id));
  }

  public function save()
  {
    $contrato = json_decode( file_get_contents('php://input'));
    $ret = new stdClass();
    if (isset($contrato->idcontrato)) {
      $id = $contrato->idcontrato;
      $this->mod($contrato, $id);
      $ret->status = TRUE;
      $ret->contrato = $contrato;
    } else {
      if(!$this->existe_contrato($contrato->no_contrato)){
        $contrato->idcontrato = $this->add($contrato);
        $ret->status = TRUE;
        $ret->contrato = $contrato;
      }else {
        $ret->status = FALSE;
        $ret->msj = 'Ya existe el No. de contrato.';
      }
    }
    echo json_encode($ret);
  }

  public function existe_contrato($no_contrato)
  {
    $this->load->model('contrato_db', 'cont');
    $rows = $this->cont->getBy('no_contrato', $no_contrato);
    if($rows->num_rows() > 0){
      return TRUE;
    }
    return FALSE;
  }

  public function add($contrato)
  {
    $this->load->model('contrato_db', 'c');
    $this->c->init_transact();
    $id = $this->c->add($contrato);
    $this->c->end_transact();
    return $id;
  }

  public function mod($contrato, $id)
  {
    $this->load->model('contrato_db', 'c');
    $this->c->init_transact();
    $bandera = $this->c->update($contrato, $id);
    $this->c->end_transact();
    return $bandera;
  }

  public function get_contratos()
  {
    $this->load->model('contrato_db', 'c');
    $contratos = $this->c->getContratos();
    $ret = new stdClass();
    $ret->contratos = $contratos->result();
    $ret->status = TRUE;
    echo json_encode($ret);
  }

  public function get($id)
  {
    $this->load->model('contrato_db', 'c');
    $contratos = $this->c->getBy('idcontrato', $id);
    $ret = new stdClass();
    if($contratos->num_rows() > 0){
      $ret->contrato = $contratos->row();
      $ret->status = TRUE;
    }else{
      $ret->status = FALSE;
    }
    echo json_encode($ret);
  }

  public function remove($id)
  {
    // code...
  }

  # ----------------------------------------------
  # Vigencias

}
