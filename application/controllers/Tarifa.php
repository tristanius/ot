<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarifa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("America/Bogota");
	}

	#===================================================================
	#form subir documento de tarifas
	public function form_upload($value='')
	{
		$this->load->view("tarifa/carga");
	}

	# Subir documentos Via AJAX
	public function upload_doc($value='')
	{
		$config['upload_path'] = './uploads/tarifa/';
		$config['allowed_types'] = 'xlsx|xls|pdf';
		$config['file_name'] = 'tarifas';
		$this->load->library("upload",$config);

		if($this->upload->do_upload("file")){
			$info = $this->upload->data();
			echo "success";
		}else{
			echo "error al subir";
		}
	}
	#===========================================================================
	# comprobar valides
	private function matchItems($datasheet)
	{
		try {
			$data = array();
			foreach ($datasheet as $row){
				if(!isset($row["A"]) || !isset($row["B"]) || !isset($row["C"]) || !isset($row["D"]) || !isset($row["E"]) || !isset($row["F"]) ){
					//return FALSE;
				}else{
					array_push(
							$data,
							array(
									"codigo"=>$row["A"],
									"descripcion"=>$row["B"],
									"unidad"=>$row["C"],
									"tarifa"=>$row["E"],
									"tipo"=>$row["D"],
									'salario'=>$row["F"],
									'itemc_item'=>$row["G"],
									"fecha_inicio"=>date_format( date_create( str_replace("-","/",$row["H"]) ),  "d-m-Y" )
								)
						);
				}
			}
			return $data;
		} catch (Exception $e) {
			return FALSE;
		}
	}

	#==========================================================================
	# aplicar tarifas nuevas
	public function aplicar($value='')
	{
		$this->load->helper('excel');
		$sheet = readExcel('tarifa/tarifas.xlsx');
		$tarifas = $this->matchItems( $sheet->toArray(null,true,true,true) );
		foreach ($tarifas as $item) {
			$this->load->model("item_db");
			if (isset($item["codigo"]) && $item["codigo"] != "") {
				$items = $this->item_db->getItemfBy('codigo', $item["codigo"], 'itemf');
				$itemc = $this->item_db->getItemfBy('item', $item["itemc_item"], 'itemc')->row();
				$id = NULL;
				if($items->num_rows() == 0){
					$id = $this->item_db->add($item["codigo"], $item["descripcion"], $item["unidad"],  $item['tipo'], $itemc->iditemc, $itemc->item);
				}else{
					$row =$items->row();
					$id = $row->iditemf;
				}
				$idtf = $this->item_db->addTarifa($item["tarifa"], $item["fecha_inicio"], $item['salario'], $id, $item["codigo"], TRUE);
			}
		}
		echo "success";
	}

	public function validar($value='')
	{
		$this->load->helper('excel');
		$sheet = readExcel('tarifa/tarifas.xlsx');
		$tarifas = $this->matchItems($sheet->toArray(null,true,true,true));
		if($tarifas != FALSE){echo "success";}
		else{echo "error";}
	}
	#===========================================================================
	#privados
	#===========================================================================

	# Agregar una nueva tarifaa item
	private function add($cod, $tarifa, $fecha, $id)
	{
		$this->load->model('item_db');
		$id = $this->item_db->addTarifa($tarifa,$fecha);
		return TRUE;
	}

	# Agregar una nueva tarifaa item
	private function getFields($row)
	{
		$fields = array();
		foreach ($row as $cell) {
			array_push($fields, $cell);
		}
		return $fields;
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
