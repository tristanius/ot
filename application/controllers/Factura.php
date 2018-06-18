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
  #=============================================================================
  # Gestiones del panel principal

  # Ingreso a la gestion de facturación de producción
  public function gestion()
  {
    $this->load->database('ot');
    $conts = $this->db->get('contrato');
    $this->load->view('factura/gestion', array( 'contratos'=>$conts->result() ) );
  }

  # ------ Formulario de ingreso de factura --------
  public function form($tipo, $idfactura = NULL)
  {
    $this->load->model('factura_db', 'fac');
    $this->load->model('miscelanio_db', 'misc');
    $sectores = $this->misc->getBasesBySector();
    if($tipo == 'add'){
      $this->load->view('factura/factura/form', array('isMod'=>FALSE));
    }elseif ($tipo == 'mod') {
      $post = json_decode( file_get_contents('php://input') );
      $this->load->view('factura/factura/form', array('idfactura'=>$idfactura, 'isMod'=>TRUE));
    }
  }

  # ------ Listado de facturas ------
  # Listar las facturas
  public function lista($idcontrato=NULL)
  {
    if($idcontrato == NULL){
      $post = json_decode( file_get_contents('php://input') );
      $idcontrato = $post->idcontrato;
    }
    $this->getContratoInfo($idcontrato, TRUE);
  }

  # Obtener información de contratos
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
  # Borrar una factura
  public function delFactura($idfac)
  {
    $this->load->database('ot');
    $this->db->delete('factura_recurso_reporte', array('idfactura_recurso_reporte'=>$idfac));
    $this->db->delete('factura', array('idfactura'=>$idfac));
    echo "success";
  }
  # ============================================================================
  # ------- Procesos de form factura -------
  # Guardar factura
  public function save($value='')
  {
    $factura = json_decode( file_get_contents('php://input') );
    $this->load->model('factura_db', 'fact');
    $ret = new stdClass();
    try {
      if(isset($factura->idfactura)){
        $ret->status = $this->mod($factura);
      }else{
        $ret->status = $this->add($factura);
      }
      $ret->factura = $this->get($factura->idfactura, FALSE);
      echo json_encode($ret);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  # Agregar una nueva factura
  private function add($factura)
  {
    $this->fact->init_transact();
    $factura->idfactura = $this->fact->add($factura);
    foreach ($factura->recursos as $key => $recurso) {
      $this->fact->addRecurso($recurso, $factura->idfactura);
    }
    return $this->fact->end_transact();
  }
  # Actualizar una factura
  private function mod($factura)
  {
    $this->fact->init_transact();
    $this->fact->mod($factura);
    foreach ($factura->recursos as $key => $recurso) {
      $this->fact->modRecurso($recurso);
    }
    return $this->fact->end_transact();
  }

  public function get($idfactura, $json = TRUE)
  {
    $ret = new stdClass();
    $this->load->model('factura_db','fact');
    $factura = $this->fact->get($idfactura);
    if($factura->num_rows() > 0 ){
      $ret->factura = $factura->row();
      $recursos = $this->fact->getRecursoByFactura($idfactura);
      // faltantes otros conceptos y archivos adjuntos
      if($recursos->num_rows() > 0  ){
        $ret->factura->recursos =$recursos->result();
      }
      $ret->status = true;
    }else{
      $ret->status = false;
    }
    if($json){
      echo json_encode($ret);
    }else{
      return $ret;
    }
  }
  # -------------------------------------------------------------------------
  # Obtener recursos reportados sin facturar
  public function get_recursos()
  {
    $factura = json_decode( file_get_contents('php://input') );
    $this->load->model(array('factura_db'=>'fac'));
    # Obtenemos los filtros de centros de operacion y ordenes de trabajo
    $cos = (isset($factura->centros_operacion_excluidos)?($factura->centros_operacion_excluidos):NULL);
    $ots = (isset($factura->ordenes_excluidas)?($factura->ordenes_excluidas):NULL);
    // Realizamos las consultas
    $recursos = $this->fac->getRecursos($factura->idcontrato, $factura->fecha_inicio, $factura->fecha_fin, $cos, $ots );
    $ordenes = $this->fac->getOrdenesByCO($factura->idcontrato, $factura->fecha_inicio, $factura->fecha_fin, $cos);
    $ret = new stdClass();
      $ret->success = TRUE;
      $ret->recursos = $recursos->result();
      $ret->ordenes = $ordenes->result();
    echo json_encode($ret);
  }
  # Obtener ordenes de trabajo por centros de operacion
  public function get_ordenes()
  {
    $factura = json_decode( file_get_contents('php://input') );
    $this->load->model(array('factura_db'=>'fac'));
    $cos = ($factura->centros_operacion_excluidos?($factura->centros_operacion_excluidos):NULL);
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
  # Borrar 1 items de la factura
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
}
