<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validator_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getOrdenesActivas()
  {
    $this->load->database('ot');
    return $this->db->query(
      '
      SELECT OT.idOT, OT.nombre_ot
      FROM OT
      WHERE OT.estado_doc = "ACTIVA"
      '
    );
  }

}
