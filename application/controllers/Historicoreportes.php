<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historicoreportes extends CI_Controller{

  private $path = '/uploads/reportes/cargue/';

  public function __construct() {
    parent::__construct();
    date_default_timezone_set('America/Bogota');
  }

  function index(){}

  public function form(){
    $this->crear_directorio('./uploads/reportes');
    $this->crear_directorio('./uploads/reportes/cargue');
    $this->crear_directorio('./downloads/reportes');
    $this->crear_directorio('./downloads/reportes/cargue');
    $this->load->view('reportes/cargue/form');
  }

  public function upload_file(){
    $config['upload_path'] = '.'.$this->path;
    $config['allowed_types'] = 'xlsx';
    $config['file_name'] = 'Cargue'.date('YmdHis');
    $ret = new stdClass();
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('file') ) {
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

  public function leer_archivo( ){
    $post = json_decode( file_get_contents('php://input') );
    $this->load->helper('xlsx');
    $reader = getReader();
    $ret = new stdClass();
    try {
      $reader->open( FCPATH.$post->file_path );
      $this->load->model( array(  'reporte_db'=>'repo', 'recurso_reporte_db'=>'recrepo') );
      $this->repo->init_transact();
      $ret->exitosos = 0;
      $ret->fallidos = 0;
      $ret->resultados = array();
      $ret->no_cargue =  $post->idcontrato."-".date('YmdHis');
      foreach ($reader->getSheetIterator() as $key => $sheet) {
        $fila = 0;
        foreach ($sheet->getRowIterator() as $key => $row) {
          if($fila != 0){
            $row = $this->insertarFila( $row, $post->idcontrato, $ret->exitosos, $ret->fallidos, $ret->no_cargue);
            array_push( $ret->resultados, $row );
            if ($row['status']) { $ret->exitosos++; }else{ $ret->fallidos++; }
          }else{
            array_push($row, 'resultado');
            array_push($row, 'status');
            $headers = $row;
          }
          $fila++;
        }
      }
      $ret->download = '/downloads/reportes/cargue'.date('YmdHis').'.xlsx';
      writeXlsx( $ret->resultados, $headers, '.'.$ret->download, 'Cargue masivo de reportes');
      if ( $ret->fallidos <= 0 ) {
        $ret->msj = 'Lectura correcta.';
        $ret->status = TRUE;
        $ret->end_status = $this->repo->end_transact();
      }else{
        $ret->msj = 'Algunos registros no han cargado, proceso anulado.';
        $ret->status = FALSE;
        $this->repo->rollback(); # validar
      }
    } catch ( Exception $e ) {
      $ret->msj = $e->getMessage();
      $ret->status = FALSE;
      $this->repo->rollback();
    }
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

  private function insertarFila( $fila, $idcontrato, $registros_exitosos, $registros_fallidos, $no_cargue ) {
    # 1. Crear objeto de insercción
    $rec = $this->getDataObject($fila, $no_cargue);
    # Si no regresa lo esperadpo reportear como fallo en informacion.
    if(!isset($rec)){
      $fila['resultado'] = 'Datos mal formados.';
      $fila['status'] = FALSE;
      return $fila;
    }
    $fila[2] = $rec->fecha_reporte;
    # 2 Validar OT
    $idOT = $this->getOT( $rec->nombre_ot, $idcontrato );
    if ($idOT != FALSE) {
      try {
        $rec->idOT  = $idOT;
        # 2.1 Validar items en la OT
        $iditemf = $this->getIditemf( $rec->idOT, $rec->itemf_codigo );
        if ($iditemf != FALSE) {
          $rec->itemf_iditemf = $iditemf;
          # 2.2 Validar si existe reporte, sino crear uno
          $rec->idreporte_diario =  $this->getReporte($rec->idOT, $rec->fecha_reporte );
          if ( isset($rec->idreporte_diario) ) {
            # 3. Intentar insertar el recurso reportado
            $rec->idrecurso_reporte_diario = $this->setRecursoReporte( $rec, $rec->idreporte_diario );
            # 4. Insertar el avance de obra relacionado
            $this->setAvanceReporte( $rec, $rec->idrecurso_reporte_diario );
            # 5. Registrar respuesta OK
            $fila['resultado'] = 'Campos registrados, verificalos.';
            $fila['status'] = TRUE;
          }
        }else {
          # 5. Registrar respuesta Error
          $fila['resultado'] = 'Codigo de item no encontrado';
          $fila['status'] = FALSE;
        }
      } catch (Exception $e) {
        $fila['resultado'] = 'Error: '.$e->getMessage();
        $fila['status'] = FALSE;
      }
    }else{
      # 5. Registrar respuest Error
      $fila['resultado'] = 'OT no encontrada';
      $fila['status'] = FALSE;
    }
    return $fila;
  }

  public function getDataObject($fila, $no_cargue){
    $rec = new stdClass();
    $rec->contratista =  $fila[0];
    $rec->nombre_ot = $fila[1];
    try {
      $fecha = $fila[2];
      $rec->fecha_reporte = $fecha->format('Y-m-d') != NULL?$fecha->format('Y-m-d'):$fecha;
    } catch (Exception $e) {
      return NULL;
    }
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
    $rec->no_cargue = $no_cargue;
    return $rec;
  }

  private function getOT( $nombre_ot, $idcontrato ){
    $this->load->model('ot_db');
    $rows = $this->ot_db->getBy( array( 'OT.nombre_ot'=>$nombre_ot, 'OT.idcontrato'=>$idcontrato ) );
    if( $rows->num_rows() > 0 ){
      return $rows->row()->idOT;
    }
    return FALSE;
  }

  private function getReporte( $idOT, $fecha_reporte ){
    $rows = $this->repo->getWhere( array('rd.OT_idOT'=>$idOT, 'rd.fecha_reporte'=>$fecha_reporte) );
    if( $rows->num_rows() > 0 ){
      return $rows->row()->idreporte_diario;
    }else{
      $reporte = new stdClass();
      $reporte->idOT = $idOT;
      $reporte->fecha_reporte = $fecha_reporte;
      $reporte->festivo = FALSE;
      $w = date('w', strtotime($reporte->fecha_reporte) );
      if ( $w == 0) {
        $reporte->festivo = TRUE;
      }
      return $this->repo->add($reporte);
    }
    return NULL;
  }

  private function getIditemf( $idOT, $codigo ){
    $this->load->model('tarea_db', 'tar');
    $rows = $this->tar->getItemOTSUM( $idOT, $codigo );
    if($rows->num_rows() > 0){
      return $rows->row()->idOT;
    }
    return FALSE;
  }

  private function setRecursoReporte( $rec, $idreporte ){
    return $this->recrepo->addRecursoRepo($rec, $idreporte);
  }

  private function setAvanceReporte( $rec, $idrecurso_reporte_diario ){
    return $this->recrepo->addAvance( $rec, $idrecurso_reporte_diario );
  }

  # crear un subdirectorio
  private function crear_directorio($carpeta){
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

}
