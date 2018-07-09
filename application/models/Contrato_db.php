<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contrato_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($contrato)
  {
    $this->load->database('ot');
    $data = (array) $contrato;
    $data['idcontrato'] = NULL;
    $this->db->insert('contrato', $data);
    return $this->db->insert_id();
  }

  public function update($contrato, $id)
  {
    $this->load->database('ot');
    $data = (array) $contrato;
    return $this->db->update('contrato', $data, 'idcontrato = '.$id);
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

  public function getBy($field, $val)
  {
    $this->load->database('ot');
    return $this->db->from('contrato')->where($field, $val)->get();
  }

  # =================================================================================
  public function init_transact()
  {
    $this->load->database('ot');
    $this->db->trans_begin();
  }
  public function transac_status()
  {
    $this->load->database('ot');
    return $this->db->trans_status();
  }
  public function end_transact()
  {
    $this->load->database('ot');
    $status = $this->db->trans_status();
    if ($status === FALSE){
        $this->db->trans_rollback();
    }
    else{
        $this->db->trans_commit();
    }
    return $status;
  }
  public function rollback($value='')
  {
    $this->load->database('ot');
    $this->db->trans_rollback();
  }

}
