<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contrato extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }
  public function form($value='')
  {
    $this->load->view('contrato/gestion');
  }

  public function add($value='')
  {
    // code...
  }
  
  public function lista()
  {
    // code...
  }

  public function remove($id)
  {
    // code...
  }

  # ----------------------------------------------
  # Vigencias

}
