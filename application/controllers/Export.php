<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index()
  {

  }

  public function historyRepoByOT($idOT, $nombre_ot, $fact=NULL)
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('reporte_db', 'repo');
    $production = ( isset($fact) && $fact==1 )?TRUE:NULL;
    $rows = $this->repo->getHistoryBy($idOT, $production);
    xlsx($rows->result_array(), $rows->list_fields(), './uploads/'.$nombre_ot.'.xlsx', 'historial', array('cantidad_final'));
    force_download('./uploads/'.$nombre_ot.'.xlsx',NULL);
    //$this->load->view('miscelanios/history/infoReportes', array('rows'=>$rows, 'nombre_ot'=>$nombre_ot) );
  }

  # ========================================================================
  # Informe de Producción
  public function form_informeProduccion($value='')
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $this->load->view('miscelanios/produccion/form_informeProduccion',array('bases'=>$bases));
  }

  public function informeFacturacion($f1=NULL, $f2=NULL)
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('facturacion_db', 'repo');
    $rows = $this->repo->informeFacturacion($f1, $f2);
    write_xlsx($rows->result_array(), $rows->list_fields(), './uploads/informeProduccion.xlsx');
    //genHojaCalculo($rows->result_array(), $rows->list_fields(), './uploads/informeFacturacion.xlsx');
    force_download('./uploads/informeProduccion.xlsx',NULL);
    //informeFacturacion( $rows->result_array(), $rows->list_fields() );
    //$this->load->view('miscelanios/history/infoReportes', array('rows'=>$rows, 'nombre_ot'=>( isset($nombre_ot)?$nombre_ot:'' ) ) );
  }

  public function informeProduccion()
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('facturacion_db', 'repo');

    $bases = $this->input->post("bases");
    $f1 = $this->input->post("fecha_ini");
    $f2 = $this->input->post("fecha_fin");
    $rows = $this->repo->informeFacturacion($f1, $f2, NULL, json_decode($bases));

    write_xlsx($rows->result_array(), $rows->list_fields(), './uploads/informeProduccion.xlsx');
    force_download('./uploads/informeProduccion.xlsx',NULL);
  }

  #=============================================================================
  # Acta de factura
  public function informaActaFactura($idfac, $f1=NULL, $f2=NULL)
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('facturacion_db', 'fac');
    $rows = $this->fac->sabanaActa($idfac);
    xlsx_export($rows->result_array(), $rows->list_fields(), './uploads/sabanaFactura.xlsx');
    force_download('./uploads/sabanaFactura.xlsx',NULL);
  }

  public function informeOtPyco($nodownload=FALSE)
  {
    $this->load->helper(array('config'));
    $this->load->model('facturacion_db', 'infofac');
    $rows = $this->infofac->informeOtPyco();
    $this->load->view('miscelanios/informesPyco/informeMesesOT', array('rows'=>$rows,'nodownload'=>$nodownload, "nombre"=>"InformeOrdenesPYCO") );
  }
  public function informePYCO($nodownload=FALSE)
  {
    $this->load->helper(array('config'));
    $this->load->model('facturacion_db', 'repo');
    $rows = $this->repo->informePYCO();
    $this->load->view('miscelanios/informePYCO', array('rows'=>$rows,'nodownload'=>$nodownload));
  }
  #=============================================================================
  public function reportePDF($idOT, $idrepo)
  {
    $this->load->helper('pdf');
    $this->load->model('reporte_db', 'repo');

    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $rpers = $this->repo->getRecursos($idrepo,"personal");
    $requs = $this->repo->getRecursos($idrepo,"equipos");
    $racts = $this->repo->getRecursos($idrepo,"actividades");
    $recursos->personal = $rpers->result();
    $recursos->equipos = $requs->result();
    $recursos->actividades = $racts->result();
	  $semanadias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $html = $this->load->view('reportes/imprimir/reporte_diario',
      array('r'=>$row, 'json_r'=>$json_r, 'recursos'=>$recursos, 'semanadias'=>$semanadias, 'footer'=>$this->getStatusFooter($row->validado_pyco) ),
      TRUE);
    doPDF($html, 'Reporte-'.$row->nombre_ot);
    //echo $html;
  }

  public function rd_pma($idOT, $idrepo)
  {
    setlocale(LC_ALL,"es_ES");
    $this->load->helper('reporte_pma');
    $this->load->model('reporte_db', 'repo');
    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $recursos->personal = $this->repo->getRecursos($idrepo,"personal")->result();
    $recursos->equipos = $this->repo->getRecursos($idrepo,"equipos")->result();
    $recursos->actividades = $this->repo->getRecursos($idrepo,"actividades")->result();
    $vw = $this->load->view('reportes/imprimir_pma/rd/rd', array( 'recursos'=>$recursos, 'r'=>$row, 'json_r'=>$json_r, 'export'=>FALSE ), TRUE);
    //echo $vw;
    //$vw = $this->load->view('reportes/imprimir_pma/test','',TRUE);
    $this->load->helper('pdf');
    doPDF($vw, 'Reporte-'.$row->nombre_ot, NULL, TRUE);
  }

  public function reportePDFHTML($idOT, $idrepo)
  {
    $this->load->helper('pdf');
    $this->load->model('reporte_db', 'repo');

    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $rpers = $this->repo->getRecursos($idrepo,"personal");
    $requs = $this->repo->getRecursos($idrepo,"equipos");
    $racts = $this->repo->getRecursos($idrepo,"actividades");
    $recursos->personal = $rpers->result();
    $recursos->equipos = $requs->result();
    $recursos->actividades = $racts->result();
	  $semanadias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $html = $this->load->view('reportes/imprimir/reporte_diario',
      array('r'=>$row, 'json_r'=>$json_r, 'recursos'=>$recursos, 'semanadias'=>$semanadias, 'footer'=>$this->getStatusFooter($row->validado_pyco) ),
      TRUE);
    echo $html;
  }

  public function vwPrintSelection($idOT, $idrepo)
  {
    $this->load->view('reportes/imprimir/preview_select', array('idOT'=>$idOT, 'idrepo'=>$idrepo));
  }

  public function printSelection($idOT, $idrepo)
  {
    $this->load->helper('pdf');
    $this->load->helper('reporte_pma');
    $this->load->model('reporte_db', 'repo');
    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $rpers = $this->repo->getRecursos($idrepo,"personal");
    $requs = $this->repo->getRecursos($idrepo,"equipos");
    $racts = $this->repo->getRecursos($idrepo,"actividades");

    $recursos = new stdClass();
    $recursos->json_r = json_decode($row->json_r);
    $recursos->personal = $rpers->result();
    $recursos->equipos = $requs->result();
    $recursos->actividades = $racts->result();
    $recursos->idOT = $idOT;
    $recursos->idreportye = $idrepo;
    $recursos->nombre_ot = $row->nombre_ot;
    echo json_encode($recursos);
  }

  public function printSelected($idOT, $idrepo)
  {
    $this->load->helper('pdf');
    $this->load->model('reporte_db', 'repo');
    $post = json_decode($this->input->post('jsonSelection'));
    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $recursos->personal = $post->personal;
    $recursos->equipos = $post->equipos;
    $recursos->actividades = $post->actividades;

    $json_r->observaciones = isset($post->observaciones)?$post->observaciones:$json_r->observaciones;
    $json_r->elaborador_nombre = isset($post->elaborador_nombre)?$post->elaborador_nombre:'';
    $json_r->contratista_nombre = isset($post->contratista_nombre)?$post->contratista_nombre:'';
    $json_r->ecopetrol_nombre = isset($post->ecopetrol_nombre)?$post->ecopetrol_nombre:'';
    $json_r->elaborador_cargo = isset($post->elaborador_cargo)?$post->elaborador_cargo:'';
    $json_r->contratista_cargo = isset($post->contratista_cargo)?$post->contratista_cargo:'';
    $json_r->ecopetrol_cargo = isset($post->ecopetrol_cargo)?$post->ecopetrol_cargo:'';

    /*$semanadias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $html = $this->load->view('reportes/imprimir/reporte_diario',
      array('r'=>$row, 'json_r'=>$json_r, 'recursos'=>$recursos, 'semanadias'=>$semanadias, 'footer'=>$this->getStatusFooter($row->validado_pyco) ),
      TRUE);*/
    $vw = $this->load->view('reportes/imprimir_pma/rd/rd', array( 'recursos'=>$recursos, 'r'=>$row, 'json_r'=>$json_r, 'export'=>FALSE ), TRUE);
    doPDF($html, 'Reporte-'.$row->nombre_ot);
  }

  public function getStatusFooter($value='')
  {
    if($value == "CORREGIR"){
      return "CGIR";
    }elseif ($value == "CORREGIDO") {
      return "CRDO";
    }
    return substr($value, 0, 2);
  }

  # =================================================================================
  public function resumenOt($idOT)
  {
    $this->load->model('ot_db', 'ot');
		$resumen = $this->ot->resumenOT($idOT);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ResumenOT.xls"');
    header('Cache-Control: max-age=0');
		$this->load->view('ot/table_resumen', array('items'=>$resumen, 'idOT'=>$idOT) );
  }

  # =================================================================================

  public function testXLSX($value='')
  {
    $this->load->helper('excel');
    $this->load->model('facturacion_db', 'repo');
    $rows = $this->repo->informeFacturacion();
    informeFacturacion($rows);
  }


  public function formatoEquiposTareaOT($idtr)
  {
    $this->load->model('item_db', 'it');
    $this->load->model('tarea_db', 'tr');
    $ot = $this->tr->getOT($idtr)->row();
    $equipos = $this->it->getItemsBy($idtr, 3);
    $this->load->view('miscelanios/formatosCarga/equiposOT', array('equipos'=>$equipos,'nombre_archivo'=>'CargueEquipos'.$ot->nombre_ot) );
  }

  public function sabanaPlaneacion($value='')
  {
    $post = json_decode( file_get_contents('php://input') );
		$this->load->model('Miscelanio_db', 'misc');
  }

  public function informeCargues($value='')
  {
    $this->load->model('ot_db');
    $rows = $this->ot_db->informeCargues();
    $this->load->view('miscelanios/excelGenerico', array( 'rows'=>$rows, 'nombre'=>'InformeRecursosCargadosOT') );
  }

  public function informesPrueba($value='')
  {
    $this->load->helper('xlsx');
    $this->load->helper('download');
    $this->load->model('facturacion_db', 'repo');
    $rows = $this->repo->informeFacturacion();
    genHojaCalculo($rows->result_array(), $rows->list_fields(), './uploads/informeFacturacion.xlsx');
    force_download('./uploads/informeFacturacion.xlsx',NULL);
  }
}
