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
      $ret->factura = $this->get($factura->idfactura, FALSE)->factura;
      echo json_encode($ret);
    } catch (Exception $e) {
      echo $e->getMessage();
      $this->fact->rollback();
    }
  }
  # Agregar una nueva factura
  private function add($factura)
  {
    $this->fact->init_transact();
    # guardamos primero la factura para obtener el ID
    #Creamos la factura
    $factura->idfactura = $this->fact->add($factura);
    #agregamos los recursos
    $subtotal = $this->saveRecursos($factura);
    # guardamos conceptos facturables
    $otros = $this->saveConceptos($factura);
    $factura->subtotal = $subtotal;// calculo de totales por concepto
    $factura->otros = $otros;// calculo de totales por concepto
    $factura->total = $subtotal + $otros;// calculo de totales por concepto
    $this->fact->mod($factura); // volvemos a guardar la factura con los totales y subtotales
    return $this->fact->end_transact();
  }

  # Actualizar una factura
  private function mod($factura)
  {
    $this->fact->init_transact();
    # Invertimos el orden para actualizar, primero los recursos y luego la factura
    $subtotal = $this->saveRecursos($factura);
    # guardamos conceptos facturables
    $otros = $this->saveConceptos($factura);
    $factura->subtotal = $subtotal; // calculo de totales por concepto
    $factura->otros = $otros; // calculo de totales por concepto
    $factura->total = $subtotal + $otros; // calculo de totales por concepto
    $this->fact->mod($factura); // guardamos de ultimo la factura ya que no necesitamos primero el ID y ya tenemos los subtotales
    return $this->fact->end_transact();
  }

  # guardas Recursos
  private function saveRecursos($factura)
  {
    $subtotal = 0;
    foreach ($factura->recursos as $key => $rec) {
      $rec->subtotal = $rec->tarifa * $rec->disponibilidad;
      $rec->a = $rec->a_vigencia*($rec->tarifa*$rec->disponibilidad);
      $rec->i = $rec->i_vigencia*($rec->tarifa*$rec->disponibilidad);
      $rec->u = $rec->u_vigencia*($rec->tarifa*$rec->disponibilidad);
      $rec->total = ( $rec->subtotal + $rec->a + $rec->i + $rec->u );
      $subtotal = $subtotal + $rec->total;
      if( isset($rec->idfactura_recurso_reporte) ){
        $this->fact->modRecurso($rec);
      }else{
        $this->fact->addRecurso($rec, $factura->idfactura);
      }
    }
    return $subtotal;
  }
  #guardar otros conceptos
  public function saveConceptos($factura)
  {
    $otros = 0;
    foreach ($factura->conceptos_factura as $key => $con) {
      if(isset($con->idconcepto_factura)){
        $this->fact->modConcepto($con);
      }else{
        $this->fact->addConcepto($con, $factura->idfactura);
      }
      $otros += $con->valor;
    }
    return $otros;
  }

  public function get($idfactura, $json = TRUE)
  {
    $ret = new stdClass();
    $this->load->model('factura_db','fact');
    $factura = $this->fact->get($idfactura);
    if($factura->num_rows() > 0 ){
      $ret->factura = $factura->row();
      $ret->factura->centros_operacion = json_encode($ret->factura->centros_operacion);
      $ret->factura->recursos = array();
      $ret->factura->conceptos_factura = array();

      $recursos = $this->fact->getRecursoByFactura($idfactura);
      if($recursos->num_rows() > 0  ){ $ret->factura->recursos = $recursos->result(); }

      $otros = $this->fact->getConceptosByFactura($idfactura);
      if ($otros->num_rows() > 0) { $ret->factura->conceptos_factura = $otros->result(); }
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
  # ----------------------------------------------------------------------------
  # recursos factura
  public function remove_recurso_factura()
  {
    $post = json_decode( file_get_contents('php://input') );
  }

  # ----------------------------------------------------------------------------
  # conceptos factura
  public function remove_concepto_factura()
  {
    $post = json_decode( file_get_contents('php://input') );
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
