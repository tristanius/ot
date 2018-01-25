<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condensado_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->database('ot');
  }

  public function getFrentes($idReporte)
  {
    $this->db->select('ft.idfrente_ot, ft.nombre, ft.ubicacion');
    $this->db->from('frente_ot AS ft');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idfrente_ot = ft.idfrente_ot');
    $this->db->where('rrd.idreporte_diario', $idReporte);
    $this->db->group_by('rrd.idfrente_ot');
    $this->db->order_by('ft.idfrente_ot', 'asc');
    return $this->db->get();
  }

  public function generar($idreporte, $tipo=NULL, $frente=NULL)
  {
    $this->db->select('OT.nombre_ot, OT.idOT, rd.fecha_reporte, rd.idreporte_diario, rrd.cantidad, itf.codigo, itf.descripcion, itf.itemc_item, "" AS actividad_asociada, CONCAT(ft.nombre, " - ",ft.ubicacion) AS nombre_frente  ');
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario');
    $this->db->join('frente_ot AS ft', 'ft.idfrente_ot = rrd.idfrente_ot');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
    $this->db->where('rd.idreporte_diario', $idreporte);
    if (isset($frente)) {
      $this->db->where('ft.idfrente_ot', $frente);
    }
    if(isset($tipo))
      $this->db->where('itf.tipo', $tipo);
    else
      $this->db->where('itf.tipo != 1');
    $this->db->group_by('itf.codigo');
    $this->db->group_by('ft.idfrente_ot');
    $this->db->order_by('ft.idfrente_ot', 'asc');
    $this->db->order_by('itf.iditemf', 'asc');
    return $this->db->get();
  }

  public function get($idreporte)
  {
    $this->db->select('rd.condensado');
    $this->db->from('reporte_diario AS rd');
    $this->db->where('rd.idreporte_diario', $idreporte);
    return $this->db->get();
  }
}
