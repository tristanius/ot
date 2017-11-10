<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricoFacturacion_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  public function init_transact()
  {
    $this->load->database('ot');
    $this->db->trans_begin();
  }

  public function end_transact($bool=TRUE)
  {
    $this->load->database('ot');
    $status = $this->db->trans_status();
    if ($status === FALSE || $bool === FALSE ){
        $this->db->trans_rollback();
    }
    else{
        $this->db->trans_commit();
    }
    return $status;
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

  public function setRowHistorico($data)
  {
    $this->load->database('ot');
    $this->db->insert('historico_facturacion', $data);
  }

}
