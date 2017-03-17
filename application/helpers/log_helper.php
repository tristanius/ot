<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function addlog($idusuario, $user, $idreg, $tabla, $mov, $fecha, $ref = NULL, $campo=NULL){
  $data["idregistro"] = $idreg;
  $data["tabla"] = $tabla;
	$data["idusuario"] = $idusuario;
  $data["nombre_usuario"] = $user;
  $data["movimiento"] = $mov;
  $data["fecha"] = $fecha;
  $data["referencia"] = $ref;
  $data["campo_afectado"] = $campo;
	$ci =& get_instance();
	$ci->load->database('ot');
	$ci->db->insert("log_movimiento",$data);
}
