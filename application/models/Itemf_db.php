<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemf_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($item)
  {
    $data = array(
      'codigo' => $item->codigo,
      'descripcion' => $item->descripcion_interna,
      'unidad' => $item->unidad,
      'tipo' => $item->tipo,
      'itemc_iditemc' => $item->iditemc,
      'itemc_item' => $item->item,
      'incidencia' => $item->incidencia,
      'idusuario' => $this->session->userdata('idusuario')
    );
    $this->db->insert('itemf', $data);
    return $this->db->insert_id();
  }


  public function mod($item)
  {
    $data = array(
      'codigo' => $item->codigo,
      'descripcion' => $item->descripcion_interna,
      'unidad' => $item->unidad,
      'tipo' => $item->tipo,
      'itemc_iditemc' => $item->iditemc,
      'itemc_item' => $item->item,
      'incidencia' => $item->incidencia,
      'idusuario' => $this->session->userdata('idusuario')
    );
    return $this->db->update('itemf', $data, 'iditemf = '.$item->iditemf);
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
