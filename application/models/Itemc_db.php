<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemc_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getByContrato($idcontrato)
  {
    $this->load->database('ot');
    return $this->db->from('contrato AS c')
                    ->join('itemc AS itc','itc.idcontrato = c.idcontrato')
                    ->where('c.idcontrato',$idcontrato)
                    ->get();
  }

}
