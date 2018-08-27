<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemc_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  #
  public function add($item, $idcontrato)
  {
    $data = array(
      'item' => $item->item,
      'descripcion' => $item->descripcion,
      'tipo' => $item->tipo,
      'unidad' => $item->unidad,
      'idtipo_itemc' => $item->idtipo_itemc,
      'und_minima' => $item->und_minima,
      'basedisp' => $item->basedisp,
      'hrdisp' => $item->hrdisp,
      'idusuario' => $this->session->userdata('idusuario'),
      'idcontrato' => $idcontrato
    );
    $this->db->insert('itemc', $data);
    return $this->db->insert_id();
  }

  public function mod($item)
  {
    $data = array(
      'item' => $item->item,
      'descripcion' => $item->descripcion,
      'tipo' => $item->tipo,
      'unidad' => $item->unidad,
      'idtipo_itemc' => $item->idtipo_itemc,
      'und_minima' => $item->und_minima,
      'basedisp' => $item->basedisp,
      'hrdisp' => $item->hrdisp,
      'idusuario' => $this->session->userdata('idusuario')
    );
    return $this->db->update('itemc', $data, 'iditemc = '.$item->iditemc);
  }
  # Consulta de items por contrato
  public function getByContrato($idcontrato)
  {
    $this->load->database('ot');
    $this->db->select('
      c.idcontrato,
      c.no_contrato,
      c.contratista,
      itc.iditemc,
      itc.item,
      itc.descripcion,
      itc.unidad,
      itc.tipo,
      tipc.grupo_mayor AS tipo_grupo,
      itf.iditemf,
      itf.codigo,
      itf.descripcion AS descripcion_interna,
      itc.und_minima,
      itc.hrdisp,
      itc.basedisp,
      itf.incidencia AS incidencia_salarial,
      tipc.idtipo_itemc,
      (SELECT COUNT(itemf.iditemf) FROM itemf WHERE itemf.itemc_iditemc = itc.iditemc) AS subitems,
    ');
    return $this->db->from('contrato AS c')
              ->join('itemc AS itc','itc.idcontrato = c.idcontrato')
              ->join('tipo_itemc AS tipc', 'tipc.idtipo_itemc = itc.idtipo_itemc')
              ->join('itemf AS itf','itf.itemc_iditemc = itc.iditemc')
              ->where('c.idcontrato',$idcontrato)
              ->order_by('tipc.grupo_mayor','ASC')
              ->order_by('itf.codigo','ASC')
              ->order_by('itf.iditemf','ASC')
              ->order_by('itc.item','ASC')
              ->get();
  }

  public function getTiposItemc()
  {
    $this->load->database('ot');
    return $this->db->get('tipo_itemc');
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

  public function commit()
  {
    $this->load->database('ot');
    $this->db->trans_commit();
  }

}
