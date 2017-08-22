<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MigracionReporte_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getOT($nombre_ot)
  {
    $this->load->database('ot');
    return $this->db->from('OT')->where('nombre_ot',$nombre_ot)->get();
  }

  public function getReporte($nombre_ot, $fecha_reporte)
  {
    $this->load->database('ot');
    return $this->db->select('rd.*, OT.nombre_ot, OT.idOT')->from('OT')->join('reporte_diario AS rd','rd.OT_idOT = OT.idOT')->where('OT.nombre_ot',$nombre_ot)->where('rd.fecha_reporte',$fecha_reporte)->get();
  }

  public function getEquipo($cod=NULL)
  {
    $this->load->database('ot');
    return $this->db->get_where('equipo', array('codigo_siesa'=>$cod) );
  }

  public function getRecurso($idOT, $fecha, $campo, $referencia)
  {
    return $this->db->select('rd.idreporte_diario, rd.OT_idOT, rrd.*')
          ->from('reporte_diario AS rd ')
          ->join('recurso_reporte_diario AS rrd','rrd.idreporte_diario = rd.idreporte_diario')
          ->join('recurso_ot AS rot', 'rrd.idrecurso_ot = rot.idrecurso_ot')
          ->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso')
          ->where('rd.OT_idOT',$idOT)
          ->where('rd.fecha_reporte',$fecha)
          ->where($campo,$referencia)
          ->get();
  }

  public function crearReporteGenerico($idOT, $rd_data)
  {
    $this->load->database('ot');
    $data = array(
      'fecha_reporte' => $rd_data->fecha_reporte,
      'festivo' => $rd_data->festivo,
      'OT_idOT' => $idOT,
      'estado' => 'CERRADO',
      'validado_pyco' => 'ELABORADO',
      'municipio' => isset($rd_data->municipio)?$rd_data->municipio:NULL,
      'sistema_reporte_ecp' => isset($rd_data->sistema_reporte_ecp)?$rd_data->sistema_reporte_ecp:NULL,
      'json_r' => '{"observaciones":[]}',
      'observaciones_pyco' => '[]'
    );
    $this->db->insert('reporte_diario', $data);
    return $this->db->insert_id();
  }

  public function moverRecurso($idRecusoReporte, $newIdReporte)
  {
    $this->load->database('ot');
    return $this->db->update('recurso_reporte_diario', array('idreporte_diario'=>$newIdReporte), 'idrecurso_reporte_diario = '.$idRecusoReporte);
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

}
