<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adjunto extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function index(){}

  public function upload()
  {
    $path = $this->input->post('path');
    $gestion = $this->input->post('gestion');
    $referencia = $this->input->post('referencia');
    $config['upload_path'] = './uploads/'.$path;
    $config['allowed_types'] = '*';
    $ret = new stdClass();
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('myfile') ) {
      $ret->error = $this->upload->display_errors();
      $ret->status = FALSE;
      echo json_encode($ret);
    }
    else {
      $this->load->model('adjunto_db','adjunto');
      $upload_data = $this->upload->data();
      $data = array(
        'nombre_adjunto' => $upload_data['file_name'],
        'path' => $upload_data['full_path'],
        'url_adjunto' => 'uploads/'.$path,
        'gestion' => $gestion,
        'referencia' => $referencia
      );
      $this->adjunto->init_transact(); // se gestiona un posible rollback
      $id = $this->adjunto->add($data);
      $rows = $this->adjunto->get($id);
      if($rows->num_rows() > 0){
        $ret->adjunto = $rows->row();
        $ret->status = $this->db->end_transact(); // Si la operacion ha sido exitosa se hace commit y se da estatus positivo
        echo json_encode($ret);
      }
    }
  }

  public function upload_bob($value='')
  {
    // code...
  }

  public function download($id)
  {
    $this->load->helper('download');
    $this->load->model('adjunto_db','adjunto');
    $rows = $this->adjunto->get($id);
    if($rows->num_rows() > 0){
      $adj = $rows->row();
      force_download( base_url($adj->url), NULL);
    }
  }

  public function remove($id)
  {
    // code...
  }
}

/* End of file Adjunto.php */
/* Location: ./application/controllers/Adjunto.php */
