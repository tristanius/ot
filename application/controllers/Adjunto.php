<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adjunto extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function index(){
    $this->load->model('adjunto_db','adjunto');
  }

  public function upload()
  {
    $path = $this->input->post('path');
    $gestion = $this->input->post('gestion');
    $usuario = $this->input->post('usuario');
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
        'usuario' =>$usuario,
        'referencia' => $referencia
      );
      $this->adjunto->init_transact(); // se gestiona un posible rollback
      $id = $this->adjunto->add($data);
      $rows = $this->adjunto->get($id);
      if($rows->num_rows() > 0){
        $ret->adjunto = $rows->row();
        $ret->status = $this->adjunto->end_transact(); // Si la operacion ha sido exitosa se hace commit y se da estatus positivo
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
      force_download( base_url($adj->url_adjunto), NULL);
    }
  }

  public function remove($id)
  {
    $ret = new stdClass();
    $info = json_decode( file_get_contents('php://input') );
    $this->load->model('adjunto_db','adjunto');
    try {
      $this->adjunto->init_transact();
      $rows = $this->adjunto->get($id);
      if($rows->num_rows() > 0){
        $adj = $rows->row();
        if($info->nombre_adjunto == $adj->nombre_adjunto){
          $this->adjunto->remove($id);
          $ret->status =  $this->adjunto->transac_status();// Esperamos un TRUE
          $this->adjunto->end_transact();
          if($ret->status){
            unlink('./'.$adj->url_adjunto.$adj->nombre_adjunto);
          }
        }else{
          $ret->status = FALSE;
        }
      }else{
        $ret->status = FALSE;
      }
    } catch (Exception $e) {
      $ret->status = FALSE;
      $ret->msj = $e->getMessage();
    }
    echo json_encode($ret);
  }
}

/* End of file Adjunto.php */
/* Location: ./application/controllers/Adjunto.php */
