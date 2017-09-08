<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarea_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function setTarea($idOT, $tarea)
  {
    $this->load->database('ot');
  }

  public function setItems($idOT, $tarea)
  {
    $this->load->database('ot');
  }

  #===========================================================================
  # Agregar tarea
  public function add(
    $nombre_tarea_ot,
    $fecha_inicio,
    $fecha_fin,
    $valor_recursos,
    $valor_tarea_ot,
    $json_indirectos, $json_viaticos, $json_horas_extra,
    $json_reembolsables, $json_racion, $json_recursos,
    $responsables, $requisitos_documentales,
    $OT_idOT, $sap,$clase_sap, $tipo_sap,
    $sap_pago, $clase_sap_pago, $tipo_sap_pago,  $editable)
  {
    $data = array(
      'nombre_tarea'=>$nombre_tarea_ot,
      'fecha_inicio'=>$fecha_inicio,
      'fecha_fin'=>$fecha_fin,
      'valor_recursos'=>$valor_recursos,
      'valor_tarea_ot'=>$valor_tarea_ot,
      'json_indirectos'=>$json_indirectos,
      'json_viaticos'=>$json_viaticos,
      'json_horas_extra'=>$json_horas_extra,
      'json_reembolsables'=>$json_reembolsables,
      'json_raciones'=>$json_racion,
      'json_recursos'=>$json_recursos,
      'OT_idOT'=>$OT_idOT,
      'responsables'=>$responsables,
      'requisitos_documentales'=>$requisitos_documentales,
      'sap'=>$sap,
      "clase_sap"=>$clase_sap,
      "tipo_sap"=>$tipo_sap,
      'sap_pago'=>$sap_pago,
      "clase_sap_pago"=>$clase_sap_pago,
      "tipo_sap_pago"=>$tipo_sap_pago,
      'editable'=>$editable
    );
    $this->db->insert('tarea_ot', $data);
    return $this->db->insert_id();
  }

  //Actualiza una tarea de una Ot
  public function update(
    $idtarea_ot, $nombre_tarea_ot,
    $fecha_inicio, $fecha_fin,
    $valor_recursos, $valor_tarea_ot,
    $json_indirectos, $json_viaticos,
    $json_horas_extra, $json_reembolsables,
    $json_racion, $json_recursos, $responsables,
    $requisitos_documentales, $OT_idOT,
    $sap, $clase_sap, $tipo_sap, $sap_pago,
    $clase_sap_pago, $tipo_sap_pago, $editable)
  {
    $data = array(
      'nombre_tarea'=>$nombre_tarea_ot,
      'fecha_inicio'=>$fecha_inicio,
      'fecha_fin'=>$fecha_fin,
      'valor_recursos'=>$valor_recursos,
      'valor_tarea_ot'=>$valor_tarea_ot,
      'json_indirectos'=>$json_indirectos,
      'json_viaticos'=>$json_viaticos,
      'json_horas_extra'=>$json_horas_extra,
      'json_reembolsables'=>$json_reembolsables,
      'json_raciones'=>$json_racion,
      'json_recursos'=>$json_recursos,
      'responsables'=>$responsables,
      'requisitos_documentales'=>$requisitos_documentales,
      'OT_idOT'=>$OT_idOT,
      'sap'=>$sap,
      "clase_sap"=>$clase_sap,
      "tipo_sap"=>$tipo_sap,
      'sap_pago'=>$sap_pago,
      "clase_sap_pago"=>$clase_sap_pago,
      "tipo_sap_pago"=>$tipo_sap_pago,
      'editable'=>$editable
    );
    return $this->db->update('tarea_ot', $data, 'idtarea_ot = '.$idtarea_ot);
  }

  #====================================================================================================
  # Consultas
  #====================================================================================================

  # Obtener los items de una tarea por tipo
  public function getItemsByTipo($idtarea, $tipo)
  {
    $this->load->database('ot');
    $this->db->select('
        itt.iditem_tarea_ot,
        itt.cantidad,
        itt.duracion,
        itt.unidad,
        itt.fecha_agregado,
        itt.valor_plan,
        itt.itemf_iditemf,
        itt.itemf_codigo,
        itt.tarea_ot_idtarea_ot,
        itt.facturable,
        itf.codigo,
        itf.descripcion,
        itf.itemc_item,
        itf.iditemf,
        itt.idsector_item_tarea,
        tar.OT_idOT AS idot,
        itt.tarifa,
        tarif.salario,
        tar.responsables,
        tar.requisitos_documentales,
        tar.editable,
        titc.CL
        ');
    $this->db->from('item_tarea_ot AS itt');
    $this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
    $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc');
    $this->db->join('tarifa AS tarif','tarif.itemf_iditemf = itf.iditemf');
    $this->db->join('tarea_ot AS tar', 'tar.idtarea_ot = itt.tarea_ot_idtarea_ot');
    $this->db->where('tarif.estado_tarifa', TRUE); // CORREGIR ESTO !!!!!!!!!!!!!
    $this->db->where('itf.tipo',$tipo);
    $this->db->where('itt.tarea_ot_idtarea_ot',$idtarea);
    return $this->db->get();
  }

  # Obtener todos los items de una tarea
  public function getTareasItemsResumenBy($idot, $tipo=NULL)
  {
    $this->load->database('ot');
    $this->db->select('
      itf.codigo,
      itf.descripcion,
      itf.itemc_item,
      itf.iditemf,
      tar.OT_idOT AS idot,
      itt.tarifa,
      tar.responsables,
      tar.requisitos_documentales,
      itt.iditem_tarea_ot,
      itt.facturable'
      );
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
    $this->db->join('tarifa AS tarif','tarif.itemf_iditemf = itf.iditemf');
		$this->db->join('tarea_ot AS tar', 'tar.idtarea_ot = itt.tarea_ot_idtarea_ot');
    $this->db->where('tar.OT_idOT', $idot);
    $this->db->where('tarif.estado_tarifa', TRUE); // CORREGIR ESTO !!!!
    if (isset($tipo)) {
      $this->db->where('itf.tipo',$tipo);
    }
    $this->db->group_by('itf.codigo');
    return $this->db->get();
  }

  # Obterner valores planeados de items de una OT (varias tareas) agrupado por codido itemf
  public function getResumenCantItems($idOT, $tipo = NULL, $idTr = NULL) //tipo 1 actividades, 2 personal, 3 equipos
  {
    $this->load->database('ot');
    return $this->db->select('
          OT.idOT, OT.nombre_ot, OT.base_idbase, tr.idtarea_ot, tr.nombre_tarea, itt.iditem_tarea_ot,
          SUM(itt.duracion) AS duracion_tot, SUM(itt.cantidad) AS planeado, itt.unidad, itt.tarifa,
          itt.fecha_agregado, itt.valor_plan, itt.itemf_iditemf, itt.itemf_codigo, itt.fecha_agregado,
          itt.idsector_item_tarea, itf.*, tr.responsables, tr.requisitos_documentales,
        ')->from('OT')
        ->join('tarea_ot AS tr', 'OT.idOT = tr.OT_idOT')
        ->join('item_tarea_ot AS itt', 'tr.idtarea_ot = itt.tarea_ot_idtarea_ot')
        ->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf')
        ->where('OT.idOT',$idOT)
        ->where('itf.tipo', $tipo)
        ->group_by('itf.codigo')
        ->order_by('itf.codigo','ASC')
        ->get();
  }
  public function getActividadesPlaneadas($idOT, $tipo = NULL, $idTr = NULL, $fecha = NULL) //tipo 1 actividades, 2 personal, 3 equipos
  {
    $this->load->database('ot');
    return $this->db->select('
          OT.idOT, OT.nombre_ot, OT.base_idbase, tr.idtarea_ot, tr.nombre_tarea, itt.iditem_tarea_ot,
          SUM(itt.duracion) AS duracion_tot, SUM(itt.cantidad) AS planeado, itt.unidad, itt.tarifa,
          itt.fecha_agregado, itt.valor_plan, itt.itemf_iditemf, itt.itemf_codigo, itt.fecha_agregado,
          itt.idsector_item_tarea, itf.*, tr.responsables, tr.requisitos_documentales,
        ')->from('OT')
        ->join('tarea_ot AS tr', 'OT.idOT = tr.OT_idOT')
        ->join('item_tarea_ot AS itt', 'tr.idtarea_ot = itt.tarea_ot_idtarea_ot')
        ->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf')
        ->where('OT.idOT',$idOT)
        ->where('itf.tipo', $tipo)
        ->group_by('itf.codigo')
        ->group_by('itt.idsector_item_tarea')
        ->order_by('itf.codigo','ASC')
        ->get();
  }

  public function getCantidadSum($fecha, $item, $idsector, $idOT)
  {
    $this->load->database('ot');
    $row = $this->db->query(
      "
        SELECT CAST( SUM(rrd.cantidad) AS DECIMAL(10,5) ) as cant
        FROM reporte_diario AS rd
        JOIN recurso_reporte_diario AS rrd ON rrd.idreporte_diario = rd.idreporte_diario
        WHERE rd.OT_idOT = ".$idOT."
        AND rrd.itemf_codigo = ".$item."
        AND rd.fecha_reporte < '".$fecha."'
        AND rrd.idsector_item_tarea = ".$idsector."
      "
    );
    return $row;
  }

  # Obterner un item de una OT por su codigo de facturación
  public function getItemOTSUM($idOT, $codigo)
  {
    $this->load->database('ot');
    return $this->db->select('OT.*, tr.nombre_tarea, itr.*, SUM(itr.cantidad) AS cant_plan, SUM(itr.duracion) AS dura_plan, itf.*')
          ->from('OT')
          ->join('tarea_ot AS tr', 'tr.OT_idOT = OT.idOT')
          ->join('item_tarea_ot AS itr', 'itr.tarea_ot_idtarea_ot = tr.idtarea_ot')
          ->join('itemf AS itf','itf.iditemf = itr.itemf_iditemf')
          ->where('OT.idOT',$idOT)
          ->where('itf.codigo', $codigo)
          ->group_by('itr.itemf_iditemf')
          ->get();
  }

  # obtener la OT con el No. de ID de la tarea
  public function getOT($idtr)
  {
    $this->load->database('ot');
    return $this->db->from('tarea_ot AS tr')->join("OT",'OT.idOT = tr.OT_idOT')->where('tr.idtarea_ot',$idtr)->get();
  }

  public function getDupeTareas($idOT, $arr_tareas, $tipo)
  {
    return $this->db->select('tr.*, itt.*')
    ->from('OT')
    ->join('tarea_ot AS tr', 'OT.idOT = tr.OT_idOT')
    ->join('item_tarea_ot AS itt', 'tr.idtarea_ot = itt.tarea_ot_idtarea_ot')
    ->join('itemf AS itf', 'itf.iditemf = itt.itemf_iditemf')
    ->where('OT.idOT',$idOT)
    ->where('itf.tipo', $tipo)
    ->where_in('tr.idtarea_ot', $arr_tareas)
    ->group_by('itf.codigo')
    ->order_by('itf.codigo','ASC')
    ->get();
  }

  public function getTareasByOT($idOT)
  {
    $this->load->database('ot');
    return $this->db->from('tarea_ot')->where('OT_idOT',$idOT)->get();
  }

}
