<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($post)
  {
    // Pendiente
    $data = array(
    );
    $this->load->database('ot');
    $this->db->insert('factura', $data);
    return $this->db->insert_id();
  }

  public function mod($post)
  {
    // Pendiente
    $data = array(
    );
    $this->load->database('ot');
    return $this->db->update('factura', $data, 'idfactura = '.$post->idfactura);
  }

  public function addRecurso($rec, $idfac)
  {
    // Pendiente
    $this->load->database('ot');
    return $this->db->insert_id();
  }



  public function modRecurso($rec)
  {
    $this->load->database('ot');
    $val = $rec->cantidad_total * $rec->tarifa;
    $a = ($val * 0.18);
    $i = ($val * 0.01);
    $u = ($val * 0.04);
    $data = array(
      'idrecurso_reporte_diario' =>$rec->idrecurso_reporte_diario,
      'cantidad_total'=>$rec->cantidad_total,
      'subtotal'=>$val,
      'a'=>$a,
      'i'=>$i,
      'u'=>$u,
      'total'=>($val+$a+$i+$u),
      'estado'=>($rec->estado?$rec->estado:NULL),
      'acta'=>($rec->acta?$rec->acta:NULL)
    );
    return $this->db->update('factura_recurso_reporte', $data, 'idfactura_recurso_reporte = '.$rec->idfactura_recurso_reporte);
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
    return $this->db->from('contrato AS c')
    ->join('vigencia_tarifas AS vfac','vfac.idcontrato = c.idcontrato')
    ->where('c.idcontrato',$idcontrato)
    ->order_by('vfac.idvigencia_tarifas','DESC')->get();
  }

  public function getFacturasContrato($idcontrato)
  {
    $this->load->database('ot');
    return $this->db
    ->select(
      '
      f.*,
      vtar.descripcion_vigencia
      ')
    ->from('factura AS f')
    ->join('vigencia_tarifas AS vtar','vtar.idvigencia_tarifas = f.idvigencia_tarifas')
    ->join('contrato AS c','c.idcontrato = vtar.idcontrato')
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
  public function getOrdenes($obj)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      OT.idOT,
      OT.nombre_ot AS No_OT,
      b.idbase AS CO,
      b.nombre_base AS base
      '
    );
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

  public function getRecursosByFact($idOT, $idfactura)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      frrd.idfactura_recurso_reporte,
      rrd.idrecurso_reporte_diario,
      bs.sector as sector,
      bs.nombre_base as base,
      OT.base_idbase as CO,
      itf.codigo,
      if(rot.tipo IS NULL , "actividad", rot.tipo) AS UN,
      rd.fecha_reporte,
      rd.festivo,
      OT.nombre_ot,
      itf.itemc_item as item,
      itc.descripcion,
      titc.descripcion as clasificacion,
      if(rrd.facturable,"SI","NO") AS facturable,
      rrd.cantidad AS cant_und,
      tr.tarifa,
      itf.unidad,
      frrd.cantidad_total,
      frrd.subtotal as valor_total,
      frrd.a,
      frrd.i,
      frrd.u,
      frrd.total,
      OT.municipio,
      e.codigo_siesa,
      e.descripcion AS dec_equipo,
      rrd.nombre_operador,
      rrd.horas_operacion,
      rrd.horas_disponible,
      p.identificacion,
      p.nombre_completo,
      if(!rd.festivo, rrd.horas_ordinarias, 0) AS HO,
      if(!rd.festivo, rrd.horas_extra_dia, 0) AS HED,
      if(!rd.festivo, rrd.horas_extra_noc, 0) AS HEN,
      if(!rd.festivo, rrd.horas_recargo, 0) AS recargo_noc,
      if(rd.festivo, rrd.horas_ordinarias, 0) AS HOF,
      if(rd.festivo, rrd.horas_extra_dia, 0) AS HEDF,
      if(rd.festivo, rrd.horas_extra_noc, 0) AS HENF,
      if(rd.festivo, rrd.horas_recargo, 0) AS recargo_noc_fest,
      rrd.racion,
      rrd.gasto_viaje_pr AS pernocto,
      rrd.gasto_viaje_lugar AS lugar_gasto_viaje,
      frrd.estado,
      itf.tipo,
      itc.hrdisp,
      itc.basedisp,
      frrd.acta
      '
    );

    $this->db->from('reporte_diario AS rd');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');

    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
    $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
    $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
    $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');

    $this->db->join('OT', 'OT.idOT = rd.OT_idOT','LEFT');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf','LEFT');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc','LEFT');
    $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc','LEFT');

    $this->db->join('base as bs', 'OT.base_idbase = bs.idbase','LEFT');
    $this->db->join('tarifa AS tr', 'itf.iditemf = tr.itemf_iditemf');

    $this->db->join('factura_recurso_reporte AS frrd','frrd.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario');
    $this->db->join('factura AS f', 'f.idfactura = frrd.idfactura');
    $this->db->join('vigencia_tarifas AS vtar', 'f.idvigencia_tarifas = vtar.idvigencia_tarifas');

    $this->db->where('frrd.idfactura', $idfactura);
    $this->db->where('OT.idOT', $idOT);
    $this->db->where('tr.idvigencia_tarifas = vtar.idvigencia_tarifas');
    $this->db->order_by('rd.fecha_reporte','ASC');
    $this->db->order_by('rd.idreporte_diario','ASC');
    return $this->db->get()->result();
  }

  // Mantener
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
    itf.itemc_item,
    itf.descripcion,
    tar.tarifa,
    p.identificacion,
    p.nombre_completo,
    IFNULL(rot.tipo, "activiad") AS tipo,
    IFNULL(e.codigo_siesa, rot.codigo_temporal) AS codigo_siesa,
    IFNULL(e.descripcion, rot.descripcion_temporal) AS descripcion_equipo
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
          ->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf')
          ->join('tarifa AS tar', 'tar.itemf_iditemf = itf.iditemf')
          ->join('vigencia_tarifas AS vg', 'vg.idvigencia_tarifas = tar.idvigencia_tarifas')
          ->where('c.idcontrato', $idcontrato)
          ->where('vg.idvigencia_tarifas = (
              SELECT vigencia.idvigencia_tarifas
              FROM vigencia_tarifas AS vigencia
              WHERE vigencia.fecha_inicio_vigencia <= rd.fecha_reporte
              AND vigencia.fecha_fin_vigencia >= rd.fecha_reporte
              ORDER BY vigencia.idvigencia_tarifas DESC LIMIT 1
              )')
          ->where('rd.fecha_reporte BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'" ');
    if( isset( $centros_operacion ) ){
      $this->db->where_not_in('b.idbase', $centros_operacion);
    }
    if( isset( $ordenes ) ){
      $this->db->where_not_in('OT.idOT', $ordenes);
    }
    return $this->db->get();
  }

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
      $this->db->where_in('OT.base_idbase', $centros_operacion);
    }
    $this->db->group_by('OT.idOT');
    return $this->db->get();
  }

  #=============================================================================
  public function get($idfactura)
  {
    $this->load->database('ot');
    return $this->db->select('f.*a')
      ->from('factura AS f')
      ->where('f.idfactura', $idfactura)
      ->get();
  }
  public function getOrdenesFactura($idfactura)
  {
    // Revisar
    $this->load->database('ot');
    return $this->db->select('OT.idOT, OT.nombre_ot AS No_OT, b.idbase AS CO, b.nombre_base AS base')
      ->from('OT')
      ->join('base As b','b.idbase = OT.base_idbase')
      ->join('reporte_diario AS rd','rd.Ot_idOT = OT.idOT')
      ->join('recurso_reporte_diario AS rrd','rrd.idreporte_diario = rd.idreporte_diario')
      ->join('factura_recurso_reporte AS frrd','frrd.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario')
      ->where('frrd.idfactura', $idfactura)
      ->group_by('OT.idOT')
      ->get()->result();
  }

  public function del($idfrd)
  {
    $this->load->database('ot');
    return $this->db->delete('factura_recurso_reporte', array('idfactura_recurso_reporte'=>$idfrd));
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
