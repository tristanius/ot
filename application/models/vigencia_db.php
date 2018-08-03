<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vigencia_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getBy($wh)
  {
    $this->load->database('ot');
    if (isset($wh)) {
      $this->db->where($wh);
    }
    return $this->db->select(
      'c.idcontrato,
      c.no_contrato,
      vg.descripcion_vigencia,
      vg.idvigencia_tarifas,
      vg.fecha_inicio_vigencia,
      vg.fecha_fin_vigencia,
      IF(vg.a = 0, vg.a, c.a_contrato) AS a,
      IF(vg.i = 0, vg.i, c.i_contrato) AS i,
      IF(vg.u = 0, vg.u, c.u_contrato) AS u,
      '
      )
      ->from('vigencia_tarifas AS vg')
      ->join('contrato AS c', 'c.idcontrato = vg.idcontrato')
      ->get();
  }

  public function getItemsBy($where=NULL)
  {
    $this->load->database('ot');
    if(isset($where)){
      $this->db->where($where);
    }
    $fields = 'itc.iditemc, itc.item, itf.iditemf, itf.codigo, itf.descripcion, itf.tipo, tar.idtarifa, tar.tarifa, ';
    $fields .= 'tip.BO, tip.CL, tip.item AS cod_tipo, tip.grupo_mayor, itf.unidad, tar.idvigencia_tarifas, tip.descripcion as clasificacion_item';
    return $this->db->select($fields)
              ->from('itemc AS itc')
              ->join('itemf AS itf','itf.itemc_iditemc = itc.iditemc')
              ->join('tarifa AS tar','tar.itemf_iditemf = itf.iditemf')
              ->join('vigencia_tarifas AS vg','vg.idvigencia_tarifas = tar.idvigencia_tarifas')
              ->join('tipo_itemc AS tip','tip.idtipo_itemc = itc.idtipo_itemc')
              ->get();
  }

}
