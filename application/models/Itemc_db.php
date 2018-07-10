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
    $this->db->select('
      c.idcontrato,
      c.no_contrato,
      c.contratista,
      itc.iditemc,
      itc.item,
      itc.descripcion,
      itc.unidad,
      tipc.grupo_mayor AS tipo,
      itf.iditemf,
      itf.codigo,
      itf.descripcion AS descripcion_interna,
      itc.und_minima,
      itc.hrdisp,
      itc.basedisp,
      itf.incidencia AS incidencia_salarial,
      (SELECT COUNT(itemf.iditemf) FROM itemf WHERE itemf.itemc_iditemc = itc.iditemc) AS subitems,
    ');
    return $this->db->from('contrato AS c')
                    ->join('itemc AS itc','itc.idcontrato = c.idcontrato')
                    ->join('tipo_itemc AS tipc', 'tipc.idtipo_itemc = itc.idtipo_itemc')
                    ->join('itemf AS itf','itf.itemc_iditemc = itc.iditemc')
                    ->where('c.idcontrato',$idcontrato)
                    ->order_by('tipc.grupo_mayor','ASC')
                    ->order_by('itc.item','ASC')
                    ->order_by('itf.iditemf','ASC')
                    ->order_by('itf.codigo','ASC')
                    ->get();
  }

}
