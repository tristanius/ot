<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Costo_mes_ot extends CI_Model{
  private $meses = array();

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->meses = array(
      'OT_idOT'     =>NULL,
      'year'        =>date('Y'),
      'enero'       =>0,
      'febrero'     =>0,
      'marzo'       =>0,
      'abril'       =>0,
      'mayo'        =>0,
      'junio'       =>0,
      'julio'       =>0,
      'agosto'      =>0,
      'septiembre'  =>0,
      'octubre'     =>0,
      'noviembre'   =>0,
      'diciembre'   =>0,
      'validacion'  =>'unsigned'
    );
  }
   /* ------------- utilidades -------------- */
  private function initMeses($idOT, $year) // crea un array de meses de 1 año de un OT
  {
    $this->meses['OT_idOT'] = $idOT;
    $this->meses['year'] = isset($year)?$year:date('Y');
    return $this->meses;
  }

  private function getMesesDB($idOT, $year) // Obtiene meses de una OT por un año dado-
  {
    $this->load->database('ot');
    $where = array('OT_idOT'=>$idOT);
    if (isset($year)) {
      $where['year'] = $year;
    }
    return $this->db->get_where('costo_mes_ot', $where);
  }

  /* ------------- funciones --------------- */
  public function getMeses($idOT, $year) // Obtiene los meses de un año si existen, si no los inicializa de una OT.
  {
    $this->load->database('ot');
    $meses = $this->getMesesDB($idOT, $year);
    if ($meses->num_rows() > 0) {
      return $meses->row_array();
    }
    return $this->initMeses($idOT, $year);
  }

  public function saveMeses($meses, $idOT, $year) // guarda los meses de un año especifico o los actualiza si ya existen de una OT
  {
    $this->load->database('ot');
    $rows = $this->getMesesDB($idOT, $year);
    if ($rows->num_rows() > 0) {
      $this->db->update('costo_mes_ot', $meses, 'OT_idOT = '.$idOT.' AND year = '.$year );
    }else{
      $this->db->insert('costo_mes_ot', $meses);
    }
  }

  public function saveAllMeses($allMeses) // Guarda todo los conjuntos de meses de los diferente años por una OT
  {
    foreach ($allMeses as $key => $row){
      $this->saveMeses($row, $row->OT_idOT, $row->year);
    }
  }

  public function getAllMeses($idOT, $year=NULL) // obtiene todos los conjuntos de meses guardado de una OT por diferenrtes años
  {
    $this->load->database('ot');
    $months = $this->getMesesDB($idOT, NULL);
    if ($months->num_rows() > 0){
      return $months->result_array();
    }
    $year = isset($year)? $year: date('Y');
    return array( $this->initMeses($idOT, $year ) ); // inicia uno aleatoreo
  }

  /* Mes a mes */
  public function setMes($mes, $value, $meses)
  {
    return $meses[$mes] = $value;
  }

  public function getMes($mes, $meses)
  {
    return $meses[$mes];
  }
}
