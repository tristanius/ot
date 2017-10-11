<?php
$this->load->view('header');
$this->load->view('personal', array('personal' => $recusos->personal  ) );
$this->load->view('personal', array('equipos' => $recusos->equipos, 'apu'=>$recursos->apu  ) );
?>
