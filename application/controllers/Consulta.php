<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  public function index(){}

  # Valores de como se han reportado los items de un OT por el mes
  public function form_indicadores_ot()
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $html = $this->load->view('consultas/indicadores_ot/vista_consulta',array(), TRUE);
    $this->load->view(
      'consultas/form_consulta_mes',
      array( 'bases'=>$bases, 'vista_consulta'=>$html, 'link'=>site_url('consulta/get_ordenes_mes'), 'titulo_consulta'=>'Consulta de cantidades recursos de O.T. por día al mes: '  )
    );
  }

  public function get_ordenes_mes()
  {
    $post = json_decode( file_get_contents('php://input') );
    $post->fecha_i = date('Y-m-d', strtotime($post->year.'-'.$post->mes.'-01'));
		$dias = cal_days_in_month(CAL_GREGORIAN, $post->mes, $post->year);
		$post->fecha_f = date('Y-m-d',
			strtotime (
				'+'.($dias-1).' day',
				strtotime($post->fecha_i)
			)
		);
    $this->load->model('item_db');
    $ots = $this->item_db->get_ordenes_mes($post, TRUE);
    echo json_encode( $ots->result() );
  }

  public function get_indicadores_ot()
  {
    $post = json_decode( file_get_contents('php://input') );
    $post->fecha_i = date('Y-m-d', strtotime($post->year.'-'.$post->mes.'-01'));
		$post->dias = cal_days_in_month(CAL_GREGORIAN, $post->mes, $post->year);
		$post->fecha_f = date('Y-m-d',
			strtotime (
				'+'.($post->dias-1).' day',
				strtotime($post->fecha_i)
			)
		);
    $this->load->model('item_db');
    $ots = $this->item_db->getCantidadesDia($post);
    $cuerpo = $ots->result();
    $cabeceras = $ots->list_fields();
    echo json_encode( array( "cabeceras"=>$cabeceras, "cuerpo"=>$cuerpo ) );
  }

  #Vista de estados de reportes de una OT x mes
  public function form_estado_reportes()
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $html = $this->load->view('consultas/reportes_mes/vista_consulta',array(), TRUE);
    $this->load->view(
      'consultas/form_consulta_mes',
      array( 'bases'=>$bases, 'vista_consulta'=>$html, 'link'=>site_url('consulta/get_reportes_status'), 'titulo_consulta'=>'Consulta Estados de reportes: ' )
    );
  }

  public function get_reportes_status($value='')
  {
    $post = json_decode( file_get_contents('php://input') );
		$post->dias = cal_days_in_month(CAL_GREGORIAN, $post->mes, $post->year);
    $this->load->model('reporte_db','repo');
    $ots = $this->repo->getEstadosBy(NULL, $post);
    $cuerpo = $ots->result();
    $cabeceras = $ots->list_fields();
    echo json_encode( array( "cabeceras"=>$cabeceras, "cuerpo"=>$cuerpo ) );
  }

  # Consulta de informe de Excel PYCO y Equipos

  public function form_reporte_pyco()
  {
    $this->load->database('ot');
    $bases = $this->db->get('base');
    $html = $this->load->view('consultas/equipos_mes/vista_consulta',array(), TRUE);
    $links = array(
      array('link'=>site_url('reporteequipomes/reporteMes'), 'label'=>'Consolidado'),
      array('link'=>site_url('reporteequipomes/reporteMesPyco'), 'label'=>'pyco')
    );
    $this->load->view(
      'consultas/equipos_mes/form_reporte_mes',
      array( 'bases'=>$bases, 'vista_consulta'=>$html, 'link'=>$links, 'titulo_consulta'=>'Consulta de equipos mensual: '  )
    );
  }

  public function get_informe_cierre_OT($nombre_ot=NULL, $co=NULL)
  {
    // consultar:
    $this->load->model(array('ot_db'=>'ot', 'tarea_db'=>'tar'));
    $ots = $this->ot->getInfoGeneral($nombre_ot, $co);
    $myots = array();
    foreach ($ots->result_array() as $k => $ot) {
      $tareas = $this->tar->getTareasByOT($ot['idOT']);
      $row = 1;
      $rows = $tareas->num_rows();
      foreach ($tareas->result() as $i => $tr) {
        $ot['resumen_tareas'] .= $tr->nombre_tarea.' del '.$tr->fecha_inicio.' al '.$tr->fecha_fin.' por valor de $'.number_format($tr->valor_recursos,2);
        if($row <  $rows ){
          $ot['resumen_tareas'] .= ' - ';
        }
        $row++;
      }
      $ot['fecha_inicio_plan'] = 25569 + ( strtotime( $ot['fecha_inicio_plan'] ) / 86400 );
      $ot['fecha_fin_plan'] = 25569 + ( strtotime( $ot['fecha_fin_plan'] ) / 86400 );
      $ot['fecha_inicio'] = 25569 + ( strtotime( $ot['fecha_inicio'] ) / 86400 );
      $ot['fecha_fin'] = 25569 + ( strtotime( $ot['fecha_fin'] ) / 86400 );
      $ot['valor_costo_directo'] = number_format($ot['valor_costo_directo'],2);
      array_push($myots, $ot);
    }
    // generar:
    $this->load->helper('xlsxwriter');
    $this->load->helper('download');
    xlsx($myots, $ots->list_fields(), './uploads/InformeCierre.xlsx','hoja1',NULL);
    force_download('./uploads/InformeCierre.xlsx',NULL);
  }

}
