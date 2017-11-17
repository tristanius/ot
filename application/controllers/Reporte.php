<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index(){ }
  #===========================================================================================================
  # add
  public function addvalid($idOT, $fecha)
  {
    $date1=date_create($fecha);
    $date2=date_create(date('Y-m-d H:i:s'));
    $diff=$date1->diff($date2);
    if($diff->y == 0 && $diff->m == 0 && $diff->d < 10){
      if( date( 'Y-m-d', strtotime($fecha) ) <= date( 'Y-m-d', strtotime('2017-11-10') )  ) {
        echo 'toolong';
      }else{
        $post = json_decode( file_get_contents("php://input") );
        $this->load->model('reporte_db', 'repo');
        $rows = $this->repo->getBy($idOT, $fecha);
        if($rows->num_rows() > 0){
          echo 'invalid';
        }else{
          echo 'valid';
        }
      }
    }else {
      echo "toolong";
    }
  }
  # form add reporte
  public function add($idOT, $fecha){
    $this->load->model('Ot_db', 'otdb');
    $ot = $this->otdb->getData($idOT);
    $this->load->model('tarea_db', 'tarea');
    $item_equipos = $this->tarea->getTareasItemsResumenBy($idOT,3);
    $this->load->model('miscelanio_db', 'misc');
    $estados = $this->misc->getDataEstados()->result();

    //obtener unidades de negocio
    $this->load->model('equipo_db', 'equ');
    $un_equipos = $this->equ->getResumenUN();

    $dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $diasemana = $dias[ date( "w", strtotime($fecha) ) ];

    $this->load->view('reportes/add/add',
		array(
				'ot'=>$ot->row(),
				'fecha'=>$fecha,
				'item_equipos'=>$item_equipos->result(),
				'un_equipos'=>$un_equipos,
				'estados'=>$estados,
        'diasemana'=>$diasemana,
        'estados_labor'=>$this->misc->getEstadosLabor()->result()
			)
		);
  }
  # insetar el reporte
  public function insert(){
    $post = json_decode( file_get_contents("php://input") );

    $validReporte = $this->validarRecursos("retornable", $post);
    if ($validReporte->succ) {
      $info = $post->info;
      $this->load->model('reporte_db', 'repo');
      $rows = $this->repo->getBy($post->info->idOT, $post->info->fecha_reporte);
      if($rows->num_rows() == 0){
        $recusos = $post->recursos;
        $this->repo->init_transact();
        // Insertamos el reporte y devolvemos el ID
        $idrepo = $this->repo->add($post->info, $post->log->nombre_usuario);
        $this->load->helper('log');
        if (isset($post->log)) {	addLog($post->log->idusuario, $post->log->nombre_usuario, $idrepo, 'reporte_diario', 'reporte_diario '.$post->info->fecha_reporte." de ".$post->info->nombre_ot.' creado', date('Y-m-d H:i:s') );	}
        //Recorremos los arregos de recursos
        $this->insertarRecursoRep($post->recursos->actividades, $idrepo);
        $this->insertarRecursoRep($post->recursos->personal, $idrepo);
        $this->insertarRecursoRep($post->recursos->equipos, $idrepo);
        $validProcc = $this->repo->end_transact();
        if($validProcc != FALSE){
          $response = new stdClass();
          $response->success = 'success';
          $response->msj = 'El reporte ha sido guardado correctamente';
          $response->idreporte_diario = $idrepo;

          $var = $this->getRecursoData($idrepo);
          $response->personal = $var->personal;
          $response->equipos = $var->equipos;
          $response->actividades = $var->actividades;
          echo json_encode($response);
        }else{
          show_404();
        }
      }
    }else{
      $response = new stdClass();
      $response->success = 'unsuccess';
      $response->msj = 'Los recursos deben ser validados';
      $response->personal = $validReporte->recursos->personal;
      $response->equipos = $validReporte->recursos->equipos;
      $response->actividades = $validReporte->recursos->actividades;
      echo json_encode($response);
    }
  }
  public function insertarRecursoRep($list, $idr){
    foreach ($list as $key => $value) {
      $this->repo->addRecursoRepo($value, $idr);
    }
  }
  #===========================================================================================================
  # Validaciones para guardar el reporte

  # valida si un Recurso ya esta registrado en una fecha dada, TRUE si se puede insertar y FALSE si ya existe en esa fecha
  public function validarRecurso($fecha, $val, $conjunto, $idOT)
  {
    $identificacion = ( $conjunto == "equipos" )? $val->codigo_siesa: $val->identificacion;
    $val->valid = TRUE;
    $rows = array();
    /*
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    Corregir: lista de excepciones no debe ser exluyente de coincidencia de reportes.
    Corregir: la cantidad del item a validar se debe validar no en este metodo sino en el de nivel superior (REVISAR PRIMERO)
    Corregir: Optimizar en funcion de rendimiento y no reproceso.
    */
    if ( !$this->exceptionValidarRecurso($val) ) { // SI NO ESTA DENTRO DE LAS EXCEPCIONES
      $rows = $this->repo->recursoRepoFechaBy($conjunto, $identificacion, $fecha, $idOT, TRUE);
      $rows2 = $this->repo->recursoRepoFechaBy($conjunto, $identificacion, $fecha, $idOT, FALSE);
      if( $rows->num_rows() > 0){ // SI ESTA CANT > 1 y FACTURABLE
          $val->valid = FALSE;
          $val->msj = "El recurso ya se encuentra reportado en otra orden de trabajo. ".json_encode($rows->result());
      }elseif ($rows2->num_rows() > 0 && $val->cantidad > 0) { // CANTIDAD MAYOR QUE 0 Y NO FACTURABLE
        if($conjunto == "equipos"){
          $val->valid = FALSE;
          $val->msj = "El recurso ya se encuentra reportado en otra orden de trabajo como NO facturable. ".json_encode($rows->result());
        }else{
          $val->msj = "CUIDADO! El recurso ya se encuentra reportado en otra orden de trabajo. ".json_encode($rows->result());
        }
      }
    }
    return $val;
  }

  public function exceptionValidarRecurso($val)
  {
    $this->load->database('ot');
    $data = array(
      '32128', '32129', '32006', '32007', '32008', '32009', '32010', '31001', '32013', '31016', '31017', '31018', '32107', '32108', '32109', '32154', '32155',
      '31026', '31027', '32152', '32153', '32222', '32223', '32224','32225','32112'
    );
    foreach ($data as $value) {
      if ($value == $val->codigo) {
        return TRUE;
      }
    }
    return FALSE;
  }

  # Valida un conjunto de recursos en una fecha a reportar
  public function validarRecursos($tipo = NULL, $post = NULL)
  {
    $this->load->model('reporte_db', 'repo');
    if (!isset($post)) {
      $post = json_decode( file_get_contents("php://input") );
    }
    $post->succ = TRUE;
    foreach ($post->recursos as $k => $v) {
      if($k!='actividades'){
        foreach ($v as $key => $value) {
          /*
          !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          Corregir: revisar primero las cantidades y estado facturable antes de ir a validar los items.
          */
          $value->msj = '';
          $value->valid_item = $this->validarItemByOT($post->idOT, $value->codigo);
          $value =  $this->validarRecurso( $post->fecha, $value, $k, $post->idOT );
          if($value->cantidad <= 0 && !$value->facturable){
            $value->valid = TRUE;
            $value->msj = "Este registro NO es facturable y sin cantidad.";
          }elseif ($k=='personal' && !$value->valid && $value->cantidad <= 0 ){
            $value->valid = TRUE;
          }
          if(!$value->valid){
            $post->succ = FALSE;
          }
          if(!$value->valid_item){
            $value->msj .= ' El item no existe en la planificación OT';
            $value->valid = FALSE;
            $post->succ = FALSE;
          }
        }
      }
    }
    if (isset($tipo)) {
      return $post;
    }else {
      echo json_encode($post);
    }
  }

  # Valida la existencia de un items en la OT
  public function validarItemByOT($idOT, $codigo)
  {
    $this->load->model('tarea_db', 'tar');
    $rows = $this->tar->getItemOTSUM($idOT,$codigo);
    if($rows->num_rows() > 0){
      return TRUE;
    }
    return FALSE;
  }

  #=============================================================================================================
  # LISTADO DE REPORTES POR ORDEN
  public function listado($tipo=NULL,  $sector=NULL)
  {
    $this->load->model('ot_db');
    $data = array( "bases" => $this->ot_db->getBases($tipo, $sector) );
    $this->load->view( 'reportes/lista/getReportesByOT', $data );
  }

  public function getReportesByOT()
  {
    $post = json_decode(file_get_contents('php://input'));
    $this->load->model('reporte_db', 'rd');
    $rows = $this->rd->listaBy($post->idOT);
    echo json_encode($rows->result());
  }
  #=============================================================================================================
  public function get($idReporte)
  {
    $this->load->model('reporte_db','repo');
    $r = $this->repo->get($idReporte)->row();
    $this->load->model('Ot_db', 'otdb');
    $ot = $this->otdb->getData($r->OT_idOT);
    $this->load->model('tarea_db', 'tarea');
    $item_equipos = $this->tarea->getTareasItemsResumenBy($r->OT_idOT,3);
    //obtener unidades de negocio
    $this->load->model('equipo_db', 'equ');
    $un_equipos = $this->equ->getResumenUN();

    $this->load->model('miscelanio_db', 'misc');
    $estados = $this->misc->getDataEstados()->result();

    //$recursos = new stdClass();
    //$recursos->personal = $this->repo->getRecursoReporte();
    $dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $diasemana = $dias[ date( "w", strtotime($r->fecha_reporte) ) ];
    $this->load->view('reportes/edit/edit',
      array( 'r'=>$r, 'item_equipos'=>$item_equipos->result(), 'un_equipos'=>$un_equipos, 'estados'=>$estados, 'diasemana'=>$diasemana, 'estados_labor'=>$this->misc->getEstadosLabor()->result() )
    );
  }

  public function getInfo($idReporte)
  {
    $this->load->model('reporte_db','repo');
    $r = $this->repo->get($idReporte)->row();
    return $r->json_r;
  }
  public function getRecursos($idReporte)
  {
    echo json_encode($this->getRecursoData($idReporte) );
  }
  public function getRecursoData($idReporte)
  {
    $this->load->model('reporte_db', 'repo');
    $acts = $this->repo->getRecursos($idReporte, 'actividades');
    $pers = $this->repo->getRecursos($idReporte, 'personal');
    $equs = $this->repo->getRecursos($idReporte, 'equipos');
    $myrepo = $this->repo->get($idReporte)->row();

    $recursos = new stdClass();
    $recursos->idreporte_diario = $idReporte;
    $recursos->estado = $myrepo->estado;
    $recursos->validado_pyco = $myrepo->validado_pyco;
    $recursos->observaciones_pyco = json_decode($myrepo->observaciones_pyco);
    $recursos->info = json_decode( $this->getInfo($idReporte) );
    $recursos->personal = $pers->result();
    $recursos->equipos = $equs->result();
    $recursos->actividades = $acts->result();
    return $recursos;
  }
  # ===========================================================================================================
  public function update($value='')
  {
    $post = json_decode( file_get_contents("php://input") );
    $cambios = new stdClass();
    $validReporte = $this->validarRecursos("retornable", $post);
    if($post->info->validado_pyco == 'CORREGIR'){ $validReporte->succ = TRUE; }
    if($validReporte->succ){
      $info = $post->info;
      $this->load->model('reporte_db', 'repo');
      $this->repo->init_transact();

      $this->load->helper('log');
      $no_affected = $this->repo->updateEstado($post->idreporte_diario, $post->info->estado, $post->info->validado_pyco, date('Y-m-d H:i:s'), NULL);
      if($no_affected > 0)
        addLog( $post->log->idusuario, $post->log->nombre_usuario, $post->idreporte_diario, 'reporte_diario', 'Reporte '.$post->fecha." de ".$post->info->nombre_ot.' Cambio de estado a : '.$post->info->validado_pyco, date('Y-m-d H:i:s'), NULL, 'RD '.$post->info->validado_pyco);

      if( $this->repo->update($post) ){
        $cambios->info = $post->info;
        $cambios->info->observaciones = NULL;
      }
      $cambios->actividades = $this->actualizarRecursos($post->recursos->actividades, $post->idreporte_diario, $post->fecha);
      $cambios->personal = $this->actualizarRecursos($post->recursos->personal, $post->idreporte_diario, $post->fecha);
      $cambios->equipos = $this->actualizarRecursos($post->recursos->equipos, $post->idreporte_diario, $post->fecha);
      if (isset($post->log)) {
        $msj = 'Reporte diario '.$post->fecha." de ".$post->nombre_ot.' actualizado.';
        addLog( $post->log->idusuario, $post->log->nombre_usuario, $post->idreporte_diario, 'reporte_diario', $msj, date('Y-m-d H:i:s'), NULL, json_encode($cambios) );
      }

      if($this->repo->end_transact() != FALSE){
        $response = new stdClass();
        $response->success = 'success';
        $var = $this->getRecursoData($post->idreporte_diario);
        $response->msj = 'Guardado correctamente. '.date('Y-m-d H:i:s');
        $response->personal = $var->personal;
        $response->equipos = $var->equipos;
        $response->actividades = $var->actividades;
        echo json_encode($response);
      }else{
        echo "Falló la inserción";
      }
    }else {
      $response = new stdClass();
      $response->success = 'unsuccess';
      $response->msj = 'Los recursos deben ser validados';
      $response->personal = $validReporte->recursos->personal;
      $response->equipos = $validReporte->recursos->equipos;
      $response->actividades = $validReporte->recursos->actividades;
      echo json_encode($response);
    }
  }

  public function updateData($value='')
  {
    $post = json_decode( file_get_contents("php://input") );
    $info = $post->info;
    $this->load->model('reporte_db', 'repo');
    $this->repo->init_transact();
    $this->repo->update($post);
    $response = new stdClass();
    if($this->repo->end_transact() != FALSE){
      $response->success = 'success';
    }else{
      $response->success = 'failed';
    }
  }

  public function actualizarRecursos($recursos, $idr, $fecha_reporte)
  {
    $cambios = array();
    foreach ($recursos as $key => $rec) {
      if( !isset($rec->idrecurso_reporte_diario) ){
        $this->repo->addRecursoRepo($rec, $idr);
        array_push($cambios, $rec);
      }else{
        if ( $this->repo->editRecursoRepo($rec, $idr) ) {
          array_push($cambios, $rec);
        }
      }
    }
    return $cambios;
  }


  public function updateEstado()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model(array('reporte_db'=>'repo'));
    $this->repo->init_transact();
    $this->repo->updateEstado($post->idreporte_diario, $post->estado, $post->validado_pyco, date('Y-m-d H:i:s'), NULL);
    $response = new stdClass();
    if($this->repo->end_transact() != FALSE){
      $response->success = 'success';
      $response->mensaje_log = 'Reporte actualizado correctamente. '.date('Y-m-d H:i:s');
      echo json_encode($response);
    }else{
      $response->success = 'failed';
      echo json_encode($response);
    }
  }

  # ===========================================================================================================
  public function exiteReporte()
  {
    $this->load->model('reporte_db','repo');
    $r = $this->repo->get($idReporte);
    if ($r->num_rows() < 0) {
      echo 0;
    }else{
      echo 1;
    }
  }
  # ============================================================================================================
  # Datos de relleno para pruebas
  public function getByOT($value='')
  {
    $reportes = array();
		for ($i=15; $i <= 31 ; $i++) {
			$fecha = date('Y-m-d', strtotime('2016-08-'.$i));
			$report = array(
				'idreporte'=>$i,
				'OT_idOT' => '27',
				'nombre_ot'=>'VITPCLLTEST',
				'fecha_reporte'=>$fecha,
				'dia'=> date('d', strtotime($fecha)),
				'mes'=> date('m', strtotime($fecha)),
				'valido'=> ( ($i%2==0)?true: false)
			);
			array_push($reportes, $report);
		}
		echo json_encode($reportes);
  }
  #===============================================================================================================
  # Obtener recursos preparados para agregar a la O.T.
  public function getRecursosByOT($idOT, $fecha = NULL){
      $this->load->model('recurso_db', 'recdb');
      $this->load->model('tarea_db','tarea');
      $pers = $this->recdb->getPersonalOtBy($idOT, 'persona');
      $equs = $this->recdb->getEquiposOtBy($idOT, 'equipo');
      $acts = $this->tarea->getActividadesPlaneadas($idOT,1, NULL, $fecha);
      $data = array(
          'personal' => $pers->result(),
          'equipo' => $equs->result(),
          'actividad'=> $acts->result()
        );
      echo json_encode($data);
  }

  public function getCantidadSum($fecha, $item, $sector, $idOT)
  {
    $this->load->model('tarea_db');
    $return =  $this->tarea_db->getCantidadSum($fecha, $item, $sector, $idOT);
    echo isset($return->row()->cant)?$return->row()->cant:0;
  }

  public function eliminarRecursosReporte($idrecurso_reporte_diario)
  {
    if ( isset($idrecurso_reporte_diario) && $idrecurso_reporte_diario != 'undefined') {
      $this->load->model('reporte_db', 'repo');
      $this->repo->init_transact();
      $this->repo->deleteRecursoReporte($idrecurso_reporte_diario);
      $val = $this->repo->end_transact();
      if($val != FALSE){
        echo "success";
      }else{
        echo "Error";
      }
    }else{
      echo "Error";
    }
  }

  public function deleteReporte($idreporte_diario)
  {
    $this->load->database('ot');
    $this->db->delete('recurso_reporte_diario', array('idreporte_diario' => $idreporte_diario) );
    $this->db->delete('reporte_diario', array('idreporte_diario' => $idreporte_diario) );
    echo "success";
  }

  //calendario js+angular
  public function calendar($ot)
	{
		$this->load->model('ot_db', 'myot');
		$ot = $this->myot->getData($ot);
		$this->load->view('reportes/calendar', array('ot'=>$ot->row()));
	}

  # UTILIDADES

  public function calcularCantidad($rec)
  {
    $cant = 0;
    if ($rec->tipo == 3) {
      if ($rec->unidad == 'hr') {
        $cant = ($rec->horas_operacion-4 > 0)? $rec->horas_operacion: 4;
      }else if ($rec->horas_operacion == 0 && $rec->hrdisp > 0) {
        $disp  = ($rec->hrdisp / $rec->basedisp);
        $cant = ($rec->horas_disponible > 0.00)?$disp:0;
      }else{
        $cant = 1;
      }
    }else{
      $cant = 1;
    }
    return round($cant,6) * $rec->cant_und;
  }

  public function restoreDates($update=FALSE)
  {
    $this->load->database('ot');
    $rows = $this->db->query(
      '
      SELECT
        OT.nombre_ot, rd.fecha_reporte, rd.json_r, rd.idreporte_diario,
        (SELECT COUNT(myrd.fecha_reporte) FROM reporte_diario AS myrd WHERE myrd.fecha_reporte = rd.fecha_reporte AND myrd.OT_idOT = rd.OT_idOT ) AS num_rd
      FROM reporte_diario AS rd JOIN OT ON OT.idOT = rd.OT_idOT
      HAVING num_rd > 1
      '
    );
    foreach ($rows->result() as $key => $rd) {
      $json = json_decode($rd->json_r);
      echo $rd->idreporte_diario." ".$rd->nombre_ot." ".$json->fecha_reporte.' '.$rd->fecha_reporte.'<br>';
      if($update){
        $this->db->update('reporte_diario', array('fecha_reporte'=>$json->fecha_reporte), 'idreporte_diario = '.$rd->idreporte_diario);
      }
    }
  }
}
