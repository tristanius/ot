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
  public function gestion($value='')
  {
    $this->load->view('contrato/gestion');
  }

  public function form($value='')
  {
    // code...
  }

  public function save($value='')
  {
    // code...
  }

  public function add($value='')
  {
    // code...
  }

  public function mod($value='')
  {
    // code...
  }

  public function lista()
  {

  }

  public function remove($id)
  {
    // code...
  }

  # ----------------------------------------------
  # Vigencias

}
