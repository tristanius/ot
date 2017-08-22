<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MigracionReporte extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index()
  {

  }
  #==============================================================================#
  # MIGRACION DE REPORTES ENTEROS #
  #==============================================================================#
  public function cargueReportes($value='')
  {
    # code...
  }
  #==============================================================================#
  # MIGRACION DE RECURSOS INTERNOS A REPORTES DE OTRA OT #
  #==============================================================================#
  public function formRecursosReporte($value='')
  {
    $this->load->view('asociaciones\tranferenciaRecursos\form_tranferir_recursos');
  }
  public function cargueMigracionRecursos($value='')
  {
    $this->load->view('asociaciones\tranferenciaRecursos\cargueMigracionRecursos');
  }

  public function uploadRecursosreporte($value='')
  {
    $this->crear_directorio("./uploads/migracionrecursos/");
    $config['upload_path'] = './uploads/migracionrecursos/';
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $config['file_name'] = ''.date('Ymd');
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('cargue')){
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
    }else{
      $data = $this->upload->data();
      $data = $this->leerExcel('./uploads/migracionrecursos/'.$data['file_name']);
      $this->validarMigracion($data);
    }
  }

  private function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

  public function test($file='20170822.xlsx')
  {
    $data = $this->leerExcel('./uploads/migracionrecursos/'.$file);
    $this->validarMigracion($data);
  }

  private function leerExcel($ruta)
  {
    $this->load->helper('excel');
    return leerExcel($ruta)->toArray(null,true,true,true);
  }

  private function validarMigracion($data)
  {
    $this->load->model('MigracionReporte_db', 'mrepo');
    $this->mrepo->init_transact();
    $response = array();
    foreach ($data as $key => $row) {
      // Verificacion de OT destino
      $ots = $this->mrepo->getOT($row['B']);
      if ( $ots->num_rows() > 0 ) {
        $ot = $ots->row();
        // Validacion del reporte origen
        $repo_origen = $this->mrepo->getReporte($row['A'], $row['C']);
        if ($repo_origen->num_rows() > 0) {
          // Validacion  de reporte destino
          $repo_destino = $this->mrepo->getReporte($ot->nombre_ot, $row['C']);
          $rd = NULL;
          if ($repo_destino->num_rows() > 0) {
            $rd = $repo_destino->row();
          }else {
            $this->mrepo->crearReporteGenerico($ot->idOT, $repo_origen->row());
            $rd = $this->mrepo->getReporte($ot->nombre_ot, $row['C'])->row();
          }
          // movimiento de recurso
          $row['J'] = $this->moverRecursoReporte($row, $ot, $repo_origen->row(), $rd);
        }else{
          $row['J'] = $row['C'].' - Reporte origen no existente';
        }
      }else {
        $row['J'] = $row['B'].' - OT No existe: ';
      }
      array_push($response, $row);
    }
    $this->mrepo->end_transact();
    echo json_encode($response);
  }

  private function moverRecursoReporte($row, $ot, $rd_ant, $rd)
  {
    $rec = $this->getMoverRecursoReporte($row, $ot, $rd_ant, $rd);
    if( isset($rec) && $rec != NULL && $rec->num_rows() >0 ){
      $r = $rec->row();
      $this->mrepo->moverRecurso($r->idrecurso_reporte_diario, $rd->idreporte_diario);
      return 'recurso transferido';
    }
    return 'imposible transferir recurso';
  }
  private function getMoverRecursoReporte($row, $ot, $rd_ant, $rd)
  {
    if ($row['D']=='persona'){
      return $this->mrepo->getRecurso($rd_ant->OT_idOT, $rd_ant->fecha_reporte, 'persona_identificacion', $row['F']);
    }elseif ($row['D']=='equipo'){
      $eqs = $this->mrepo->getEquipo($row['H']);
      $eq = $eqs->row();
      return ($eqs->num_rows()>0)?$this->mrepo->getRecurso($rd_ant->OT_idOT, $rd_ant->fecha_reporte, 'equipo_idequipo', $eq->idequipo): NULL;
    }
  }
}
