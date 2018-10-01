<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurso_reporte_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
  }

  # Insertar un recurso a un reporte con unas cantidades
  public function addRecursoRepo($recurso, $idrepo)
  {
    $log = $this->session->userdata('idusuario').' '.$this->session->userdata('nombre_usuario');
    $data = array(
      'idreporte_diario' => $idrepo,
      'cantidad'=> isset($recurso->cantidad)? $recurso->cantidad: '0',
      'planeado'=> isset($recurso->planeado)?$recurso->planeado:'',
      'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
      'print'=> isset($recurso->print)?$recurso->print:TRUE,

      'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
      'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
      'hora_inicio2'=> isset($recurso->hora_inicio2)? $recurso->hora_inicio2: '',
      'hora_fin2'=> isset($recurso->hora_fin2)? $recurso->hora_fin2: '',

      'horas_extra_dia'=> isset($recurso->horas_extra_dia)? $recurso->horas_extra_dia: '',
      'horas_extra_noc'=> isset($recurso->horas_extra_noc)? $recurso->horas_extra_noc: '',
      'horas_recargo'=> isset($recurso->horas_recargo)? $recurso->horas_recargo: '',
      'horas_ordinarias'=> isset($recurso->horas_ordinarias)? $recurso->horas_ordinarias: '',

      'racion'=> isset($recurso->racion)? $recurso->racion: '',
      'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
      'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
      'horas_operacion'=> isset($recurso->horas_operacion)? $recurso->horas_operacion: '',
      'horas_disponible'=> isset($recurso->horas_disponible)? $recurso->horas_disponible: '',
      'varado'=> isset($recurso->varado)? $recurso->varado: '',
      'horometro_ini'=> isset($recurso->horometro_ini)? $recurso->horometro_ini: '',
      'horometro_fin'=> isset($recurso->horometro_fin)? $recurso->horometro_fin: '',
      'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
      'itemf_iditemf'=> isset($recurso->itemf_iditemf)?$recurso->itemf_iditemf:NULL,
      'itemf_codigo'=> isset($recurso->codigo)?$recurso->codigo:NULL,
      'gasto_viaje_pr'=> isset($recurso->gasto_viaje_pr)?$recurso->gasto_viaje_pr:NULL,
      'gasto_viaje_lugar'=> isset($recurso->gasto_viaje_lugar)?$recurso->gasto_viaje_lugar:NULL,
      'idestado_labor'=>isset($recurso->idestado_labor)?$recurso->idestado_labor:NULL,
      'idsector_item_tarea'=>isset($recurso->idsector_item_tarea)?$recurso->idsector_item_tarea:1,
      'idfrente_ot'=>isset($recurso->idfrente_ot)?$recurso->idfrente_ot:NULL,
      'item_asociado'=>isset($recurso->item_asociado)?$recurso->item_asociado:NULL,

      'procedencia'=>isset($recurso->procedencia)?$recurso->procedencia:NULL,
      'cc'=>isset($recurso->cc)?$recurso->cc:NULL,

      'combustible_cantidad'=>isset($recurso->combustible_cantidad)?$recurso->combustible_cantidad:NULL,
      'combustible_valor'=>isset($recurso->combustible_valor)?$recurso->combustible_valor:NULL,
      'combustible_und'=>isset($recurso->combustible_und)?$recurso->combustible_und:NULL,

      'no_cargue'=>isset($recurso->no_cargue)?$recurso->no_cargue:NULL,
      'last_log'=>$log." - ".date('Y-m-d H:i:s')
    );
    $this->db->insert('recurso_reporte_diario', $data);
    return $this->db->insert_id();
  }

  #Actualiar un recurso reporte
  public function editRecursoRepo($recurso, $idrepo)
  {
    $log = $this->session->userdata('idusuario').' '.$this->session->userdata('nombre_usuario');
    $data = array(
      'idreporte_diario' => $idrepo,
      'cantidad'=> isset($recurso->cantidad)?$recurso->cantidad: '0',
      'planeado'=> isset($recurso->planeado)?$recurso->planeado:'',
      'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
	    'print'=> isset($recurso->print)?$recurso->print:TRUE,

      'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
      'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
      'hora_inicio2'=> isset($recurso->hora_inicio2)? $recurso->hora_inicio2: '',
      'hora_fin2'=> isset($recurso->hora_fin2)? $recurso->hora_fin2: '',

      'horas_extra_dia'=> isset($recurso->horas_extra_dia)? $recurso->horas_extra_dia: '',
      'horas_extra_noc'=> isset($recurso->horas_extra_noc)? $recurso->horas_extra_noc: '',
      'horas_recargo'=> isset($recurso->horas_recargo)? $recurso->horas_recargo: '',
      'horas_ordinarias'=> isset($recurso->horas_ordinarias)? $recurso->horas_ordinarias: '',

      'racion'=> isset($recurso->racion)? $recurso->racion: '',
      'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
      'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
      'horas_operacion'=> isset($recurso->horas_operacion)? $recurso->horas_operacion: '',
      'horas_disponible'=> isset($recurso->horas_disponible)? $recurso->horas_disponible: '',
      'varado'=> isset($recurso->varado)? $recurso->varado: '',
      'horometro_ini'=> isset($recurso->horometro_ini)? $recurso->horometro_ini: '',
      'horometro_fin'=> isset($recurso->horometro_fin)? $recurso->horometro_fin: '',
      'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
      'itemf_iditemf'=> isset($recurso->itemf_iditemf)?$recurso->itemf_iditemf:NULL,
      'itemf_codigo'=> isset($recurso->itemf_codigo)?$recurso->codigo:NULL,
      'gasto_viaje_pr'=> isset($recurso->gasto_viaje_pr)?$recurso->gasto_viaje_pr:NULL,
      'gasto_viaje_lugar'=> isset($recurso->gasto_viaje_lugar)?$recurso->gasto_viaje_lugar:NULL,
      'idestado_labor'=>isset($recurso->idestado_labor)?$recurso->idestado_labor:NULL,
      'idsector_item_tarea'=>isset($recurso->idsector_item_tarea)?$recurso->idsector_item_tarea:1,
      'idfrente_ot'=>isset($recurso->idfrente_ot)?$recurso->idfrente_ot:NULL,
      'item_asociado'=>isset($recurso->item_asociado)?$recurso->item_asociado:NULL,
      'procedencia'=>isset($recurso->procedencia)?$recurso->procedencia:NULL,
      'cc'=>isset($recurso->cc)?$recurso->cc:NULL,

      'combustible_cantidad'=>isset($recurso->combustible_cantidad)?$recurso->combustible_cantidad:NULL,
      'combustible_valor'=>isset($recurso->combustible_valor)?$recurso->combustible_valor:NULL,
      'combustible_und'=>isset($recurso->combustible_und)?$recurso->combustible_und:NULL,

      'last_log'=>$log." - ".date('Y-m-d H:i:s')
    );
    $this->db->update('recurso_reporte_diario', $data, 'idrecurso_reporte_diario = '.$recurso->idrecurso_reporte_diario);
    return ($this->db->affected_rows() > 0)?TRUE:FALSE;
  }

  # -------------------------------------------------------------------
  # Avance de actividad
  # Agregar Avance actividad reportada
  public function addAvance($recurso, $idrecurso_repo)
  {
    if(
      isset($recurso->ubicacion) || isset($recurso->margen) || isset($recurso->MH_inicio) || isset($recurso->MH_fin) || isset($recurso->longitud) ||
      isset($recurso->ancho) || isset($recurso->alto) || isset($recurso->cant_elementos) || isset($recurso->cant_varillas) || isset($recurso->diametro_acero) ||
      isset($recurso->peso_und) || isset($recurso->tipo_ejecucion) || isset($recurso->a_cargo) || isset($recurso->calidad)
     ){
       $data = array(
         'ubicacion' => isset($recurso->ubicacion)?$recurso->ubicacion:NULL,
         'tipo_ejecucion' => isset($recurso->tipo_ejecucion)?$recurso->tipo_ejecucion:NULL,
         'a_cargo' => isset($recurso->a_cargo)?$recurso->a_cargo:NULL,
         'calidad' => isset($recurso->calidad)?$recurso->calidad:NULL,

         'abscisa_ini'=>isset($recurso->abscisa_ini)?$recurso->abscisa_ini:NULL,
         'abscisa_fin'=>isset($recurso->abscisa_fin)?$recurso->abscisa_fin:NULL,
         'tipo_instalacion'=>isset($recurso->tipo_instalacion)?$recurso->tipo_instalacion:NULL,

         'margen' => isset($recurso->margen)?$recurso->margen:NULL,
         'MH_inicio' => isset($recurso->MH_inicio)?$recurso->MH_inicio:NULL,
         'MH_fin' => isset($recurso->MH_fin)?$recurso->MH_fin:NULL,
         'longitud' => isset($recurso->longitud)?$recurso->longitud:NULL,
         'ancho' => isset($recurso->ancho)?$recurso->ancho:NULL,
         'alto' => isset($recurso->alto)?$recurso->alto:NULL,
         'cant_elementos' => isset($recurso->cant_elementos)?$recurso->cant_elementos:NULL,
         'cant_varillas' => isset($recurso->cant_varillas)?$recurso->cant_varillas:NULL,
         'diametro_acero' => isset($recurso->diametro_acero)?$recurso->diametro_acero:NULL,
         'peso_und' => isset($recurso->peso_und)?$recurso->peso_und:NULL,
         'idrecurso_reporte_diario' => $idrecurso_repo,
       );
       $this->db->insert('avance_reporte', $data);
       return $this->db->insert_id();
    }
  }
  # Modificar avance de actividad reportada
  public function modAvance($recurso)
  {
    $data = array(
      'ubicacion' => isset($recurso->ubicacion)?$recurso->ubicacion:NULL,
      'tipo_ejecucion' => isset($recurso->tipo_ejecucion)?$recurso->tipo_ejecucion:NULL,
      'a_cargo' => isset($recurso->a_cargo)?$recurso->a_cargo:NULL,
      'calidad' => isset($recurso->calidad)?$recurso->calidad:NULL,

      'abscisa_ini'=>isset($recurso->abscisa_ini)?$recurso->abscisa_ini:NULL,
      'abscisa_fin'=>isset($recurso->abscisa_fin)?$recurso->abscisa_fin:NULL,
      'tipo_instalacion'=>isset($recurso->tipo_instalacion)?$recurso->tipo_instalacion:NULL,

      'margen' => isset($recurso->margen)?$recurso->margen:NULL,
      'MH_inicio' => isset($recurso->MH_inicio)?$recurso->MH_inicio:NULL,
      'MH_fin' => isset($recurso->MH_fin)?$recurso->MH_fin:NULL,
      'longitud' => isset($recurso->longitud)?$recurso->longitud:NULL,
      'ancho' => isset($recurso->ancho)?$recurso->ancho:NULL,
      'alto' => isset($recurso->alto)?$recurso->alto:NULL,
      'cant_elementos' => isset($recurso->cant_elementos)?$recurso->cant_elementos:NULL,
      'cant_varillas' => isset($recurso->cant_varillas)?$recurso->cant_varillas:NULL,
      'diametro_acero' => isset($recurso->diametro_acero)?$recurso->diametro_acero:NULL,
      'peso_und' => isset($recurso->peso_und)?$recurso->peso_und:NULL
    );
    return $this->db->update('avance_reporte', $data, 'idavance_reporte = '.$recurso->idavance_reporte);
  }

  # Consultas
  #-------------------------------------------------------------
  # Consultas de reportes diarios
  public function recursoRepoFecha($idRecOt, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')
        ->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')->where('rrd.idrecurso_ot',$idRecOt)->where('rd.fecha_reporte',$fecha)->order_by('rrd.idrecurso_reporte_diario', 'DESC')->get();
  }

  public function recursoRepoFechaID($id, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')
        ->where('rrd.idrecurso_reporte_diario',$id)->where('rd.fecha_reporte',$fecha)->order_by('rrd.idrecurso_reporte_diario', 'DESC')->get();
  }

  public function recursoRepoFechaBy($tipo, $identificacion, $fecha, $idOT = NULL, $facturable = NULL, $select=NULL)
  {
    $this->load->database('ot');
    if (isset($select)) {
      $this->db->select($select);
    }
    $this->db->select('OT.nombre_ot');
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso');
    $this->db->where('rd.fecha_reporte',$fecha);
    if (isset($idOT)) {
      $this->db->where('rd.OT_idOT <>', $idOT);
    }
    if (isset($facturable)) {
      $this->db->where('rrd.facturable', $facturable);
    }
    if ( $tipo=='equipos' ) {
      $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo');
      $this->db->where('e.codigo_siesa', $identificacion);
    }elseif ($tipo == 'personal') {
      $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion');
      $this->db->where('p.identificacion', $identificacion);
    }
    return $this->db->get();
  }

  # Recursos de un reporte diario
  public function getRecursos($idrepo, $tipo, $idfrente=NULL){
    $this->load->database('ot');
    $this->db->select('rrd.*, itf.itemc_item, itf.codigo, itf.descripcion, itf.unidad, itc.descripcion AS descripcion_item,
      rot.propietario_recurso, rot.propietario_observacion, rrd.item_asociado,
      frente.nombre AS nombre_frente, frente.ubicacion AS ubicacion_frente, avance.*'
    );
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario');
    $this->db->join('avance_reporte AS avance', 'avance.idrecurso_reporte_diario = rrd.idrecurso_reporte_diario','LEFT');
    $this->db->join('itemf AS itf', 'rrd.itemf_iditemf = itf.iditemf', 'LEFT');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc', 'LEFT');
    $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc', 'LEFT');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot', 'LEFT');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso', 'LEFT');
    $this->db->join('frente_ot AS frente', 'frente.idfrente_ot = rrd.idfrente_ot', 'LEFT');
    if ($tipo == 'personal') {
      $this->db->select('p.*, r.idrecurso, r.centro_costo, r.unidad_negocio, r.fecha_ingreso, rot.*, titc.BO, titc.CL');
      $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
      $this->db->where('rot.tipo', 'persona');
    }
    elseif ($tipo == "equipos") {
      $this->db->select('
        IFNULL( e.descripcion, rot.descripcion_temporal ) AS descripcion_equipo,
        IFNULL( e.codigo_siesa, "Temporal" ) AS codigo_siesa,
        IFNULL( e.referencia, rot.codigo_temporal) AS referencia,
        e.ccosto, e.ccosto, desc_un, r.idrecurso, r.centro_costo, r.unidad_negocio, r.fecha_ingreso, rot.*, titc.BO, titc.CL');
      $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');
      $this->db->where('rot.tipo', 'equipo');
    }elseif ($tipo == 'actividades' || $tipo == 'subcontrato') {
      # CORREGIS los TIPO
      $tipo = $tipo=='actividades'?1:$tipo;
      $this->db->select("
        (
          SELECT SUM(mrrd.cantidad) AS cant
          FROM reporte_diario AS mrd
          JOIN recurso_reporte_diario AS mrrd ON mrd.idreporte_diario = mrrd.idreporte_diario
          WHERE mrd.OT_idOT = rd.OT_idOT
          AND mrrd.itemf_iditemf = rrd.itemf_iditemf
          AND mrd.fecha_reporte < rd.fecha_reporte
          AND mrrd.idsector_item_tarea = rrd.idsector_item_tarea
        ) AS acumulado,
        sec.nombre_sector_item AS nom_sector,
      ");
      $this->db->join('sector_item_tarea AS sec', 'sec.idsector_item_tarea = rrd.idsector_item_tarea', 'LEFT');
      $this->db->where('rrd.idrecurso_ot', NULL);
      $this->db->where('itf.tipo', $tipo);
    }elseif ($tipo=='material' || $tipo=='otros'){
      $this->db->select('
        rot.descripcion_temporal AS descripcion_recurso, rot.codigo_temporal AS referencia, rot.*, titc.BO, titc.CL, titc.grupo_mayor');
      $this->db->where('rot.tipo', $tipo);
    }
    $this->db->where('rrd.idreporte_diario', $idrepo);
    $this->db->order_by('itf.codigo', 'asc');
    //$this->db->order_by('rrd.facturable', 'desc');
    if ($tipo != 'actividades') {
      $this->db->order_by('titc.idtipo_itemc', 'desc');
      $this->db->order_by('rrd.idrecurso_reporte_diario', 'desc');
    }
    if(isset($idfrente)){
      $this->db->where('rrd.idfrente_ot', $idfrente);
    }
    return $this->db->get();
  }

  # =============================================================================================================================
  public function deleteRecursoReporte($idrecurso_reporte_diario)
  {
    $this->load->database('ot');
    $this->db->trans_begin();
    $this->db->delete('avance_reporte', array('idrecurso_reporte_diario'=>$idrecurso_reporte_diario));
    $val = $this->db->delete('recurso_reporte_diario', array('idrecurso_reporte_diario'=>$idrecurso_reporte_diario));
    if($this->db->trans_status() === FALSE ){
      $this->db->trans_rollback();
    }else{
      $this->db->trans_commit();
    }
    return $val;
  }
  # ======================================================================================
  # TRANSACTION
  public function init_transact()
	{
		$this->load->database('ot');
		$this->db->trans_begin();
	}

	public function end_transact()
	{
		$this->load->database('ot');
		$status = $this->db->trans_status();
		if ($status === FALSE){
		    $this->db->trans_rollback();
		}
		else{
		    $this->db->trans_commit();
		}
		return $status;
	}

}
