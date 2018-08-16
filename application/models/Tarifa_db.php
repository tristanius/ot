<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifa_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($tarifa)
  {
    $this->load->database('ot');
  }

  public function add($tarifa, $id = NULL)
  {
    $this->load->database('ot');
  }

  #=============================================================================
  public function getVigencias( $idcontrato )
  {
    $this->load->database('ot');
  }

  public function getByVigencia( $idvigencia )
  {
    $this->load->database('ot');
  }

  public function updateSalario($id, $salario, $estado_salario)
  {
    $this->load->database('ot');
    $data = array('salario' =>$salario, 'estado_salario'=>$estado_salario );
    $this->db->update('tarifa', $data, 'itemf_iditemf = '.$id);
  }

}
