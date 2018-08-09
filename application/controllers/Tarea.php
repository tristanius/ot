<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarea extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }

	public function delete($id)
	{
    $this->load->database('ot');
		$this->db->trans_begin();
		$status = $this->db->trans_status();
    $ret = new stdClass();
    $ret->status = FALSE;
    $items = $this->db->get_where('item_tarea_ot', array('tarea_ot_idtarea_ot'=>$id));
    if($items->num_rows() == 0){
        $this->db->delete('tarea_ot', array('idtarea_ot'=>$id));
        $ret->status = TRUE;
    }
    if($status === FALSE){ $this->db->trans_rollback();
    }else{ $this->db->trans_commit(); }
    echo json_encode($ret);
	}

  private function del_costos_mes($id)
	{
		$this->load->database('ot');
		$this->db->delete('costo_mes_ot', array('OT_idOT'=>$id) );
	}

}
