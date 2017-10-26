<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricoFacturacion extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set("America/Bogota");
  }

  function index()
  {

  }

  public function cargue_historico($value='')
  {
    $this->load->view('miscelanios/cargue_historico/form_upload');
  }

  public function upload_cague_historico($value='')
  {
    $this->crear_directorio('./uploads/cargue_historico');
    $config['upload_path'] = './uploads/cargue_historico/';
		$config['allowed_types'] = 'xlsx';
		$config['file_name'] = 'historico_fact'.$this->input->post('nombre_archivo');

    $this->load->library("upload",$config);
    $ret = new StdClass();
		if($this->upload->do_upload("file")){
			$info = $this->upload->data();
      $ret->return = '/uploads/cargue_historico/'.$info['file_name'];
      $ret->msj = 'Cargue exitoso';
      $ret->success = TRUE;
		}else{
      $ret->msj = 'Error al cargar: '.$this->upload->display_errors();
      $ret->success = FALSE;
		}

    echo json_encode($ret);
  }
  // Metodo para lectura del archivo
  public function read_data_from()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->helper('xlsx');
    $sheets = readXlsx(FCPATH.$post->path,NULL);
    $i=0;
    foreach ($sheets as $key => $sheet) {
      $i++;
      $j=0;
      foreach ($sheet->getRowIterator() as $row) {
        $this->setRowSabana( $row );
        $j++;
        if($j > 100000)
          break;
      }
    }
  }
  // TEST
  public function read_data_from2()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->helper('xlsx');
    $reader = readXlsx(FCPATH."uploads/cargue_historico/historico_fact.xlsx", NULL, NULL);
    $i=0;
    $return = new stdClass();
    $return->status = TRUE;
    $return->success = array(); $return->failed = array();
    foreach ($reader->getSheetIterator() as $key => $sheet) {
      $i++;
      $j = 0;
      foreach ($sheet->getRowIterator() as $row) {
        if($j<=0){
          $j++;
        }else{
          $return = $this->setRowSabana( $row, $return, $j );
          $j++;
          if($j > 100000)
            break;
        }
      }
    }
    $reader->close();
    echo json_encode($return);
  }
  // lestura de fila
  public function setRowSabana($row, $return=NULL, $fila=NULL)
  {
    $this->load->model('HistoricoFacturacion_db', 'fac');
    $headers = $this->fac->fieldsMetaData();
    $data = array();
    foreach ($headers as $key => $field) {
      if ($key!=0) {
        if ($this->validarTipos($row[$key-1], $field->type)) {
          if($field->name == 'fecha_reporte')
            $data[$key-1] = $row[$key-1]->format('Y-m-d');
          else
            $data[$key-1] = $row[$key-1];
        }else {
          $data[$key-1] = "Error en fila: ".$fila." del archivo, campo ".$field->name." con valor '".$row[$key-1]."' es incorrecto";
          $return->status = FALSE;
        }
      }
    }
    if($return->status){
      array_push($return->success, $data);
    }else{
      array_push($return->failed, $data);
    }
    return $return;
    //$this->fac->setRowSabana($data);
  }
  // crea un directorio no existente
  private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }
  }
  // Valida la estructura de datos de información
  public function validarTipos($dato, $tipo)
  {
    $return = FALSE;
    switch ($tipo) {
      case 'int':
        $ret = is_numeric($dato);
        break;
      case 'double':
        $ret = is_float($dato)||is_numeric($dato)?TRUE:FALSE;
        break;
      case 'decimal':
        $ret = is_float($dato)||is_numeric($dato)?TRUE:FALSE;
        break;
      case 'date':
        if (is_object($dato)) {
          $ret = checkdate( $dato->format('m'), $dato->format('d'), $dato->format('Y') );
        }else{
          $ret = FALSE;
        }
        break;
      case 'varchar':
        $ret = is_string($dato) || is_numeric($dato)? TRUE: FALSE;
        break;
      default:
        $ret = TRUE;
        break;
    }
    return $ret;
  }

}
