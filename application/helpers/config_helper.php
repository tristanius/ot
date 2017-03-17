<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function config_upload($nombre="termo"){

}
function app_termo($app="app.termo"){
	$ci =& get_instance();
	$ci->load->database('app1');
	$res = $ci->db->get_where("aplicacion","nombre_app = '".$app."'");
	$r = $res->row();
	return $r->ruta_app;
}

function getItemC($item){
	$ci =& get_instance();
	$ci->load->database('ot');
	$r = $ci->db->get_where("itemc","item = '".$item."'");
	return $r->row();
}

function getDestino($id){
	$ci =& get_instance();
	$ci->load->database('ot');
	$r = $ci->db->get_where("tarifa_gv","idtarifa_gv = '".$id."'");
	return $r->row();
}

function addlog($ip, $accion, $privilegio, $user){
	$data["direccion_ip"] = $ip;
	$data["actividad_realizada"] = $accion;
	$data["privilegio_idprivilegio"] = $privilegio;
	$data["usuario_idusuario"] = $user;
	$data["fecha_actividad"] = date("Y-m-d H:i:s a");
	$ci =& get_instance();
	$ci->load->database();
	$ci->db->insert("log_movimientos",$data);
}

function getFieldsPYCO($v){
	$val1 = json_decode($v->json_viaticos);
	$val2 = json_decode($v->json_horas_extra);
	$val3 = json_decode($v->json_reembolsables);
	$pyco = new stdClass();

	$pyco->directo = $v->actividades + $v->personal + $v->equipo;
	$pyco->aiu = $pyco->directo * (23/100);
	$pyco->gastos_viaje = $val1->valor_viaticos;
	$pyco->horas_extra = $val2->valor_horas_extra;
	$pyco->raciones = $val2->raciones_cantidad * $val2->raciones_valor_und;
	$pyco->aiu_otros = ( $pyco->gastos_viaje + $pyco->horas_extra + $pyco->raciones ) * (4.58/100);
	$pyco->reembolsables = $val3->valor_reembolsables;
	$pyco->aiu_reemb = $pyco->reembolsables * (1/100);
	$pyco->total = $pyco->directo + $pyco->aiu + $pyco->gastos_viaje + $pyco->horas_extra + $pyco->raciones + $pyco->aiu_otros + $pyco->reembolsables + $pyco->aiu_reemb;

	$ci =& get_instance();
	$ci->load->view('miscelanios/informePYCOresumen',array('pyco'=>$pyco));
}
