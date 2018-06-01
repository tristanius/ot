<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contrato_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getContratos($id=NULL, $estado=NULL)
  {
    $this->load->database('ot');
    if (isset($id)) {
      $this->db->where('idcontrato', $id);
    }
    if (isset($estado)) {
      $this->db->where('estado', $estado);
    }
    return $this->db->from('contrato')->get();
  }

}
