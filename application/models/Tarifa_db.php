<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifa_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($tarifa)
  {
    $this->load->database('ot');
  }

  public function mod($tarifa, $id = NULL)
  {
    $this->load->database('ot');
  }
  # obtener tarifa by
  public function getBy( $where=NULL )
  {
    $this->load->database('ot');
    if( isset($where) ){
      $this->db->where( $where );
    }
    $this->db->select('itc.iditemc, itc.item, itc.descripcion, tip.grupo_mayor AS tipo, itf.iditemf, itf.codigo, itf.descripcion AS descripcion_interna');
    $this->db->select('IFNULL(tf.tarifa, "-") AS tarifa, tf.idtarifa, vg.idvigencia_tarifas, vg.descripcion_vigencia');
    return $this->db->from('itemc AS itc')
        ->join('itemf AS itf', 'itf.itemc_iditemc = itc.iditemc')
        ->join('tarifa AS tf','tf.itemf_iditemf = itf.iditemf', 'LEFT')
        ->join('vigencia_tarifas AS vg', 'vg.idvigencia_tarifas = tf.idvigencia_tarifas','LEFT')
        ->join('tipo_itemc AS tip', 'itc.idtipo_itemc = tip.idtipo_itemc')
        ->get();
  }
  #=============================================================================
  public function getVigencias( $idcontrato )
  {
    $this->load->database('ot');
  }

  public function getByVigencia( $idvigencia )
  {
    $this->load->database('ot');
  }

  public function updateSalario($id, $salario, $estado_salario)
  {
    $this->load->database('ot');
    $data = array('salario' =>$salario, 'estado_salario'=>$estado_salario );
    $this->db->update('tarifa', $data, 'itemf_iditemf = '.$id);
  }

}
