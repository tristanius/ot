<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipo_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

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

    public function addArray($data)
    {
      try {
        $this->load->database('ot');;
        $this->db->insert('equipo', $data);
        return $this->db->insert_id();
      } catch (Exception $e) {
        echo $e->getMessege().'   ';
      }

    }

    #===============================================================================================================
    # consultas
    #===============================================================================================================

    # Equipos por OT
    public function getAll($idOT=NULL)
    {
      $this->load->database('ot');
      return $this->db->get('equipo');
    }
    # consulta de equipos por OT
    public function getByOT($idOT)
    {
      $this->load->database('ot');
      return $this->db->from('equipo AS e')->join('recurso AS r','r.equipo_idequipo = e.idequipo')->join('recurso_ot AS rot','rot.recurso_idrecurso = r.idrecurso')->join('OT','OT.idOT = rot.OT_idOT')
              ->like('OT.idOT',$idOT)->where('e.idequipo',$idequipo)->get();
    }
    # relacionar equipo con OT
    public function setEquipoRecurso($equipo)
    {
      $this->load->database('ot');
      $data = array(
        'equipo_idequipo'=>$equipo->equipo_idequipo,
        'nombre_ot'=>$equipo->nombre_ot,
        'centro_costo'=>$equipo->centro_costo,
        'unidad_negocio'=>$equipo->unidad_negocio,
        'fecha_registro'=>$equipo->fecha_registro,
        'fecha_ingreso'=>$equipo->fecha_registro,
      );
      $this->db->insert('recurso', $data);
      return $this->db->insert_id();
    }
    public function setEquipoOT($equipo, $id)
    {
      $this->load->database('ot');
      $data = array(
        'itemf_codigo' => $equipo->itemf_codigo,
        'itemf_iditemf' => $equipo->itemf_iditemf,
        'estado' => TRUE,
        'recurso_idrecurso' => $id,
        'OT_idOT' => $equipo->OT_idOT,
        'tipo' => 'equipo',
        'propietario_recurso' => $equipo->propietario_recurso,
        'propietario_observacion' => $equipo->propietario_observacion
      );
      if(isset($equipo->costo_und) && $equipo->costo_und != '' && $equipo->costo_und != NULL ){
        $data['costo_und'] = $equipo->costo_und;
      }
      if(isset($equipo->UN) && $equipo->UN != '' && $equipo->UN != NULL ){
        $data['UN'] = $equipo->UN;
      }
      $this->db->insert('recurso_ot', $data);
      return $this->db->insert_id();
    }

    # saber si existe ya el equipo relacionado con la OT
    public function existeRecursoOT($idequipo, $idOT=NULL, $iditemf)
    {
      $this->load->database('ot');
      $this->db->from('recurso_ot AS rot');
      $this->db->join('recurso  AS r', 'rot.recurso_idrecurso = r.idrecurso');
      $this->db->join('equipo  AS e', 'e.idequipo = r.equipo_idequipo');
      $this->db->where('r.equipo_idequipo', $idequipo);
      $this->db->where('rot.itemf_iditemf', $iditemf);
      $this->db->where('rot.OT_idOT', $idOT);
      $rows = $this->db->get();
      return $rows->num_rows() > 0?TRUE:FALSE;
    }

    #Consultar existencia en tabla
    public function existeEquipo($cc='')
    {
      $this->load->database('ot');
      $rows = $this->db->get_where('equipo', array('idequipo'=>$cc) );
      return $rows->num_rows() > 0?TRUE:FALSE;
    }

    // Obtener resumen de los tipo de unidades de negocio
    public function getResumenUN($value='')
    {
      $this->load->database('ot');
      return $this->db->select('un, desc_un')->from('equipo')->group_by('desc_un')->get();
    }

    public function getEquipoPlan($idOT, $codigo)
    {
      $this->load->database('ot');
      return $this->db->from('OT')
      ->join('tarea_ot AS tr', 'tr.OT_idOT = OT.idOT')
      ->join('item_tarea_ot AS itt', 'itt.tarea_ot_idtarea_ot = tr.idtarea_ot')
      ->join('itemf AS itf','itf.iditemf = itt.itemf_iditemf')
      ->where('itf.codigo',$codigo)->where('OT.idOT',$idOT)->get();
    }

    // Obtener bajo paramentrops
    public function searchBy($codigo_siesa=NULL, $referencia=NULL, $descripcion=NULL, $un=NULL )
    {
      $this->load->database('ot');
      $this->db->select('*');
      $this->db->from('equipo');
      if (isset($codigo_siesa)) {
        $this->db->like('codigo_siesa', $codigo_siesa);
      }
      if (isset($referencia)) {
        $this->db->like('referencia', $referencia);
      }
      if (isset($descripcion)) {
        $this->db->like('descripcion', $descripcion);
      }
      if (isset($un)) {
        $this->db->like('un', $un);
      }
      return $this->db->get();
    }

    #===============================================================================================================
    #===============================================================================================================
    #fields

    public function existeRecursoOT2($idequipo, $idOT)
    {
      $this->load->database('ot');
      return $this->db->from('recurso_ot AS rot')->join('recurso AS r','rot.recurso_idrecurso = r.idrecurso')->where('rot.OT_idOT',$idOT)->where('r.equipo_idequipo', $idequipo)->get();
    }

    public function getBy($campo, $valorbuscado, $tabla)
    {
      return $this->db->get_where($tabla, array($campo=>$valorbuscado));
    }

    public function getField($where, $select, $table)
  	{
  		$this->load->database('ot');
  		$this->db->select($select)->from($table)->where($where);
  		return $this->db->get();
  	}

}
