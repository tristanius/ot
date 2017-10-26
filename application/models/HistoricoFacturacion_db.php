<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricoFacturacion_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  // ------------------------------------------------------------------------------
  // SABANA DE FACTURACION HISTORICA Y ACTUAL
  // ------------------------------------------------------------------------------
  public function fields($value='')
  {
    $this->load->database('ot');
    return $this->db->list_fields('historico_facturacion');
  }
  public function fieldsMetaData()
  {
    $this->load->database('ot');
    return $this->db->field_data('historico_facturacion');
  }
  public function setRowSabana($data)
  {
    $this->load->database('ot');
    $this->db->insert('historico_facturacion', $data);
    return $this->db->insert_id();
  }

}
