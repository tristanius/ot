<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportepersonal extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index(){ }
  #===========================================================================================================
  # add
  public function tiempolaborado($idOT, $idReporte)
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('Reportepersonal_db', 'repoper');
    $rows = $this->repoper->getBy($idOT, $idReporte);
    $rowsPersonas = $this->repoper->getRegistroDia($idOT,$idReporte);
    $rowOT = $this->repoper->getDatosOT($idOT,$idReporte);
    $this->load->view('miscelanios/reportepersonal/reportepersonal',
      array('elpersonal'=>$rowsPersonas,'laOT'=>$rowOT,'nodownload'=>false)
    );
  }

  public function form_tiempoLaboradoGeneral()
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $this->load->view('miscelanios/reportepersonal/form_tiempoLaborado', array("bases"=>$bases));
  }

  public function tiempoLaboradoGeneral()
  {
    $ini = $this->input->post("fecha_tl_ini");
    $fin = $this->input->post("fecha_tl_fin");
    $base = $this->input->post("consultatiempoBase");
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('reportepersonal_db', 'rper');
    if($base == "all"){$base = NULL;}
    $rows = $this->rper->tiempoLaboradoGeneral($ini, $fin, $base);
    xlsx($rows->result_array(), $rows->list_fields(), './uploads/informeTL'.$mes.$year.'.xlsx');
    force_download('./uploads/informeTL'.$mes.$year.'.xlsx',NULL);
    //$this->load->view('miscelanios/excelGenerico', array("rows"=>$rows, "nombre"=>$base."Informetiempos".$year.$mes));
  }
  public function reporteTiemposNomina()
  {
    $ini = $this->input->post("fecha_inicio");
    $fin = $this->input->post("fecha_hasta");
    $fin = $this->input->post("base");
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    $this->load->model('reportepersonal_db', 'rper');
    $rows = $this->rper->tiempoLaboradoGeneral($ini, $fin, $base);
    xlsx($rows->result_array(), $rows->list_fields(), './uploads/tiemposReportados'.date('Ymd').'.xlsx');
    force_download('./uploads/tiemposReportados'.date('Ymd').'.xlsx',NULL);
    //$this->load->view('miscelanios/excelGenerico', array("rows"=>$rows, "nombre"=>$base."Informetiempos".$year.$mes));
  }

  #=========================================================================================
  # Validar horas extra y viaticos

  public function toNomina($b=NULL)
  {
    if ($b==1 || $b==0) {
      $post = json_decode(file_get_contents("php://input"));
      $this->load->model('reportepersonal_db', 'rper');
      $args = array();
      if(isset($post->base) && $post->base != ''){ $args['base'] = $post->base; }
      if(isset($post->orden) && $post->orden != ''){ $args['orden'] = trim( $post->orden ); }
      if(isset($post->identificacion) && $post->identificacion != ''){ $args['identificacion'] = $post->identificacion; }
      $bool = $b?1:0;
      $this->rper->personalNomina($post->fecha_inicio, $post->fecha_hasta, $args, $bool, $post->idusuario.'-'.date('Y-m-d H:i'));
      echo "success";
    }else{
      echo 'failed';
    }
  }

  public function setValidacion($b=0)
  {
    if ($b==1 || $b==0) {
      $bool = $b?1:0;
      $post = json_decode(file_get_contents("php://input"));
      $this->load->model('reportepersonal_db', 'rper');
      $args = array();
      if(isset($post->base) && $post->base != ''){ $args['base'] = $post->base; }
      if(isset($post->orden) && $post->orden != ''){ $args['orden'] = trim( $post->orden ); }
      if(isset($post->identificacion) && $post->identificacion != ''){ $args['identificacion'] = $post->identificacion; }
      $this->rper->personalValidation($post->fecha_inicio, $post->fecha_hasta, $args, $bool, $post->idusuario.'-'.date('Y-m-d H:i'));
      echo "success";
    }else{
      echo 'failed';
    }
  }

  #CARGUE PERSONAL PARA ESTADO EN NOMINA
  public function formCargueValidacionHorario()
  {
    $this->load->view('asociaciones/nomina/cargueAsociacion');
  }

  public function uploadValidacionHorario($subcarpeta='nomina')
  {
    $carpeta = "/".$subcarpeta."/".date("dmY")."/";
    $dir = "./uploads".$carpeta;
    $this->crear_directorio("./uploads/".$subcarpeta."/");
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    //$this->recorrerFilasMaestro($subcarpeta, $carpeta.$dataup['file_name']);
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->leerValidacionHorario($carpeta.$dataup['file_name']);
    }else{
      echo  $this->upload->display_errors();
    }
  }

  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

  public function leerValidacionHorario($ruta="nomina/22062017/cargue.xlsx"){
    $rows = $this->leerExcel($ruta);
    $noValid = array();
    $fastFeed = '';
    $this->load->model('reportepersonal_db', 'rper');
    $this->rper->init_transact();
    foreach ($rows as $key => $fila){
      if ( strtolower( $fila['A'] ) != 'orden') {
        $orden = $fila['A'];
        $base = $fila['B'];
        $fecha = getDateExcel($fila['C']);
        $cc = $fila['D'];
        $affect = $this->rper->personalNominaUnoAUno($fecha, $orden, $cc, TRUE, $this->input->post('usuario').date('Y-m-d h:i'));
        if ($affect>0) {
          $fila['C'] = $fecha." Asociada";
          $fila['F']="Registro asociado";
        }else {
          $fila['C'] = $fecha." NO Asociada";
          $fila['F']="No asociado";
        }
      }
      array_push($noValid, $fila);
    }
    if($this->rper->end_transact()){
      $html = $this->load->view('miscelanios/reporteCargaXLS',array("filas"=>$noValid),TRUE);
      $this->load->view('miscelanios/resultadoUpdateMaestro', array("html"=>$html));
    }else{
      echo "Fallo al insertar registros";
    }
  }

  # Llama al helper para leer un xlsx y devuelve una coleccion PHP
  private function leerExcel($ruta)
  {
    $this->load->helper('excel');
    return readExcel($ruta)->toArray(null,true,true,true);
  }

  #=========================================================================================
  # dias laborados del mes

  public function form_reporteMes(){
    $this->load->database('ot');
    $rows = $this->db->get('base');
    $this->load->view("miscelanios/reportepersonal/form_reportemespersona", array("bases"=>$rows));
  }

  public function reporteMes($mes, $year, $laBase=NULL)
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('Reportepersonal_db', 'rpermes');
    $rows = $this->rpermes->getBy($mes, $year, $laBase);
    if($rows->num_rows() > 0){
      echo 'invalid';
    }else{
      $rowsPersonal = $this->rpermes->getPerMes($mes, $year,$laBase);
      //echo $this->db->last_query();
      $ds = cal_days_in_month(CAL_GREGORIAN,$mes,$year);
      $this->load->view('miscelanios/reportepersonal/reportemespersona',
        array('lashoras'=>$rowsPersonal,'nodownload'=>false,'inicio'=>$year.'-'.$mes.'-01','final'=>$year.'-'.$mes.'-'.$ds,'labase'=>$laBase)
      );
    }
  }
}
