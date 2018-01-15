<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurso_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($fecha_ingreso, $fecha_registro, $nombre_ot, $centro_costo, $unidad_negocio, $idelemento, $tipo)
  {
    $data = array(
      'fecha_ingreso'=>$fecha_ingreso,
      'fecha_registro'=>$fecha_registro,
      'nombre_ot'=>$nombre_ot,
      'centro_costo'=>$centro_costo,
      'unidad_negocio'=>$unidad_negocio
    );
    if ($tipo == 'persona') {
      $data['persona_identificacion'] = $idelemento;
    }elseif ($tipo == 'equipo') {
      $data['equipo_idequipo'] = $idelemento;
    }
    $this->db->insert('recurso', $data);
    return $this->db->insert_id();
  }

  public function addRecursoOT($idrecurso, $ot, $itemf, $estado, $validado, $tipo, $cod_temp=NULL, $desc_temp=NULL, $propietario_recurso, $propietario_observacion)
  {
    $this->load->database('ot');
    $data = array(
      'recurso_idrecurso' => $idrecurso,
      'Ot_idOT' => $ot->idOT,
      'itemf_iditemf' => $itemf->iditemf,
      'itemf_codigo' => $itemf->codigo,
      'estado' => $estado,
      'validado' => $validado,
      'tipo' => $tipo,
      'codigo_temporal'=>$cod_temp,
      'descripcion_temporal'=>$desc_temp,
      'propietario_recurso'=>$propietario_recurso?TRUE:FALSE,
      'propietario_observacion'=>$propietario_observacion
    );
    $this->db->insert('recurso_ot', $data);
    return $this->db->insert_id();
  }

  # actualizar un recurso o un recurso_ot, parametros: $tabla, $id del objeto, $objeto PHP
  public function actualizar($tabla, $obj,  $query )
  {
    $this->load->database('ot');
    $data = (array) $obj;
    $this->db->update($tabla, $obj, $query );
  }

  # Obtener los recursos de personal y equipos de un OT en especifico

  public function getPersonalOtBy($idOT, $tipo)
  {
    $this->load->database('ot');
    return $this->db->select('
        rot.idrecurso_ot, rot.tipo, rot.itemf_iditemf, rot.recurso_idrecurso, r.idrecurso, OT.nombre_ot, r.centro_costo, r.unidad_negocio,
        p.*, itf.iditemf, itf.descripcion, itf.codigo, itf.itemc_iditemc, itf.itemc_item, itf.unidad, rot.propietario_recurso, rot.propietario_observacion, rot.UN'
      )->from('recurso_ot AS rot')
      ->join('recurso AS r', 'rot.recurso_idrecurso = r.idrecurso')
      ->join('itemf AS itf', 'rot.itemf_iditemf = itf.iditemf')
      ->join('persona AS p', 'r.persona_identificacion = p.identificacion')
      ->join('OT','OT.idOT = rot.OT_idOT')
      ->where('rot.OT_idOT',$idOT)
      ->where('rot.tipo', $tipo)
      ->where('rot.estado',TRUE)
      ->get();
  }

  public function getEquiposOtBy($idOT, $tipo)
  {
    $this->load->database('ot');
    return $this->db->select('
        rot.idrecurso_ot, rot.tipo, rot.itemf_iditemf, rot.recurso_idrecurso, rot.codigo_temporal, rot.descripcion_temporal, r.idrecurso, OT.nombre_ot, r.centro_costo, r.unidad_negocio,
        e.idequipo, e.ccosto, e.un, e.desc_un, itf.iditemf, itf.descripcion, itf.codigo, itf.itemc_iditemc, itf.itemc_item, itf.unidad, rot.propietario_recurso, rot.propietario_observacion, rot.UN,
        IFNULL( e.descripcion, rot.descripcion_temporal ) AS descripcion_equipo,
        IFNULL( e.codigo_siesa, "Temporal" ) AS codigo_siesa,
        IFNULL( e.referencia, rot.codigo_temporal) AS referencia
        '
      )->from('recurso_ot AS rot')
      ->join('recurso AS r', 'rot.recurso_idrecurso = r.idrecurso','LEFT')
      ->join('itemf AS itf', 'rot.itemf_iditemf = itf.iditemf')
      ->join('equipo AS e', 'r.equipo_idequipo = e.idequipo','LEFT')
      ->join('OT','OT.idOT = rot.OT_idOT')
      ->where('rot.OT_idOT',$idOT)
      ->where('rot.tipo', $tipo)
      ->where('rot.estado',TRUE)
      ->get();
  }


  public function findPersonalBy($cc, $ot)
  {
    $this->load->database('ot');
    return $this->db->select('p.*, rot.*, OT.*, itf.*, r.idrecurso')->from('recurso AS r')
            ->join('persona AS p','p.identificacion = r.persona_identificacion')
            ->join('recurso_ot AS rot','rot.recurso_idrecurso = r.idrecurso')
            ->join('itemf AS itf','itf.iditemf = rot.itemf_iditemf')
            ->join('OT','OT.idOT = rot.OT_idOT')
            ->like('p.identificacion',$cc)
            ->like('OT.nombre_ot',$ot)
            ->get();
  }
  public function findEquipoBy($cc, $ot=NULL)
  {
    $this->load->database('ot');
    return $this->db->from('recurso AS r')
            ->join('equipo AS e','e.idequipo = r.equipo_idequipo')
            ->join('recurso_ot AS rot','rot.recurso_idrecurso = r.idrecurso')
            ->join('itemf AS itf','itf.iditemf = rot.itemf_iditemf')
            ->like('e.codigo_siesa',$cc)
            ->get();
  }
  // TRANSACTION

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
		}else{
      $this->db->trans_commit();
		}
		return $status;
	}
}
