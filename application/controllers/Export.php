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
    $this->load->model('facturacion_db', 'repo');
  }

  public function historyRepoByOT($idOT, $nombre_ot, $fact=NULL)
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('reporte_db', 'repo');
    $production = ( isset($fact) && $fact==1 )?TRUE:NULL;
    $rows = $this->repo->getHistoryBy($idOT, $production);
    xlsx($rows->result_array(), $rows->list_fields(), './uploads/'.$nombre_ot.'.xlsx', 'historial', array('cantidad_final'));
    force_download('./uploads/reportes/'.$nombre_ot.'.xlsx',NULL);
    //$this->load->view('miscelanios/history/infoReportes', array('rows'=>$rows, 'nombre_ot'=>$nombre_ot) );
  }

  # ========================================================================
  # Informe de Producción
  public function form_informeProduccion($value='')
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $this->load->view( 'miscelanios/produccion/form_informeProduccion', array('bases'=>$bases) );
  }

  public function informeFacturacion($f1=NULL, $f2=NULL)
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('facturacion_db', 'fact');
    $rows = $this->fact->informeFacturacion($f1, $f2);
    $file_path = './uploads/informeProduccion/informeProduccion-'.date('YmdHis').'.xlsx';
    write_xlsx($rows->result_array(), $rows->list_fields(), $file_path );
    //genHojaCalculo($rows->result_array(), $rows->list_fields(), './uploads/informeFacturacion.xlsx');
    force_download($file_path, NULL);
    //informeFacturacion( $rows->result_array(), $rows->list_fields() );
    //$this->load->view('miscelanios/history/infoReportes', array('rows'=>$rows, 'nombre_ot'=>( isset($nombre_ot)?$nombre_ot:'' ) ) );
  }

  public function informeProduccion()
  {
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('facturacion_db', 'fact');

    $bases = $this->input->post("bases");
    $f1 = $this->input->post("fecha_ini");
    $f2 = $this->input->post("fecha_fin");
    $tipo_informe = $this->input->post("tipo_informe");
    $rows = $this->fact->informeFacturacion($f1, $f2, NULL, json_decode($bases), $tipo_informe);

    $file_path = './uploads/informeProduccion/informeProduccion-'.date('YmdHis').'.xlsx';
    write_xlsx($rows->result_array(), $rows->list_fields(), $file_path);
    force_download($file_path,NULL);
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

  public function informeOtPyco( $f_inicio=NULL, $f_final=NULL, $nodownload=FALSE)
  {
    $this->load->helper(array('config'));
    $this->load->model('facturacion_db', 'infofac');
    $where = NULL;
    if( isset($f_inicio)){
      $where = "tr.fecha_inicio >= '".$f_inicio."'";
    }
    $rows = $this->infofac->informeOtPyco($where);
    $this->load->view('miscelanios/informesPyco/informeMesesOT', array('rows'=>$rows,'nodownload'=>$nodownload, "nombre"=>"InformeOrdenesPYCO") );
  }
  public function informePYCO( $f_inicio=NULL, $f_final=NULL, $nodownload=FALSE)
  {
    $this->load->helper(array('config'));
    $this->load->model('facturacion_db', 'repo');
    $where = NULL;
    if( isset($f_inicio) ){
      $where = "tr.fecha_inicio >= '".$f_inicio."'";
    }
    $rows = $this->repo->informePYCO($where);
    $this->load->view('miscelanios/informePYCO', array('rows'=>$rows,'nodownload'=>$nodownload));
  }
  #=============================================================================

  public function rdPDF($idOT, $idrepo)
  {
    $this->load->helper('reporte_pma');
    $this->load->model('reporte_db', 'repo');
    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    switch ($row->idcontrato) {
      case 1:
        $this->reportePDF($idOT, $idrepo);
        break;
      case 2:
        $fecha = date('Y-m-d', strtotime($row->fecha_reporte) );
        if($fecha >= date('Y-m-d', strtotime('2018-01-01')) ){
          $this->rd_pma($idOT, $idrepo, 'reportes/imprimir_pma/v2018/rd', FALSE);
        }else{
          $this->rd_pma($idOT, $idrepo, 'reportes/imprimir_pma/v2017/rd/rd');
        }
        break;
      default:
        $this->reportePDF($idOT, $idrepo);
        break;
    }
  }

  public function reportePDF($idOT, $idrepo)
  {
    $this->load->model( array('reporte_db'=>'repo', 'recurso_reporte_db'=>'rec_repo') );
    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $rpers = $this->rec_repo->getRecursos($idrepo,"personal");
    $requs = $this->rec_repo->getRecursos($idrepo,"equipos");
    $racts = $this->rec_repo->getRecursos($idrepo,"actividades");
    $recursos->personal = $rpers->result();
    $recursos->equipos = $requs->result();
    $recursos->actividades = $racts->result();
	  $semanadias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    // generamos un pdf con el helper de pdf
    $this->load->helper('pdf');
    $html = $this->load->view('reportes/imprimir/reporte_diario',
      array('r'=>$row, 'json_r'=>$json_r, 'recursos'=>$recursos, 'semanadias'=>$semanadias, 'footer'=>$this->getStatusFooter($row->validado_pyco) ),
      TRUE);
    doPDF($html, 'Reporte-'.$row->nombre_ot, NULL, FALSE);
    //echo $html;
  }

  public function rd_pma($idOT, $idrepo, $formato, $landscape = TRUE)
  {
    setlocale(LC_ALL,"es_ES");
    $this->load->helper('reporte_pma');
    $this->load->model( array('reporte_db'=>'repo', 'recurso_reporte_db'=>'rec_repo') );
    $this->load->model('ot_db');
    $row = $this->repo->getBy($idOT, NULL, $idrepo)->row();
    $row->sap_tarea =  $this->ot_db->getSAP($idOT, $row->fecha_reporte);
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $recursos->personal = $this->rec_repo->getRecursos($idrepo,"personal")->result();
    $recursos->equipos = $this->rec_repo->getRecursos($idrepo,"equipos")->result();
    $recursos->actividades = $this->rec_repo->getRecursos($idrepo,"actividades")->result();
    $vw = $this->load->view( $formato , array( 'recursos'=>$recursos, 'r'=>$row, 'json_r'=>$json_r, 'export'=>FALSE ), TRUE);
    // generamos un pdf con el helper de pdf
    $this->load->helper('pdf');
    doPDF($vw, 'Reporte-'.$row->nombre_ot, NULL, $landscape);
  }

  public function reportePDFHTML($idOT, $idrepo)
  {
    $this->load->helper('pdf');
    $this->load->model( array('reporte_db'=>'repo', 'recurso_reporte_db'=>'rec_repo') );

    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $rpers = $this->rec_repo->getRecursos($idrepo,"personal");
    $requs = $this->rec_repo->getRecursos($idrepo,"equipos");
    $racts = $this->rec_repo->getRecursos($idrepo,"actividades");
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
    $this->load->model( array('reporte_db'=>'repo', 'recurso_reporte_db'=>'rec_repo') );
    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $rpers = $this->rec_repo->getRecursos($idrepo,"personal");
    $requs = $this->rec_repo->getRecursos($idrepo,"equipos");
    $racts = $this->rec_repo->getRecursos($idrepo,"actividades");

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
    $this->load->helper('reporte_pma');
    $this->load->model('reporte_db', 'repo');
    $this->load->model('ot_db');
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

    switch ($row->idcontrato) {
      case 1:
        $semanadias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
        $vw = $this->load->view('reportes/imprimir/reporte_diario',
          array('r'=>$row, 'json_r'=>$json_r, 'recursos'=>$recursos, 'semanadias'=>$semanadias, 'footer'=>$this->getStatusFooter($row->validado_pyco) ),
          TRUE);
          doPDF($vw, 'Reporte-'.$row->nombre_ot, NULL, FALSE);
        break;
      case 2:
        $row->sap_tarea =  $this->ot_db->getSAP($idOT, $row->fecha_reporte);
        if($fecha >= date('Y-m-d', strtotime('2018-01-01')) ){
          $formato = 'reportes/imprimir_pma/v2018/rd';
        }else{
          $formato = 'reportes/imprimir_pma/v2017/rd/rd';
        }
        $vw = $this->load->view($formato, array( 'recursos'=>$recursos, 'r'=>$row, 'json_r'=>$json_r, 'export'=>FALSE ), TRUE);
        doPDF($vw, 'Reporte-'.$row->nombre_ot, NULL, TRUE);
        break;
      default:
        $row->sap_tarea =  $this->ot_db->getSAP($idOT, $row->fecha_reporte);
        $vw = $this->load->view('reportes/imprimir_pma/v2018/rd', array( 'recursos'=>$recursos, 'r'=>$row, 'json_r'=>$json_r, 'export'=>FALSE ), TRUE);
        doPDF($vw, 'Reporte-'.$row->nombre_ot, NULL, FALSE);
        break;
    }
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

  public function getObservaciones($idOT)
  {
    $this->load->database('ot');
    $this->load->model('miscelanio_db', 'misc');
    $observaciones = $this->misc->getObservaciones($idOT);
    $this->load->helper('xlsx');
    genObservaciones($observaciones);
  }

  public function getConsolidadosTemp($idOT)
  {
    $this->load->model(array('condensado_db'=>'cond', 'reporte_db'=>'repo'));
    $reportes = $this->cond->get(NULL,$idOT);
    $this->load->view('miscelanios/consolidado/listado_consolidado', array('reportes'=>$reportes));
  }

  public function getConsolidados($idOT)
  {
    $this->load->model(array('condensado_db'=>'cond', 'ot_db'=>'ot'));
    $reportes = $this->cond->get(NULL,$idOT);

    $this->load->helper('xlsx');
    $writer = getWriter();
    $writer->openToBrowser('ConsolidadoOrden.xlsx');
    $style = getStyleFont(0, 128, 255);
    $headers  = array('Orden','Frente','fecha','Item','Descripción','UND','Asociado','Cant del Frente', 'Cantidad asociada','Valor','Observación');
    $writer->addRowWithStyle( $headers, $style );

    foreach ($reportes->result() as $key => $rd) {
      if ( isset($rd->condensado) ){
        $data = json_decode($rd->condensado);
        if (isset($data->frentes)){
          #recorrido de frentes y de items
          foreach ($data->frentes as $key => $frente){
            foreach ($frente->items as $key => $it){
              $row = array();
              $row["nombre_ot"] = $it->nombre_ot;
              $row["nombre_frente"] = $it->nombre_frente;
              $row["fecha_reporte"] = $it->fecha_reporte;
              $row["itemc_item"] = $it->itemc_item;
              $row["descripcion"] = $it->descripcion;
              $row["unidad"] = $it->unidad;
              $row["item_asociado"] = $it->item_asociado." (".$it->descripcion_asociada.")";
              $row["total"] = $it->total*1;
              $row["cantidad_asociada"] = $it->cantidad_asociada*1;
              $row["valor"] = $it->valor*1;
              $row["observacion"] = $it->alerta?"La cantidad ingresada supera los valores maximos reportados del item en este frente.":"";
              $writer->addRow($row);
            }
          } // Cierre for rows
        } // cierre if existe info frente
      } // cierre if existe condensado
    }// cierre de iteracion de reportes
    $writer->close();
  }

  # Informe Items PMO
  public function form_informe_items($value='')
  {
    $this->load->view('consultas/PMO/form_pmo');
  }
  public function informe_items()
  {
    $this->load->model('ot_db', 'ot');
    $bases = $this->input->post('bases');
    $rows = $this->ot->getPlaneacion(NULL, $bases);
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $path = './uploads/informePMO'.date("Ymd").'.xlsx';
    write_xlsx($rows->result_array(), $rows->list_fields(), $path);
    //genHojaCalculo($rows->result_array(), $rows->list_fields(), './uploads/informeFacturacion.xlsx');
    force_download($path, NULL, 'items OT y CO');
  }

  # =================================================================================
  public function resumenOt($idOT)
  {
    $this->load->model('ot_db', 'ot');
    $resumen = NULL;
		$frentes = $this->ot->getFrentesOT($idOT);
		if($frentes->num_rows() > 0){
			$resumen = $this->ot->resumenOT($idOT, TRUE);
		}else{
			$resumen = $this->ot->resumenOT($idOT);
		}
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ResumenOT.xls"');
    header('Cache-Control: max-age=0');
		$this->load->view('ot/table_resumen', array('items'=>$resumen, 'idOT'=>$idOT) );
  }

  # =================================================================================
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
}
