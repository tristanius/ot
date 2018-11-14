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
  public function addvalid($idOT, $fecha){
    $date1=date_create($fecha);
    $date2=date_create(date('Y-m-d H:i:s'));
    $diff=$date1->diff($date2);
    if($diff->y == 0 && $diff->m <= 4){
      if( date( 'Y-m-d', strtotime($fecha) ) <= date( 'Y-m-d', strtotime('2018-01-30') )  ) {
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
    $frentes = $this->otdb->getFrentesOT($idOT);
    $this->load->model('miscelanio_db', 'misc');
    $estados = $this->misc->getDataEstados()->result();
    $items_planeados = $this->otdb->getPlanByFrentes($idOT);

    //obtener unidades de negocio
    $this->load->model('equipo_db', 'equ');

    $dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $diasemana = $dias[ date( "w", strtotime($fecha) ) ];

    $this->load->view('reportes/add/add',
		array(
				'ot'=>$ot->row(),
        'frentes'=>$frentes->result(),
				'fecha'=>$fecha,
				'estados'=>$estados,
        'diasemana'=>$diasemana,
        'estados_labor'=>$this->misc->getEstadosLabor()->result(),
        'items_planeados'=>$items_planeados
			)
		);
  }
  # ==============================================================================
  # insetar el reporte [SIMPLIFICAR]
  public function insert(){
    $this->load->library('session');
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

        if(isset($post->recursos->material))
        $this->insertarRecursoRep($post->recursos->material, $idrepo);
        if(isset($post->recursos->otros))
          $this->insertarRecursoRep($post->recursos->otros, $idrepo);
        if(isset($post->recursos->subcontratos))
          $this->insertarRecursoRep($post->recursos->subcontratos, $idrepo);

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
          $response->material = $var->material;
          $response->otros = $var->otros;
          $response->subcontratos = $var->subcontratos;
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
      $response->material = $validReporte->material;
      $response->otros = $validReporte->otros;
      $response->subcontratos = $validReporte->subcontratos;
    }
    echo json_encode($response);
  }

  public function insertarRecursoRep($list, $idr){
    $this->load->library('session');
    $this->load->model(array('recurso_reporte_db'=>'rec_repo'));
    foreach ($list as $key => $value) {
      $idrrd = $this->rec_repo->addRecursoRepo($value, $idr);
      // agregar avance de obra
      $this->avanceRecurso($value, $idrrd);
    }
  }
  #===========================================================================================================
  # Validaciones para guardar el reporte

  # valida si un Recurso ya esta registrado en una fecha dada, TRUE si se puede insertar y FALSE si ya existe en esa fecha
  public function validarRecurso($fecha, $val, $conjunto, $idOT)
  {
    $identificacion = ( $conjunto == "equipos" )? $val->codigo_siesa: $val->identificacion;
    $val->valid = TRUE;

    $this->load->model(array('recurso_reporte_db'=>'rec_repo'));
    # Consultamos registros el mismo día en otras OT
    $rows = $this->rec_repo->recursoRepoFechaBy($conjunto, $identificacion, $fecha, $idOT);
    # Si existe
    if($rows->num_rows() > 0){
      # si NO es un codigo excepto continuamos
      if(!$this->exceptionValidarRecurso($val)){
        $fact= FALSE;
        $select='SUM(rrd.cantidad) AS cantidad_acumulada';
        $facturable = NULL;
        $acumulados = $this->rec_repo->recursoRepoFechaBy($conjunto, $identificacion, $fecha, $idOT, $facturable, $select)->row();
        # Validamos
        $acumulado = $acumulados->cantidad_acumulada + $val->cantidad;
        if($acumulado >= 1){
          $val->valid = FALSE;
          $val->msj = 'Este registro acumularía '.$acumulado.' unidades en reportes. ';
        }
        $val->msj .= 'Se encuentra reportado en las OT: '.json_encode($rows->result());
      }else{
        # Sí esta excepto de todos modos avisamos.
        $val->msj = "Recurso excepto de validación. Pero ya reportado: ".json_encode($rows->result());
      }
    }else {
      $val->valid = TRUE;
    }
    return $val;
  }

  # CORREGIR: generar tabla de excepciones por contrato y consultar
  public function exceptionValidarRecurso($val)
  {
    $this->load->database('ot');
    $data = array(
      '32128', '32129', '32006', '32007', '32008', '32009', '32010', '31001', '32013', '31016', '31017', '31018', '32107', '32108', '32109', '32154', '32155',
      '31026', '31027', '32152', '32153', '32222', '32223', '32224','32225','32112', 'ED26'
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
      if($k != 'actividades' && $k != 'material' && $k != 'otros' && $k != 'subcontratos'){
        foreach ($v as $key => $rec) {
          $rec->msj = '';
          # Validamos primero que el codigo del item exista en la OT
          $rec->valid_item = $this->validarItemByOT($post->idOT, $rec->codigo);
          if(!$rec->valid_item){
            $rec->msj = ' El item no existe en la planificación OT';
            $rec->valid = FALSE;
            $post->succ = FALSE;
          }else{
            #inicio de validacion de item
            if($rec->cantidad <= 0){
              $rec->valid = TRUE;
              $rec->msj = "Registro sin cantidad. ";
            }else{
              $rec =  $this->validarRecurso( $post->fecha, $rec, $k, $post->idOT );
              #$rec->valid = (!$rec->facturable && !$rec->valid)?TRUE:FALSE;
            }
            # Si el item no es valido el resultado general tampoco
            if(!$rec->valid){
              $post->succ = FALSE;
            }
            # fin de validacion de item
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
    $items_planeados = $this->otdb->getPlanByFrentes($r->OT_idOT);
    $frentes = $this->otdb->getFrentesOT($r->OT_idOT)->result();

    $this->load->model('miscelanio_db', 'misc');
    $estados = $this->misc->getDataEstados()->result();

    //$recursos = new stdClass();
    //$recursos->personal = $this->repo->getRecursoReporte();
    $dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
    $diasemana = $dias[ date( "w", strtotime($r->fecha_reporte) ) ];
    $this->load->view('reportes/edit/edit',
      array(
        'r'=>$r,
        'frentes'=>$frentes,
        'estados'=>$estados,
        'diasemana'=>$diasemana,
        'estados_labor'=>$this->misc->getEstadosLabor()->result(),
        'items_planeados' => $items_planeados->result()
      )
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
    $this->load->model('recurso_reporte_db', 'rec_repo');
    $myrepo = $this->repo->get($idReporte)->row();

    $recursos = new stdClass();
    $recursos->idreporte_diario = $idReporte;
    $recursos->estado = $myrepo->estado;
    $recursos->validado_pyco = $myrepo->validado_pyco;
    $recursos->observaciones_pyco = json_decode($myrepo->observaciones_pyco);
    $recursos->info = json_decode( $this->getInfo($idReporte) );
    $recursos->personal = $this->rec_repo->getRecursos($idReporte, 'personal')->result();
    $recursos->equipos = $this->rec_repo->getRecursos($idReporte, 'equipos')->result();
    $recursos->actividades = $this->rec_repo->getRecursos($idReporte, 'actividades')->result();
    $recursos->material = $this->rec_repo->getRecursos($idReporte, 'material')->result();
    $recursos->otros = $this->rec_repo->getRecursos($idReporte, 'otros')->result();
    $recursos->subcontratos = $this->rec_repo->getRecursos($idReporte, 'subcontrato')->result();
    return $recursos;
  }
  # ===========================================================================================================
  # Actualizar reporte [SIMPLIFICAR]
  public function update($value='')
  {
    $this->load->library('session');
    $post = json_decode( file_get_contents("php://input") );
    $cambios = new stdClass();
    $validReporte = $this->validarRecursos("retornable", $post);
    if($validReporte->succ || $post->info->validado_pyco == 'CORREGIR'){
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
      $cambios->material = $this->actualizarRecursos($post->recursos->material, $post->idreporte_diario, $post->fecha);
      $cambios->otros = $this->actualizarRecursos($post->recursos->otros, $post->idreporte_diario, $post->fecha);
      $cambios->subcontratos = $this->actualizarRecursos($post->recursos->subcontratos, $post->idreporte_diario, $post->fecha);
      if (isset($post->log)) {
        $msj = 'Reporte diario '.$post->fecha." de ".$post->nombre_ot.' actualizado.';
        addLog( $post->log->idusuario, $post->log->nombre_usuario, $post->idreporte_diario, 'reporte_diario', $msj, date('Y-m-d H:i:s'), NULL, json_encode($cambios) );
      }
      if($this->repo->end_transact() != FALSE){
        $response = new stdClass();
        $response->success = 'success';
        $var = $this->getRecursoData($post->idreporte_diario);
        if($validReporte->succ){
          $response->success = 'success';
          $response->msj = 'Guardado correctamente. '.date('Y-m-d H:i:s');
        }
        $response->personal = $var->personal;
        $response->equipos = $var->equipos;
        $response->actividades = $var->actividades;
        $response->material = $var->material;
        $response->otros = $var->otros;
        $response->subcontratos = $var->subcontratos;
      }else{
        $response->success = 'unsuccess';
        $response->msj = 'La actualizacion de datos no se ha completado.';
      }
    }else {
      $response = new stdClass();
      $response->success = 'unsuccess';
      $response->msj = 'Los recursos deben ser validados';
      $response->personal = $validReporte->recursos->personal;
      $response->equipos = $validReporte->recursos->equipos;
      $response->actividades = $validReporte->recursos->actividades;
      $response->material = $validReporte->recursos->material;
      $response->otros = $validReporte->recursos->otros;
      $response->subcontratos = $validReporte->recursos->otros;
    }
    echo json_encode($response);
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
    $this->load->library('session');
    $this->load->model(array('recurso_reporte_db'=>'rec_repo'));
    $cambios = array();
    foreach ($recursos as $key => $rec) {
      if( !isset($rec->idrecurso_reporte_diario) ){
        $idrrd = $this->rec_repo->addRecursoRepo($rec, $idr);
        $rec->idrecurso_reporte_diario = $idrrd;
        $this->avanceRecurso($rec, $idrrd); # Agregamos avance de actividad si lo tiene
      }else{
        if ( $this->rec_repo->editRecursoRepo($rec, $idr) ) {
          $this->avanceRecurso($rec, $rec->idrecurso_reporte_diario); # Agregamos avance de actividad si lo tiene
        }
      }
    }
    return $cambios;
  }

  public function avanceRecurso($rec, $idrrd=NULL)
  {
    if (isset($rec->idavance_reporte)) {
      $this->rec_repo->modAvance($rec);
    }else{
      $this->rec_repo->addAvance($rec, $idrrd);
    }
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

  #===============================================================================================================
  # Obtener recursos preparados para agregar a la O.T.
  public function getRecursosByOT($idOT, $fecha = NULL){
      $this->load->model('recurso_db', 'recdb');
      $this->load->model('tarea_db','tarea');
      $pers = $this->recdb->getPersonalOtBy($idOT, 'persona');
      $equs = $this->recdb->getEquiposOtBy($idOT, 'equipo');
      $acts = $this->tarea->getActividadesPlaneadas($idOT, 1, NULL, $fecha);
      $mats = $this->tarea->getItemsPlaneadosBy($idOT, 'material');
      $otros = $this->recdb->getRecursoByOT($idOT, 'otros');
      $subs = $this->tarea->getActividadesPlaneadas($idOT,'subcontrato', NULL, NULL);
      $data = array(
          'personal' => $pers->result(),
          'equipo' => $equs->result(),
          'actividad'=> $acts->result(),
          'material'=>$mats->result(),
          'otros' =>$otros->result(),
          'subcontratos' =>$subs->result()
        );
      echo json_encode($data);
  }

  public function getCantidadSum($fecha, $item, $sector, $idOT)
  {
    $this->load->model('tarea_db');
    $return =  $this->tarea_db->getCantidadSum($fecha, $item, $sector, $idOT);
    echo isset($return->row()->cant)?$return->row()->cant:0;
  }

  # ============================================================================================================
  # Condensado de items por frente y actividad
  public function gen_condensado($idr, $retornar = FALSE)
  {
    $ret = new stdClass();
    $this->load->model('condensado_db', 'cond');
    $ret->fecha = date("Y-m-d");
    $ret->frentes = $this->cond->getFrentes($idr)->result();
    foreach ($ret->frentes as $key => $f) {
      $actividades = $this->cond->generar($idr, 1, $f->idfrente_ot)->result();
      $f->items = array();
      $odd = '';
      foreach ($actividades as $key => $act) {
        $items = $this->cond->generar($idr, NULL, $f->idfrente_ot)->result();
        foreach ($items as $key => $it) {
          $it->odd = $odd;
          $it->item_asociado = $act->itemc_item;
          $it->descripcion_asociada = $act->descripcion;
          array_push($f->items, $it);
        }
        $odd = $odd==''?'odd':'';
      }
    }
    $ret->guardado = FALSE;
    $ret->fecha = date("Y-m-d");
    if($retornar)
      return $ret;
    echo json_encode($ret);
  }

  public function get_condensado($idr)
  {
    $this->load->model('condensado_db', 'cond');
    $rows = $this->cond->get($idr);
    if($rows->num_rows() > 0)
      echo $rows->row()->condensado;
    else
      echo "{'frentes':[]}";
  }

  public function actualizar_condensado($idr)
  {
    $this->load->model('condensado_db', 'cond');
    $current = json_decode( $this->cond->get($idr)->row()->condensado );
    $new = $this->gen_condensado($idr,TRUE);
    foreach ($new->frentes as $key1 => $frente) {
      foreach ($current->frentes as $key2 => $frente_c) {
        if($frente->nombre == $frente_c->nombre){
          $frente->items = $this->update_items_frente($frente, $frente_c);
        }
      }
    }
    echo json_encode($new);
  }

  private function update_items_frente($f1, $f2)
  {
    $new_items = array();
    foreach ($f1->items as $k1 => $item) {
      foreach ($f2->items as $k2 => $item_c) {
        if($item_c->codigo == $item->codigo && $item_c->item_asociado == $item->item_asociado){
          $item->cantidad_asociada = $item_c->cantidad_asociada;
          if($item_c->valor != $item->valor){
            $item->added = 'newer';
          }else{
            $item->added = '';
          }
        }
      }
      array_push($new_items, $item);
    }
    return $new_items;
  }

  public function save_condensado()
  {
    $post = json_decode(file_get_contents('php://input'));
    $this->load->model('condensado_db', 'cond');
    $post->condensado->guardado = TRUE;
    $ret = $this->cond->save(json_encode($post->condensado), $post->idreporte_diario);
    $post->success = TRUE;
    echo json_encode($post);
  }

  #============================================================================================
	# Duplicar frentes
	# ===========================================================================================
  public function get_fecha_frentes($idOT, $idFrente)
  {
    $this->load->model('reporte_db','rd');
    $rows = $this->rd->getRecusoReportesByFrente($idOT, $idFrente);
    $ret = new StdClass();
    $ret->reportes = $rows->result();
    $ret->success = TRUE;
    echo json_encode($ret);
  }

  public function get_recursos_reporte_by($idOT, $idFrente, $idReporte)
  {
    $this->load->model('reporte_db','rd');
    $this->load->model('recurso_reporte_db','rec_repo');
    $ret = new StdClass();
    $ret->recursos = new StdClass();
    $ret->recursos->personal = $this->rec_repo->getRecursos($idReporte, 'personal', $idFrente)->result();
    $ret->recursos->equipos = $this->rec_repo->getRecursos($idReporte, 'equipos', $idFrente)->result();
    $ret->recursos->actividades = $this->rec_repo->getRecursos($idReporte, 'actividades', $idFrente)->result();
    $ret->recursos->material = $this->rec_repo->getRecursos($idReporte, 'material', $idFrente)->result();
    $ret->recursos->otros = $this->rec_repo->getRecursos($idReporte, 'otros', $idFrente)->result();
    $ret->success = TRUE;
    echo json_encode($ret);
  }

  # ============================================================================================================
  # Eliminaciones
  public function eliminarRecursosReporte($idrecurso_reporte_diario)
  {
    if ( isset($idrecurso_reporte_diario) && $idrecurso_reporte_diario != 'undefined') {
      $this->load->model('recurso_reporte_db', 'rec_repo');
      $this->rec_repo->init_transact();
      $this->rec_repo->deleteRecursoReporte($idrecurso_reporte_diario);
      $val = $this->rec_repo->end_transact();
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

  //calendario js+angular REVISAR UTILIDAD
  public function calendar($ot)
	{
		$this->load->model('ot_db', 'myot');
		$ot = $this->myot->getData($ot);
		$this->load->view('reportes/calendar', array('ot'=>$ot->row()));
	}

}
