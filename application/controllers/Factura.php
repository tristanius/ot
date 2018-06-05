<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index(){
  }

  public function gestion()
  {
    $this->load->database('ot');
    $conts = $this->db->get('contrato');
    $this->load->view('factura/gestion', array( 'contratos'=>$conts->result() ) );
  }

  public function form($tipo, $idfactura = NULL)
  {
    $this->load->model('factura_db', 'fac');
    $this->load->model('miscelanio_db', 'misc');
    $sectores = $this->misc->getBasesBySector();
    if($tipo == 'add'){
      $this->load->view('factura/factura/form', array('sectores'=>$sectores, 'isMod'=>FALSE));
    }elseif ($tipo == 'mod') {
      $post = json_decode( file_get_contents('php://input') );
      $this->load->view('factura/factura/form', array('sectores'=>$sectores, 'idfactura'=>$idfactura, 'isMod'=>TRUE));
    }
  }

  public function add()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model('factura_db', 'fac');
    $this->fac->init_transact();
    $idf = $this->fac->add( $post );
    $ordenes = $post->ordenes;
    foreach ($ordenes as $key => $ot) {
      foreach ($ot->recursos as $key => $rec) {
        $rec->cantidad_total = $this->calcularCantidad($rec);
        $rec->idfactura_recurso_reporte = $this->fac->addRecurso($rec, $idf);
      }
    }
    $insertStatus = $this->fac->end_transact();
    if ($insertStatus) {
      echo 'success';
    }else{
      echo 'failed';
    }
  }

  public function mod()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model('factura_db', 'fac');
    $this->fac->init_transact();
    $this->fac->mod( $post );
    $ordenes = $post->ordenes;
    foreach ($ordenes as $key => $ot) {
      foreach ($ot->recursos as $key => $rec) {
        $rec->cantidad_total = $this->calcularCantidad($rec);
        $this->fac->modRecurso($rec);
      }
    }
    $insertStatus = $this->fac->end_transact();
    if ($insertStatus) {
      echo 'success';
    }else{
      echo 'failed';
    }
  }

  public function lista($idcontrato=NULL)
  {
    if($idcontrato == NULL){
      $post = json_decode( file_get_contents('php://input') );
      $idcontrato = $post->idcontrato;
    }
    $this->getContratoInfo($idcontrato, TRUE);
  }

  // Getters

  public function get($idfactura)
  {
    $this->load->model('factura_db', 'fac');
    $facts = $this->fac->get($idfactura);
    if ($facts->num_rows() > 0 ) {
      $fact=$facts->row();
      $fact->bases = json_decode($fact->filtros);
      $fact->actas = json_decode($fact->actas);
      $fact->ordenes = $this->fac->getOrdenesFactura($idfactura);
      $recursos = NULL;
      foreach ($fact->ordenes as $key => $ot) {
         $ot->recursos = $this->fac->getRecursosByFact($ot->idOT, $idfactura );
      }
      $obj = new stdClass();
      $obj->success = "success";
      $obj->fac = $fact;
      echo json_encode($obj);
    }else{
      echo 'failed';
    }
  }

  public function getContratoInfo($idcontrato, $JSON = FALSE)
  {
    $this->load->model(array('factura_db'=>'fact'));
    $contrato = $this->fact->getContrato($idcontrato)->row();
    $contrato->vigencias = $this->fact->getVigenciasContrato($contrato->idcontrato)->result();
    $contrato->facturas = $this->fact->getFacturasContrato($contrato->idcontrato)->result();
    $contrato->centros_operacion = $this->fact->getCentrosOperacionContratos($contrato->idcontrato)->result();
    if ($JSON) {
      echo json_encode($contrato);
    }
    return $contrato;
  }

  public function getFacturablesByOT()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model(array('factura_db'=>'fac'));
    $ots = $this->fac->getOrdenes($post);
    foreach ($ots as $k => $o) {
      $o->recursos = $this->fac->getRecursosByOt($o->idOT, $post->fecha_ini_factura, $post->fecha_fin_factura, $post->idvigencia_tarifas);
    }
    echo json_encode($ots);
  }
  public function getOrdenesFactura($centros_operacon=NULL)
  {

  }


  //-----------------------------------------------------------------------------
  // Aqui obtenemos los recursos para crear una nueva factura
  //Puede darse el caso que se use para modificar una factura en creacion
  public function get_recursos()
  {
    $factura = json_decode( file_get_contents('php://input') );
    $this->load->model(array('factura_db'=>'fac'));
    $cos = (isset($fectura->centros_operacion_excluidos)?json_decode($fectura->centros_operacion_excluidos):NULL);
    $ots = (isset($fectura->ordenes_excluidas)?json_decode($fectura->ordenes_excluidas):NULL);
    $recursos = $this->fac->getrecursos($factura->idcontrato, $factura->fecha_inicio, $factura->fecha_fin, $cos, $ots );
    $ret = new stdClass();
    if($recursos->num_rows() > 0){
      $ret->success = TRUE;
      $ret->recursos = $recursos->result();
    }else{
      $ret->success = FALSE;
    }
    echo json_encode($ret);
  }

  public function get_ordenes()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model(array('factura_db'=>'fac'));
    $cos = ($fectura->centros_operacion_excluidos?json_decode($fectura->centros_operacion_excluidos):NULL);
    $ordenes = $this->fac->getOrdenesByCO($factura->idcontrato, $factura->fecha_inicio, $factura->fecha_fin, $cos);
    $ret = new stdClass();
    if($recursos->num_rows() > 0){
      $ret->success = TRUE;
      $ret->ordenes = $ordenes->result();
    }else{
      $ret->success = FALSE;
    }
    echo json_encode($ret);
  }
  #=============================================================================
  public function delItemFactura()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model('factura_db', 'fac');
    $this->fac->init_transact();
    $this->fac->del($post->idfactura_recurso_reporte);
    $status = $this->fac->end_transact();
    if ($status) {
      echo 'success';
    }else {
      echo "fail";
    }
  }
  public function delFactura($idfac)
  {
    $this->load->database('ot');
    $this->db->delete('factura_recurso_reporte', array('idfactura_recurso_reporte'=>$idfac));
    $this->db->delete('factura', array('idfactura'=>$idfac));
    echo "success";
  }
}
