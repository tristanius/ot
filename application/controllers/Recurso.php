<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurso extends CI_Controller{

  public function __construct(){
    parent::__construct();
    date_default_timezone_set("America/bogota");
  }

  function index(){

  }

  # Fomulario para la gestión de recursos de una orden
  public function recursosOT()
  {
    $this->load->view('recursos/recursos_ot');
  }

  public function getByOT()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model('recurso_db', 'recdb');
    $this->load->model('ot_db', 'ot');
    $pers = $this->recdb->getPersonalOtBy($post->idOT, 'persona');
    $equs = $this->recdb->getEquiposOtBy($post->idOT, 'equipo');

    $items = $this->ot->getItemByTipeOT($post->idOT);

    $recursos = new stdClass();
    $recursos->personal = $pers->result();
    $recursos->equipo = $equs->result();
    $recursos->itemsOT = $items->result();
    $recursos->succ = 'success';
    echo json_encode($recursos);
  }

  public function addRecursoOT(){
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model('recurso_db', 'recdb');
    $id = $this->recdb->addRecursoOT( null, $post, $post, TRUE, TRUE, $post->tipo, $post->codigo_temporal, $post->descripcion_temporal);
    echo "success";
  }

  public function finby()
  {
    $post =json_decode( file_get_contents('php://input') );
    $this->load->model(array('recurso_db'=>'rec'));
    $rows = NULL;
    if($post->tipo == 'persona'){
      $rows = $this->rec->findPersonalBy($post->consulta->identificacion, $post->consulta->nombre_ot);
    }else{
      $rows = $this->rec->findEquiposBy($post->consulta->codigo_siesa);
    }
    echo json_encode($rows->result());
  }

  public function relacionarRecursosOT($value='')
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model(array('recurso_db'=>'rec'));
    $id = $this->rec->addRecursoOT($post->idrecurso, $post, $post, TRUE, TRUE, $post->tipo, NULL, NULL);
    echo 'success';
  }
  # =============================================================================
  # PROCESAMIENTO DE MAESTROS PERSONAL Y EQUIPOS
  # =============================================================================

  # =============================================================================
  # Subir seleccionar tipo de proceso a realizar
  public function uploadMaestro($tipo)// tipo describe si es equipo o persona
  {
    if ($tipo=="personal"){
      $this->uploadFile("personal");
    }elseif ($tipo=="equipos"){
      $this->uploadFile("equipos");
    }
  }

  # Upload y encaminamiento del proceso
  public function uploadFile($subcarpeta)
  {
    $carpeta = "/".$subcarpeta."/".date("dmY")."/";
    $dir = "./uploads".$carpeta;
    $this->crear_directorio("./uploads/".$subcarpeta."/");
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    //$this->recorrerFilasMaestro($subcarpeta, $carpeta.$dataup['file_name']);
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->recorrerFilasMaestro($subcarpeta, $carpeta.$dataup['file_name']);
    }else{
      echo  $this->upload->display_errors();
    }
  }

  # Recorrer excel
  public function recorrerFilasMaestro($process, $ruta='/equipos/26122016/test.xlsx') {
    $rows = $this->leerExcel($ruta);
    $this->load->model('ot_db', 'ot');
    $this->load->model('item_db', 'item');
    $this->load->model('equipo_db', 'equ');
    $this->ot->init_transact();

    $noValid = array();
    foreach ($rows as $key => $cell) {
      if ($process == 'personal') {
        if($cell['B'] != 'Id C.O.' || $cell['C'] != 'Empleado'){
          $ots = $this->ot->getOtBy( 'nombre_ot', $cell['F'] );
          $items = $this->item->getItemfByvigencia( 'itf.codigo', $cell['G'] );
          # echo "No.OT:".$ots->num_rows()." | No.Items:".$items->num_rows()."<br>";
          if ($ots->num_rows() > 0 && $items->num_rows() > 0) {
            $orden = $ots->row();
            $myitemf = $items->row();
            $cell = $this->registrarPersona($cell, $orden, $myitemf, $noValid);
          }else{
            if($ots->num_rows() < 1){
              $cell["A"] .= ">> OT no encontrada ";
            }
            if($items->num_rows() < 1) {
              $cell["A"] .= ">> Itemf no encontrado";
            }
          }
        }else{
          $cell["A"] = "Comentario App";
        }
      }else if($process ==  'equipos'){
        $cell = $this->registrarEquipo($cell, $noValid);
      }
      array_push($noValid, $cell);
    }

    if($this->ot->end_transact()){
      $html = $this->load->view('miscelanios/reporteCargaXLS',array("filas"=>$noValid),TRUE);
      $this->load->view('miscelanios/resultadoUpdateMaestro', array("html"=>$html));
    }else{
      echo "Fallo al insertar registros";
    }
  }
  # ------------------------------------------------------------------
  # AUXILIARES:

  # crear un subdirectorio
  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

  public function test($value='equipos/26122016/test.xlsx')
  {
    print_r( $this->leerExcel($value) );
  }

  # Llama al helper para leer un xlsx y devuelve una coleccion PHP
  public function leerExcel($ruta)
  {
    $this->load->helper('excel');
    return readExcel($ruta)->toArray(null,true,true,true);
    //print_r($this->excel->getData($ruta));
  }
  # Proceso que realiza el registro de datos por persona
  public function registrarPersona($row, $ot, $itemf, $noValid)
  {
    $this->load->model('persona_db', 'per');
    $personas  = $this->per->getBy("identificacion", $row['C'], "persona");
    if($personas->num_rows() < 1){
      $obj = new stdClass();
      $obj->identificacion = $row['C'];
      $obj->nombre_completo = $row['D'];
      $obj->fecha_registro = date('Y-m-d');
      $this->per->addObj($obj);
      $row['A'] = 'Agregado persona - ';
    }
    if( $this->per->existePersona( $row['C'] ) ){
      $recursos = $this->per->getRecursoOT($row["C"], $ot->idOT, $itemf->iditemf);
      if ($recursos->num_rows() < 1) { //si no existe el recurso add
        $this->load->model('recurso_db','recurso');
        $id = $this->recurso->add($row['H'], date('Y-m-d'), $row["F"], $row['E'], $row['I'], $row['C'], 'persona');
        $this->recurso->addRecursoOT($id, $ot, $itemf, TRUE, TRUE, 'persona');
        $row['A'] = $row['A'].'Agregado Recurso';
      }else{
        $row['A'] = 'Registro ya existente';
      }
    }
    return $row;
  }

  public function registrarEquipo($row, $noValid)
  {
    $this->load->model('equipo_db', 'equ');
    $equipos  = $this->equ->getBy("codigo_siesa", $row['B'], "equipo");
    if( $row['B'] == 'Activo fijo' || $row['B'] == 'referencia' ){

    }
    if($equipos->num_rows() < 1){
      $obj = array();
      $obj["codigo_siesa"] = $row['B'];
      $obj["referencia"] = $row['C'];
      $obj["descripcion"] = $row['D'];
      //$obj["desc_abreviada"] = $row['E'];
      //$obj["nit_responsable"] = $row['F'];
      //$obj["responsable"] = $row['G'];
      $obj["ccosto"] = $row['E'];
      $obj["un"] = $row['F'];
      //$obj["desc_un"] = $row['L'];
      $id =$this->equ->addArray($obj);
      $row['A'] = 'Agregado Equipo - ID: '.$id;
    }else{
      $row['A'] = 'Equipo ya existente';
    }
    return $row;
  }

  public function findEquiposBy($value='')
  {
    # code...
  }

  # Exportar html aexcel
  public function exporExcel($value='')
  {
    $html = $this->input->post('html');
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Informe.xls");
    echo $html;
  }
}
