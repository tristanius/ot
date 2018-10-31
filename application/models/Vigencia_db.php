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
    $fields =   'c.idcontrato,
      c.no_contrato,
      vg.idvigencia_tarifas,
      vg.descripcion_vigencia,
      vg.idvigencia_tarifas,
      vg.fecha_inicio_vigencia,
      vg.fecha_fin_vigencia,
      vg.a AS a,
      vg.i AS i,
      vg.u AS u
      ';
    return $this->db->select($fields)
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
    $fields .= 'tip.BO, tip.CL, tip.item AS cod_tipo, tip.grupo_mayor, itf.unidad, tar.idvigencia_tarifas, tip.descripcion as clasificacion_item, itc.grupo';
    return $this->db->select($fields)
              ->from('itemc AS itc')
              ->join('itemf AS itf','itf.itemc_iditemc = itc.iditemc')
              ->join('tarifa AS tar','tar.itemf_iditemf = itf.iditemf')
              ->join('vigencia_tarifas AS vg','vg.idvigencia_tarifas = tar.idvigencia_tarifas')
              ->join('tipo_itemc AS tip','tip.idtipo_itemc = itc.idtipo_itemc')
              ->get();
  }

}
