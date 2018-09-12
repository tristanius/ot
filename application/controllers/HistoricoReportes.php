<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricoReportes extends CI_Controller{

  public function __construct() {
    parent::__construct();
  }

  function index(){}

  public function form(){
    $this->load->view('reportes/cargue/form');
  }

  public function upload_file(){

  }

  private function leerArchivo( $path ){
  }

  private function crearReporte( $fecha, $idOT ){
  }

  public function setRecursoReporte( $idreporte ){
  }

  # crear un subdirectorio
  private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

}
