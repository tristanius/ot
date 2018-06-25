<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjunto_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($data)
  {
    $this->load->database('ot');
    $this->db->insert('adjunto', $data);
    return $this->db->insert_id();
  }

  public function get($id)
  {
    $this->load->database('ot');
    return $this->db->from('adjunto')->where('idadjunto',$id)->get();
  }

  public function remove($id)
  {
    $this->load->database('ot');
    return $this->db->delete('adjunto', array('idadjunto'=>$id) );
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
