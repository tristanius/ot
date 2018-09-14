<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricoReportes extends CI_Controller{

  private $path = '/uploads/reportes/cargue/';

  public function __construct() {
    parent::__construct();
  }

  function index(){}

  public function form(){
    $this->crear_directorio('./uploads/reportes');
    $this->crear_directorio('./uploads/reportes/cargue');
    $this->load->view('reportes/cargue/form');
  }

  public function upload_file(){
    $config['upload_path'] = '.'.$path;
    $config['allowed_types'] = 'xlsx';
    $config['file_name'] = 'Cargue'.date('YmdHis');
    $ret = new stdClass();
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('myfile') ) {
      $ret->error = $this->upload->display_errors();
      $ret->status = FALSE;
    }else{
      $upload_data = $this->upload->data();
      $ret->msj = 'Archivo cargado con exito';
      $ret->file_path = '.' . $this->path . $upload_data['file_name'];
      $ret->status = TRUE;
    }
    echo json_encode($ret);
  }

  public function leerArchivo( ){
    $post = json_decode('php://input');

    $this->load->helper('xlsx');
    $reader = getReader();
    $reader->open( '.'.$post->file_path );
    $ret = new stdClass();
    foreach ($reader->getSheetIterator() as $key => $sheet) {
      $fila = 0;
      $this->load->model( array(  'historicoreportes_db'=>'hist', 'ot_db'=>'ot',  'reporte_db'=>'repo' ) );
      foreach ($sheet->getRowIterator() as $key => $row) {
        if($fila != 0){

        }
        $fila++;
        # ( strtolower($row[0]) == 'contrato' && strtolower($row[1]) == 'orden' && strtolower($row[2]) == 'subcontratista' )
      }
    }
    echo json_encode($ret);
  }

  private function insertarFila( $fila )
  {
    $ot = $this->getOT( $fila[1] );
    if( isset($ot) ){
      $rd = $this->getReporte($ot->idOT, $fila[2]);
      if( !isset($rd) ){
        # 1.1 Crear reporte generico
        $rd = $this->crearReporte( $ot->idOT, $fila[2] );
      }
      $rec = $this->getDataObject();
      # 1. Crear objeto de insercción
      # 2. Validar items en la OT
      $rec->itemf_iditemf = $this->validarItemf( 'itemf_codigo', $rec->itemf_codigo );
      # 3. Intentar insertar el recurso reportado
      $rec->idreporte_diario = $rec->setRecursoReporte( $rec );
      # 4. Insertar el avance de obra relacionado
      $rec->setAvanceReporte( $rec->idreporte_diario, $rec );
      # 5. Registrar respuesta
      $fila['resultado'] = '';
    }
    return $fila;
  }

  public function FunctionName($value='')
  {
    $rec = new stdClass();
    return $rec;
  }

  private function getOT( $no_ot ){
  }

  private function getReporte( $idOT, $fecha ){
  }

  public function validarItemf( $campo, $item ){
  }

  private function crearReporte( $idOT, $fecha ){
  }

  public function setRecursoReporte( $rec ){
  }
  public function setAvanceReporte( $rec ){
  }

  # crear un subdirectorio
  private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

}
