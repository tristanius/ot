<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricoReportes extends CI_Controller{

  private $path = '/uploads/reportes/cargue/';

  public function __construct() {
    parent::__construct();
    date_default_timezone_set('America/Bogota');
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
      $ret->msj = $this->upload->display_errors();
      $ret->status = FALSE;
    }else{
      $upload_data = $this->upload->data();
      $ret->msj = 'Archivo cargado con exito';
      $ret->file_path = $this->path . $upload_data['file_name'];
      $ret->status = TRUE;
    }
    echo json_encode($ret);
  }

  public function leerArchivo( ){
    $post = json_decode('php://input');
    $this->load->helper('xlsx');
    $reader = getReader();
    $reader->open( FCPATH.$post->file_path );
    $ret = new stdClass();
    $this->load->model( array(  'reporte_db'=>'repo', 'recurso_reporte_db'=>'recrepo') );
    $this->repo->init_transact();
    $ret->exitosos = 0;
    $ret->fallidos = 0;
    foreach ($reader->getSheetIterator() as $key => $sheet) {
      $fila = 0;
      foreach ($sheet->getRowIterator() as $key => $row) {
        if($fila != 0){
          $this->insertarFila( $row, $post->idcontrato, $ret->exitosos, $ret->fallidos );
        }
        $fila++;
        # ( strtolower($row[0]) == 'contrato' && strtolower($row[1]) == 'orden' && strtolower($row[2]) == 'subcontratista' )
      }
    }
    if ( $ret->fallidos <= 0 ) {
      $ret->msj = 'Lectura correcta.';
      $ret->status = TRUE;
    }else{
      $ret->msj = 'Algunos registros no han cargado';
      $ret->status = FALSE;
    }
    $this->repo->rollback();
    echo json_encode($ret);
  }

  public function previsualizar() { # $path='/uploads/reportes/cargue/prueba.xlsx'
    $this->load->helper('xlsx');
    $post = json_decode('php://input');
    $reader = getReader();
    $reader->open( FCPATH.$post->file_path );
    $data = array();
    foreach ($reader->getSheetIterator() as $sheet) {
      foreach ($sheet->getRowIterator() as $row) {
        array_push($data, $row);
      }
    }
    return $data;
  }

  private function insertarFila( $fila )
  {
    # 1. Crear objeto de insercción
    $rec = $this->getDataObject($fila);
    # 2 Validar OT
    $idOT = $this->getOT( $rec->nombre_ot );
    if ($idOT != FALSE) {
      $rec->idOT  = $idOT;
      # 2.1 Validar items en la OT
      $iditemf = $this->getIditemf( 'itemf_codigo', $rec->itemf_codigo );
      if ($iditemf != FALSE) {
        $rec->itemf_iditemf = $iditemf;
        # 2.2 Validar si existe reporte, sino crear uno
        $rec->idreporte_diario =  $this->getReporte($rec->idOT, $rec->fecha_reporte);
        if ( isset($rec->idreporte_diario) ) {
          # 3. Intentar insertar el recurso reportado
          $rec->idrecurso_reporte_diario = $rec->setRecursoReporte( $rec );
          # 4. Insertar el avance de obra relacionado
          $rec->setAvanceReporte( $rec, $rec->idrecurso_reporte_diario );
          # 5. Registrar respuesta OK
          $fila['resultado'] = 'Campos registrados, verificalos.';
          $registros_exitosos++;
        }
      }else {
        # 5. Registrar respuesta Error
        $fila['resultado'] = 'Codigo de item no encontrado';
        $registros_fallidos++;
      }
    }
    else{
      # 5. Registrar respuest Error
      $fila['resultado'] = 'OT no encontrada';
      $registros_fallidos++;
    }
    return $fila;
  }

  public function getDataObject($fila){
    $rec = new stdClass();
    $rec->contratista =  $fila[0];
    $rec->nombre_ot = $fila[1];
    $rec->fecha_reporte = isset( $fila[2]->date )? $fila[2]->date : $fila[2];
    $rec->festivo = $fila[3];
    $rec->itemf_codigo = $fila[4];
    $rec->descripcion = isset($fila[5] )? $fila[5]: NULL;
    $rec->unidad = isset($fila[6] )? $fila[6]: NULL;
    $rec->elemento = isset($fila[7] )? $fila[7]: NULL;
    $rec->ubicacion = isset($fila[8] )? $fila[8]: NULL;
    $rec->margen = isset($fila[9] )? $fila[9]: NULL;
    $rec->abscisa_ini = isset($fila[10] )? $fila[10]: NULL;
    $rec->abscisa_fin = isset($fila[11] )? $fila[11]: NULL;
    $rec->MH_inicio = isset($fila[12] )? $fila[12]: NULL;
    $rec->MH_fin = isset($fila[13] )? $fila[13]: NULL;
    $rec->longitud = isset($fila[14] )? $fila[14]: NULL;
    $rec->ancho = isset($fila[15] )? $fila[15]: NULL;
    $rec->alto = isset($fila[16] )? $fila[16]: NULL;
    $rec->cant_elementos = isset($fila[17] )? $fila[17]: NULL;
    $rec->diametro_acero = isset($fila[18] )? $fila[18]: NULL;
    $rec->cant_varillas = isset($fila[19] )? $fila[19]: NULL;
    $rec->peso_und = isset($fila[20] )? $fila[20]: NULL;
    $rec->cantidad = isset($fila[21] )? $fila[21]: NULL;
    $rec->observacion = isset($fila[22] )? $fila[22]: NULL;
    $rec->tipo_ejecucion = isset($fila[23] )? $fila[23]: NULL;
    $rec->a_cargo = isset($fila[24] )? $fila[24]: NULL;
    $rec->calidad = isset($fila[25] )? $fila[25]: NULL;
    return $rec;
  }

  private function getOT( $nombre_ot, $idcontrato ){
    $this->load->model('ot_db');
    $rows = $this->ot_db->getBy( array( 'nombre_ot'=>$nombre_ot, 'idcontrato'=>$idcontrato ) );
    if( $rows->num_rows() > 0 ){
      return $rows->row()->idOT;
    }
    return FALSE;
  }

  private function getReporte( $idOT, $fecha_reporte ){
    $rows = $this->repo->getBy( array('rd.OT_idOT'=>$idOT, 'rd.fecha_reporte'=>$fecha_reporte) );
    if( $rows->num_rows() > 0 ){
      return $rows->row()->idreporte_diario;
    }else{
      $reporte = new stdClass();
      $reporte->idOT = $idOT;
      $reporte->fecha_reporte = $fecha_reporte;
      $reporte->festivo = FALSE;
      $w = date('w', strtotime($repote->fecha_reporte) );
      if ( $w == 0) {
        $reporte->festivo = TRUE;
      }
      return $this->repo->add($reporte);
    }
    return NULL;
  }

  public function getIditemf( $campo, $item ){
    $this->load->model('tarea_db', 'tar');
    $rows = $this->tar->getItemOTSUM($idOT,$codigo);
    if($rows->num_rows() > 0){
      return $rows->row()->idOT;
    }
    return FALSE;
  }

  public function setRecursoReporte( $rec ){
    return $this->recrepo->addRecursoRepo($rec);
  }

  public function setAvanceReporte( $rec, $idrecurso_reporte_diario ){
    return $this->recrepo->addAvance( $rec, $idrecurso_reporte_diario );
  }

  # crear un subdirectorio
  private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

}
