<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		date_default_timezone_set('America/Bogota');
		header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
		header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
		header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE
		$this->load->helper('config');
		if ($this->sesion_iniciada()) {
			//print_r($this->session->userdata());
			$this->load->view('inicio/indice',array("content"=>$this->load->view('inicio/pestanas','',TRUE)));
		}else{
			redirect(app_termo());
			//$this->load->view('login/login');
		}
	}

	public function loadOptions()
	{
		$this->load->view('inicio/init');
	}

	private function sesion_iniciada()
	{
		$this->load->library('session');
		if($this->session->userdata("isess")){
			$this->permisos_visualizacion();
			return TRUE;
		}
		return FALSE;
	}

	public function permisos_visualizacion()
	{
		$this->load->library('session');
		$this->load->database('ot');
		$idbase = $this->session->userdata('base_idbase');
		$row = $this->db->from('base')->where( 'idbase', $idbase )->get()->row();
		$data = array(
			'sector' => $row->sector,
			'idsector' => $row->idsector
		);
		if ($this->session->userdata('tipo_visualizacion') == 'sector' ) {
			$data['bases'] = $this->db->from('base')->where( 'idsector', $row->idsector )->get()->result();
		}elseif ($this->session->userdata('tipo_visualizacion') == 'base' ) {
			$data['bases'] = $this->db->from('base')->where( 'idsector', $idbase )->get()->result();
		}elseif ($this->session->userdata('tipo_visualizacion') == 'general' ){
			$data['bases'] = $this->db->get('base')->result();
		}
		$this->session->set_userdata($data);
		$this->db->close();
	}

	public function corregirHoras($v1, $v2, $ot=NULL)
	{
		$this->load->database('ot');
		if (isset($ot)) {
			$this->db->where('OT.idOT', $ot);
		}else{
			$this->db->where('rrd.idrecurso_reporte_diario >',$v1);
			$this->db->where('rrd.idrecurso_reporte_diario <',$v2);
		}
		$data = $this->db->select("OT.nombre_ot, OT.base_idbase, rd.fecha_reporte, rrd.*")
	 			->from('recurso_reporte_diario AS rrd')
				->join("reporte_diario AS rd","rd.idreporte_diario = rrd.idreporte_diario")
				->join("OT","OT.idOT = rd.OT_idOT")
				->join("itemf AS itf","itf.iditemf = rrd.itemf_iditemf")
				->where('itf.tipo',2)
				->get();
		foreach ($data->result() as $key => $val) {
			$tiempo = 0;
			if ( is_numeric($val->hora_inicio) || is_numeric($val->hora_fin2) ) {
				if (is_numeric($val->hora_inicio)) {
					$tiempo += (is_numeric($val->hora_fin)?$val->hora_fin:0 ) - $val->hora_inicio;
				}
				if (is_numeric($val->hora_inicio2)) {
					$tiempo += (is_numeric($val->hora_fin2)?$val->hora_fin2:0 ) - $val->hora_inicio2;
				}
				if (!is_numeric($val->hora_fin) && !is_numeric($val->hora_inicio2)) {
					$tiempo = $val->hora_fin2 - $val->hora_inicio -($val->hr_almuerzo?0:1);
				}
			}elseif( $this->isHora($val->hora_inicio) || $this->isHora($val->hora_fin2) ){
				if ( $this->isHora($val->hora_inicio) ) {
					$tiempo += $this->getTiempo($val->hora_inicio, $val->hora_fin);
				}
				if ( $this->isHora($val->hora_inicio2) ) {
					$tiempo += $this->getTiempo($val->hora_inicio2, $val->hora_fin2);
				}
				if ( !$this->isHora($val->hora_inicio2) && !$this->isHora($val->hora_fin) ) {
					$tiempo = $this->getTiempo($val->hora_inicio, $val->hora_fin2) -($val->hr_almuerzo?1:0);
				}
			}else{
				echo '------------------------------------------------- '.$val->hora_inicio.'-'.$val->hora_fin.' | '.$val->hora_inicio2.'-'.$val->hora_fin2.'<br>';
			}
			if ($tiempo >= 10) {
				if($val->base_idbase == 172 || $val->base_idbase == 173 || $val->base_idbase == 174 || $val->base_idbase == 194 )
					$tiempo = 9;
				else
					$tiempo = 8;
			}
			$bandera = $this->db->update('recurso_reporte_diario', array('horas_ordinarias'=>$tiempo),'idrecurso_reporte_diario = '.$val->idrecurso_reporte_diario);
			if($bandera)
				echo  $tiempo.' '.$val->nombre_ot.': '.$val->hora_inicio.'-'.$val->hora_fin.' | '.$val->hora_inicio2.'-'.$val->hora_fin2."<br>";
		}
		echo "<a href='".site_url("welcome/corregirHoras/".($v1+1000)."/".($v2+1000)."/".(isset($ot)?$ot:""))."' > Siguiente </a>";
	}

	private function getTiempo($hr_inicio, $hr_fin)
	{
		$h1t1 = substr($hr_inicio,0,strpos($hr_inicio,':'));
		$min1t1 = substr($hr_inicio,strpos($hr_inicio,':')+1,2);
		$h2t1 = substr($hr_fin,0,strpos($hr_fin,':'));
		$min2t1 = substr($hr_fin,strpos($hr_fin,':')+1,2);
		return (is_numeric($h2t1)?$h2t1:0) - $h1t1 + ( ($min2t1 >= 45?1:0) - ($min1t1 >= 45?1:0) ) ;
	}

	private function isHora($val)
	{
		if ( strpos($val, ':')>0 && strlen($val)>3 ){
			#$v = substr($val,0,strpos($val,':'));
			#$v2 = substr($val,strpos($val,':')+1,2);
			#echo $v.' y '.$v2.'<br>';
			return true;
		}
		return false;
	}

	public function mytest()
	{
		$this->load->database('ot');
		$this->db->query('
    SELECT
          year(rd.fecha_reporte) as año,
          month(rd.fecha_reporte) as mes,
          if(day(rd.fecha_reporte)<=15,1,2) as Quincena,
          "MA0032887" as contrato,
          OT.gerencia as gerencia,
          OT.nombre_departamento_ecp as nombre_departamento,
          OT.departamento_ecp as departamento_ecp,
          bs.sector as sector,
          bs.nombre_base as base,
          OT.base_idbase as CO,
          tp.nombre_tipo_ot as tipo_mtto,
          sp.nombre_especialidad as especialidad,
          itf.codigo,
          titc.grupo_mayor AS UN,
          rd.fecha_reporte,
          rd.festivo,
          OT.nombre_ot AS No_OT,
          IFNULL(
            (
              SELECT mytr.sap
              FROM tarea_ot AS mytr
              WHERE OT.idOT = mytr.OT_idOT
              AND rd.fecha_reporte BETWEEN mytr.fecha_inicio AND mytr.fecha_fin
              ORDER BY mytr.idtarea_ot DESC
              LIMIT 1
            ), ""
          ) as numero_sap,
          "" as tarea,
          "" as control_cambio,
          OT.cc_ecp as centro_costo,
          "" as cuenta_mayor,
          "" as sistema,
          OT.abscisa as pk,
          p.identificacion as cedula,
          p.nombre_completo,
          itf.itemc_item as item,
          tr.codigo_vinculado as item_sap,
          itc.descripcion,
          if(length(titc.cl)>0,if(titc.cl="C","Convencional","Legal"),"") as conv_leg,
          if(length(titc.bo)>0,if(titc.bo="B","Basico","Opcional"),"") as clasifica_gral,
          titc.descripcion as clasifica_deta,
          if(rrd.facturable,"SI","NO") AS facturable,
          rrd.cantidad AS cant_und,
          tr.tarifa,
          itf.unidad,
          if(rrd.facturable, getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad), 0) as cantidad_total,
          if(rrd.facturable, getDisp(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad) * tr.tarifa, 0) as valor_subtotal,
          if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr. tarifa, 0.18), 0) as a,
          if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.01), 0) as i,
          if(rrd.facturable, getAIU(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.04), 0) as u,
          if(rrd.facturable, getTotal(itf.iditemf, rrd.horas_operacion, rrd.horas_disponible, rrd.cantidad, tr.tarifa, 0.23), 0) as total,
          OT.locacion as lugar,
          OT.municipio,
          OT.zona,
          e.referencia as placa_equipo,
          rrd.horas_operacion,
          rrd.horas_disponible,
          e.codigo_siesa,
          e.referencia,
          rrd.nombre_operador,
          rrd.hora_inicio AS tr1_entrada,
          rrd.hora_fin AS tr1_salida,
          rrd.hora_inicio2 AS tr2_entrada,
          rrd.hora_fin2 AS tr2_salida,
          if(!rd.festivo, rrd.horas_ordinarias, 0) AS HO,
          if(!rd.festivo, rrd.horas_extra_dia, 0) AS HED,
          if(!rd.festivo, rrd.horas_extra_noc, 0) AS HEN,
          if(!rd.festivo, rrd.horas_recargo, 0) AS recargo_noc,
          if(rd.festivo, rrd.horas_ordinarias, 0) AS HOF,
          if(rd.festivo, rrd.horas_extra_dia, 0) AS HEDF,
          if(rd.festivo, rrd.horas_extra_noc, 0) AS HENF,
          if(rd.festivo, rrd.horas_recargo, 0) AS recargo_noc_fest,
          rrd.racion,
          rrd.gasto_viaje_pr AS pernocto,
          rrd.gasto_viaje_lugar AS lugar_gasto_viaje,
          rd.validado_pyco AS estado_reporte
      FROM reporte_diario AS rd
      JOIN OT ON OT.idOT = rd.OT_idOT
      JOIN base AS bs On bs.idbase = OT.base_idbase
      JOIN especialidad AS sp ON sp.idespecialidad = OT.especialidad_idespecialidad
      JOIN tipo_ot as tp ON OT.tipo_ot_idtipo_ot = tp.idtipo_ot
      JOIN recurso_reporte_diario AS rrd ON rrd.idreporte_diario = rd.idreporte_diario
      JOIN itemf AS itf ON itf.iditemf = rrd.itemf_iditemf
      JOIN itemc AS itc ON itc.iditemc = itf.itemc_iditemc
      JOIN tipo_itemc AS titc ON titc.idtipo_itemc = itc.idtipo_itemc
      JOIN tarifa AS tr ON tr.itemf_iditemf = itf.iditemf
      LEFT JOIN recurso_ot AS rot ON rot.idrecurso_ot = rrd.idrecurso_ot
      LEFT JOIN recurso AS r ON r.idrecurso = rot.recurso_idrecurso
      LEFT JOIN persona AS p ON p.identificacion = r.persona_identificacion
      LEFT JOIN equipo AS e ON e.idequipo = r.equipo_idequipo
      WHERE rd.fecha_reporte BETWEEN "2017-10-01" AND "2017-10-03"
      AND tr.idtarifa = (
          SELECT mytar.idtarifa
          FROM tarifa AS mytar
          JOIN vigencia_tarifas AS vig ON vig.idvigencia_tarifas = mytar.idvigencia_tarifas
          WHERE mytar.itemf_iditemf = tr.itemf_iditemf
          AND rd.fecha_reporte >= vig.fecha_inicio_vigencia
          ORDER BY mytar.idvigencia_tarifas DESC
          LIMIT 1
      )');
		echo $this->db->last_query();
	}
}
