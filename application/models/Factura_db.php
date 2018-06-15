<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  ##############################################################################
  # Agregar factura
  public function add($factura)
  {
    $data = array(
      'no_factura'=>$factura->no_factura,
      'fecha_inicio'=>$factura->fecha_inicio,
      'fecha_fin'=>$factura->fecha_fin,
      'descripcion'=>isset($factura->descripcion)?$factura->descripcion:NULL,
      'total'=>$factura->total,
      'idcontrato'=>$factura->idcontrato,
      'tipo_acta'=>$factura->tipo_acta,
      'estado_factura'=>$factura->estado_factura,
      'validado'=> $factura->validado
    );
    $this->load->database('ot');
    $this->db->insert('factura', $data);
    return $this->db->insert_id();
  }
  # Consulta una factura con su contrato
  public function get($idfactura)
  {
    $this->load->database('ot');
    return $this->db->select('f.*, c.idcontrato, c.no_contrato')
      ->from('factura AS f')
      ->join('contrato AS c','c.idcontrato = f.idcontrato')
      ->where('f.idfactura', $idfactura)
      ->get();
  }
  # Modificar/actualizar factura
  public function mod($factura)
  {
    # No se modifican los campos de vigencias y contrato
    $data = array(
      'no_factura'=>$factura->no_factura,
      'fecha_inicio'=>$factura->fecha_inicio,
      'fecha_fin'=>$factura->fecha_fin,
      'descripcion'=>isset($factura->descripcion)?$factura->descripcion:NULL,
      'tipo_acta'=>$factura->tipo_acta,
      'total'=>$factura->total,
      'estado_factura'=>$factura->estado_factura,
      'validado'=> $factura->validado
    );
    $this->load->database('ot');
    return $this->db->update('factura', $data, 'idfactura = '.$factura->idfactura);
  }
  #============================================================================
  # Recurso
  public function addRecurso($rec, $idfac)
  {
    $data = array(
      'cantidad'=>$rec->cantidad,
      'tarifa'=>$rec->tarifa,
      'a'=>$a,
      'i'=>$i,
      'u'=>$u,
      'total'=>$rec->total,
      'estado'=>($rec->estado?$rec->estado:NULL),
      'idvigencia_tarifas'=>$rec->idvigencia_tarifas,
      'idfactura'=>$idfac,
      'idrecurso_reporte_diario' =>$rec->idrecurso_reporte_diario
    );
    $this->load->database('ot');
    $this->db->insert('factura_recurso_reporte', $data);
    return $this->db->insert_id();
  }

  public function modRecurso($rec)
  {
    # No se habilita modificar el id de recurso reportado y de factura
    $data = array(
      'cantidad'=>$rec->cantidad,
      'tarifa'=>$rec->tarifa,
      'a'=>$a,
      'i'=>$i,
      'u'=>$u,
      'total'=>$rec->total,
      'estado'=>($rec->estado?$rec->estado:NULL),
      'idvigencia_tarifas'=>$rec->idvigencia_tarifas
    );
    $this->load->database('ot');
    return $this->db->update('factura_recurso_reporte', $data, 'idfactura_recurso_reporte = '.$rec->idfactura_recurso_reporte);
  }

  public function delRecurso($idfrd)
  {
    $this->load->database('ot');
    return $this->db->delete('factura_recurso_reporte', array('idfactura_recurso_reporte'=>$idfrd));
  }

  public function delRecursoBy($idfact)
  {
    $this->load->database('ot');
    return $this->db->delete('factura_recurso_reporte', array('idfactura'=>$idfact));
  }

  #=============================================================================
  # Información de contrato
  public function getContrato($idcontrato)
  {
    $this->load->database('ot');
    return $this->db->get_where('contrato', array('idcontrato'=>$idcontrato) );
  }

  public function getVigenciasContrato($idcontrato)
  {
    $this->load->database('ot');
    return $this->db->select('
    c.idcontrato,
    c.no_contrato,
    c.contratista,
    c.estado,
    vg.idvigencia_tarifas,
    vg.descripcion_vigencia,
    vg.estado,
    vg.fecha_inicio_vigencia,
    vg.fecha_fin_vigencia,
    vg.a,
    vg.i,
    vg.u
    ')
    ->from('contrato AS c')
    ->join('vigencia_tarifas AS vg','vg.idcontrato = c.idcontrato')
    ->where('c.idcontrato',$idcontrato)
    ->order_by('vg.idvigencia_tarifas','DESC')->get();
  }

  public function getFacturasContrato($idcontrato)
  {
    $this->load->database('ot');
    return $this->db
    ->select('
      f.*
      ')
    ->from('factura AS f')
    ->join('contrato AS c','c.idcontrato = f.idcontrato')
    ->where('c.idcontrato',$idcontrato)
    ->get();
  }

  public function getCentrosOperacionContratos($idcontrato)
  {
    $this->load->database("ot");
    return $this->db->select("
    c.idcontrato,
    c.contratista,
    b.idbase,
    b.idsector,
    cb.sector,
    b.nombre_base
    ")->from("contrato AS c")
    ->join("contrato_base AS cb",'cb.idcontrato = c.idcontrato')
    ->join("base AS b","b.idbase = cb.idbase")
    ->where("c.idcontrato",$idcontrato)
    ->get();
  }

  #=============================================================================
  # Consultas para crear factura y modificar valores desde cero.
  # En uso
  public function getOrdenes($obj)
  {
    $this->load->database('ot');
    $this->db->select('
    OT.idOT,
    OT.nombre_ot AS No_OT,
    b.idbase AS CO,
    b.nombre_base AS base
    ');
    $this->db->from('OT');
    $this->db->join('base AS b', 'b.idbase = OT.base_idbase');
    $this->db->join('reporte_diario AS rd', 'rd.OT_idOT = OT.idOT');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
    $this->db->join('factura_recurso_reporte AS frrd','frrd.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario','LEFT');

    $this->db->where("rd.fecha_reporte BETWEEN '".$obj->fecha_ini_factura."' AND '".$obj->fecha_fin_factura."' ");
    $this->db->where_in('b.idbase', $obj->bases);
    $this->db->where('frrd.idfactura_recurso_reporte is NULL');
    $this->db->where('rrd.facturable', TRUE);

    $this->db->group_by('OT.idOT');
    $this->db->order_by('OT.nombre_ot', 'DESC');
    return $this->db->get()->result();
  }
  // En uso
  public function getRecursos($idcontrato, $fecha_inicio, $fecha_fin, $centros_operacion=NULL, $ordenes=NULL)
  {
    $this->load->database('ot');
    $this->db->select('
    c.idcontrato,
    OT.idOT,
    OT.nombre_ot,
    OT.base_idbase,
    rd.idreporte_diario,
    rd.fecha_reporte,
    rrd.idrecurso_reporte_diario,
    rrd.cantidad,
    IF(rrd.facturable,"SI","NO") AS facturable,
    itf.codigo,
    itf.unidad,
    itf.itemc_item,
    itf.descripcion,
    tar.tarifa,
    p.identificacion,
    p.nombre_completo,
    IFNULL(rot.tipo, "activiad") AS tipo,
    IFNULL(e.codigo_siesa, rot.codigo_temporal) AS codigo_siesa,
    IFNULL(e.descripcion, rot.descripcion_temporal) AS descripcion_equipo,
    rrd.horas_operacion,
    rrd.horas_disponible,
    getDispon(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, itc.und_minima, itc.unidad, itc.hrdisp, itc.basedisp)*rrd.cantidad AS disponibilidad,
    vg.idvigencia_tarifas,
    If( getDispon(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, itc.und_minima, itc.unidad, itc.hrdisp, itc.basedisp)*rrd.cantidad <> rrd.cantidad, "SI", "NO" ) AS cambio_cant
    ');
    $this->db->from('contrato AS c');
    $this->db->join('OT', 'OT.idcontrato = c.idcontrato')
          ->join('base AS b','b.idbase = OT.base_idbase')
          ->join('reporte_diario AS rd', 'rd.OT_idOT = OT.idOT')
          ->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario')
          ->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot')
          ->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso','LEFT')
          ->join('persona AS p', 'r.persona_identificacion = p.identificacion','LEFT')
          ->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT')
          ->join('factura_recurso_reporte AS frrd','frrd.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario','LEFT')
          ->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf')
          ->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc')
          ->join('tarifa AS tar', 'tar.itemf_iditemf = itf.iditemf')
          ->join('vigencia_tarifas AS vg', 'vg.idvigencia_tarifas = tar.idvigencia_tarifas')
          ->where('c.idcontrato', $idcontrato)
          ->where('frrd.idfactura_recurso_reporte IS NULL')
          ->where('vg.idvigencia_tarifas = (
              SELECT vigencia.idvigencia_tarifas
              FROM vigencia_tarifas AS vigencia
              WHERE vigencia.fecha_inicio_vigencia <= rd.fecha_reporte
              AND vigencia.fecha_fin_vigencia >= rd.fecha_reporte
              ORDER BY vigencia.idvigencia_tarifas DESC LIMIT 1
              )')
          ->where('rd.fecha_reporte BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'" ');
    if( isset( $centros_operacion ) ){
      $this->db->where_not_in('b.idbase', (array) $centros_operacion);
    }
    if( isset( $ordenes ) ){
      $this->db->where_not_in('OT.idOT', (array) $ordenes);
    }
    return $this->db->get();
  }
  # En uso
  public function getOrdenesByCO($idcontrato, $fecha_inicio, $fecha_fin, $centros_operacion=NULL)
  {
    $this->load->database('ot');
    $this->db->select('
    OT.idOT,
    OT.nombre_ot,
    OT.base_idbase
    ');
    $this->db->from('contrato AS c');
    $this->db->join('OT', 'OT.idcontrato = c.idcontrato')
          ->join('reporte_diario AS rd', 'rd.OT_idOT = OT.idOT')
          ->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario')
          ->where('c.idcontrato', $idcontrato);
    if( isset( $centros_operacion ) ){
      $this->db->where_not_in('OT.base_idbase', (array)  $centros_operacion);
    }
    $this->db->group_by('OT.idOT');
    return $this->db->get();
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
}
