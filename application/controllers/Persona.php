<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('America/Bogota');
    //Codeigniter : Write Less Do More
  }

  function listado(){
    $this->load->view('persona/listPersonas');
  }

  public function getAll($idOT=NULL)
  {
    $this->load->model('persona_db', 'pers');
    $data=  $this->pers->getAll($idOT);
    echo json_encode($data->result());
  }


  public function byOT(){
    $this->load->model('ot_db');
    $bases = $this->ot_db->getBases();
    $this->load->view('persona/personaByOT', array('bases'=>$bases));
  }

  public function crudByOT($idOT=NULL)
  {
    $this->load->model('persona_db', 'pers');
    return $this->pers->getAll($idOT);
  }

  #==============================================================================================
  # Personal por orden de trabajo
  public function personalByOT($idOT=NULL)
  {
    $this->load->model('persona_db', 'pers');
    $personas = $this->pers->getByOT($idOT);
    echo json_encode($personas->result());
  }

  # Personal de OTs By Base
  public function getPersonasOtByBase()
  {
    $consulta = json_decode(file_get_contents('php://input'));
    $this->load->model('persona_db', 'per_db');
    $personas  =$this->per_db->getPersonasOtByBase('OT.base_idbase = '.$consulta->base);
    echo json_encode($personas->result());
  }
  #===============================================================================================
  #===============================================================================================
  #==================== PROCESO DE CARGA DE PERSONAL X OT DESDE UN ARCHIVO =======================
  #===============================================================================================
  public function formUpload()
  {
    $this->load->view('persona/uploadPerOT');
  }

  public function uploadFile($value='')
  {
    $dir = "./uploads/perot/".date("dmY")."/";
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->cargarPersonalOT( $this->getDataPersonaByOT( $dir.$dataup['file_name'] ) ); //
    }else{
      echo  $this->upload->display_errors();
    }
  }
  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }
  }

  #  EN ESTA FUNCION REALIZAMOS EL PROCESO DE RECORRIDO DEL ARRAY DESPUES DE LEER LA HOJA DE CALCULO E INSERTAMOS LOS REGISTROS
  public function cargarPersonalOT($activeSheet)
  {
        $this->load->model(array('persona_db'=>'pers'));
        $myrow = $activeSheet[1];
        $i=1;
        $headers = array();

        foreach ($myrow as $k => $r) {
          if(strtolower($r) == 'empleado' || strtolower($r) == 'nombre del empleado' || strtolower($r) == 'id ccosto' || strtolower($r) == 'id cargo'){
            $headers[$k] = strtolower($r);
          }
        }

        unset($activeSheet[1]);

        $num_insert = 0;
        $this->pers->init_transact();
        foreach ($activeSheet as $row){
          $persona = new stdClass();
          foreach ($headers as $key => $content) {
            $persona = $this->ajustadorDeFila($content, 'empleado', $persona, 'identificacion', $row[$key]);
            $persona = $this->ajustadorDeFila($content, 'nombre del empleado', $persona, 'nombre_completo',$row[$key]);
            $persona = $this->ajustadorDeFila($content, 'id ccosto', $persona, 'nombre_ot',$row[$key]);
            $persona = $this->ajustadorDeFila($content, 'id cargo', $persona, 'itemf_codigo',$row[$key]);
          }
          //echo json_encode($persona)."<br>";
          if(!$this->pers->existePersona($persona->identificacion)){
            $this->pers->addObj($persona);
            $num_insert++;
          }
          if(isset($persona->nombre_ot) && isset($persona->itemf_codigo)){
            $it = $this->pers->getField('codigo = '.$persona->itemf_codigo, 'iditemf', 'itemf')->row();
            $persona->itemf_iditemf = $it->iditemf;

            $row = $this->pers->getField('nombre_ot LIKE "%'.$persona->nombre_ot.'" ', 'idOT', 'OT')->row();
            $persona->OT_idOT =  isset($row->idOT)?$row->idOT:NULL;
            if (!$this->pers->existeRecursoOT($persona)) {
              $this->pers->setPersonaOT($persona);
            }
          }
        }

        $returned = $this->pers->end_transact();
        if ($returned){
          echo 'Carga completada sin problemas, Filas insertadas: '.$num_insert;
        }else{
          echo 'La carga no ha sido exitosa';
        }
  }
  # El ajustador permite comparar cabecera actual con contenido esperado e identificado
  public function ajustadorDeFila($contenido, $comparador, $obj, $propiedadObj, $valorGuardar)
  {
    if ($contenido ==  $comparador) {
      $obj->$propiedadObj = $valorGuardar;
    }
    return $obj;
  }
  # Esta funcion nos permite hacer uso de la Libreria PHPExcel para leer archivos de hojas de calculo
  public function getDataPersonaByOT($ruta='./uploads/perot/09092016/text.xlsx')
  {
    $this->load->library('excel');
		$datos = $this->excel->getData($ruta);
		return $datos;
  }

  public function delRecursoOT()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->database('ot');
    $this->db->delete('recurso_ot', array('idrecurso_ot'=>$post->idrecurso_ot) );
    $rows = $this->db->from('recurso_ot AS rot')->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso')->where('r.idrecurso',$post->idrecurso)->get();
    if($rows->num_rows() == 0){
      $this->db->delete('recurso', array('idrecurso'=>$post->idrecurso) );
    }
    echo "success";
  }

  #===============================================================================================
  #===============================================================================================
  #==================== PROCESO DE CARGA DE PERSONAL REPORTADO EN NOMINA =======================
  #===============================================================================================
  public function view_cargue_horas()
  {
    $this->load->view('asociaciones/nomina/nomina');
  }

  public function form_cargue_horas($value='')
  {
    $this->load->view('asociaciones/nomina/form_upload');
  }

  public function getJsonTiempoLaborado($value='')
  {
    $post = json_decode(file_get_contents("php://input"));
    $this->load->model('reportepersonal_db', 'rper');
    $args = array();
    if(isset($post->base) && $post->base != ''){ $args['base'] = $post->base; }
    if(isset($post->orden) && $post->orden != ''){ $args['orden'] = $post->orden; }
    if(isset($post->identificacion) && $post->identificacion != ''){ $args['identificacion'] = $post->identificacion; }
    $rows = $this->rper->tiempoLaboradoGeneral2($post->fecha_inicio, $post->fecha_hasta, $args);
    echo json_encode($rows->result());
  }
  public function toNomina($bandera=NULL)
  {
    $post = json_decode(file_get_contents("php://input"));
    $this->load->model('reportepersonal_db', 'rper');
    $args = array();
    if(isset($post->base) && $post->base != ''){ $args['base'] = $post->base; }
    if(isset($post->orden) && $post->orden != ''){ $args['orden'] = trim( $post->orden ); }
    if(isset($post->identificacion) && $post->identificacion != ''){ $args['identificacion'] = $post->identificacion; }
    $bool = ( isset($bandera) && $bandera != NULL )?0:1;
    $this->rper->personalNomina($post->fecha_inicio, $post->fecha_hasta, $args, $bool);
    echo "success";
  }

  public function setValidacion($val='')
  {
    if ($val == 'VALIDADO_HE' || $val ==  'NOMINA' || $val == '') {
      # code...
    }
  }
}
