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
    return $this->db->delete('adjunto','idadjunto'=>$id);
  }
}
