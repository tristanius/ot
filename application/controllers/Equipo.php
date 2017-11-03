<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipo extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index()
  {

  }

  public function listado($edit=NULL)
  {
    $this->load->view('equipo/listEquipos',array('edit'=>$edit));
  }
  public function getAll()
  {
    $this->load->model('equipo_db', 'equ');
    $equs = $this->equ->getAll();
    echo json_encode($equs->result());
  }

  public function byOT()
  {
    $post = json_decode( file_get_contents("php://input") );

    $this->load->database('ot');
    $equs = $this->db->from('equipo AS e')->join('recurso AS r','r.equipo_idequipo = e.idequipo')->join('recurso_ot AS rot','rot.recurso_idrecurso = r.idrecurso')
            ->join('OT','OT.idOT = rot.OT_idOT')
            ->join('itemf AS itf','itf.iditemf = rot.itemf_iditemf')
            ->like('OT.nombre_ot',$post->indicio_nombre_ot)
            ->get();
    echo json_encode($equs->result());
  }

  public function findBy()
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('equipo_db', 'equ');
    $equs = $this->equ->searchBy(
      (isset($post->codigo_siesa)?$post->codigo_siesa:NULL),
      (isset($post->referencia)?$post->referencia:NULL),
      (isset($post->descripcion)?$post->descripcion:NULL),
      (isset($post->un)?$post->un:NULL)
    );
    echo json_encode( $equs->result() );
  }

  #===============================================================================================
  # Procesos para reporte
  #===============================================================================================
  public function relacionarEquipo($value='')
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('equipo_db', 'equipo');
    $exist = $this->equipo->existeRecursoOT2($post->equipo_idequipo, $post->OT_idOT);
    if($exist->num_rows() <= 0){
      $this->load->model('item_db', 'item');
      $rows = $this->item->getField('iditemf = '.$post->itemf_iditemf, 'codigo, iditemf', 'itemf');
      if($rows->num_rows() > 0){
        $myitemf = $rows->row();
        $post->itemf_codigo = $myitemf->codigo;
        $id = $this->equipo->setEquipoRecurso($post);
        $this->equipo->setEquipoOT($post, $id);
      }
    }

    $this->load->model('recurso_db', 'recdb');
    $list_eq = $this->recdb->getEquiposOtBy($post->OT_idOT, 'equipo');
    echo json_encode($list_eq->result());
  }


  #===============================================================================================
  # consultas
  #===============================================================================================

  #Equipos de una OT
  public function equiposByOT($idot)
  {
    $this->load->model('equipo_db', 'equ');
    $equipos = $this->equ->getByOT($idot);
    echo json_encode( $equipos->result() );
  }


  #===============================================================================================
  #===============================================================================================
  #==================== PROCESO DE CARGA DE PERSONAL X OT DESDE UN ARCHIVO =======================
  #===============================================================================================
  public function formUpload()
  {
    $this->load->view('equipo/uploadEquOT');
  }

  public function formUploadByOT()
  {
    $this->load->view('equipo/uploadByOT');
  }

  public function uploadFileOT($value='')
  {
    $carpeta = "/equipos/".date("dmY")."/";
    $dir = "./uploads".$carpeta;
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->cargarEquiposOT( $this->getDataEquipo( $carpeta.$dataup['file_name'] ) ); //
    }else{
      echo  $this->upload->display_errors();
    }
  }

  public function cargarEquiposOT($activeSheet)
  {
    $this->load->model(array('equipo_db'=>'equ', 'item_db'=>'item'));
    $this->equ->init_transact();
    $response = array();
    foreach ($activeSheet as $key => $val) {
      if ($val['A'] == 'comentario' && $val['B'] == 'orden') {
        // ignorado
      }elseif ( $val['G']!='propio' && $val['G']!='externo') {
        $val['A'] = 'No se ha especificado correctamente si es propio o externo (minusculas)';
      }elseif(isset($val['E']) && $val['E'] != '' ){
  			$equipos = $this->equ->searchBy('0'.$val['E'].'-0');
  			if($equipos->num_rows() > 0){
  				$equipo = $equipos->row();
  				$ots = $this->equ->getField('nombre_ot LIKE "'.$val['B'].'"', 'idOT', 'OT');
  				$its = $this->item->getItemByOT( $val['B'], NULL, $val['C'] );

  				if($ots->num_rows() > 0 ){
  					if($its->num_rows() > 0 ){
  						$ot = $ots->row();
  						$it = $its->row();

              $rows = $this->equ->getEquipoPlan( $ot->idOT, $it->codigo);
              if ($rows->num_rows() > 0) {
                if( !$this->equ->existeRecursoOT($equipo->idequipo, $ot->idOT, $it->iditemf) ){
    						  $equipo->equipo_idequipo = $equipo->idequipo;
    						  $equipo->nombre_ot = $val['B'];
    						  $equipo->fecha_ingreso = date("Y-m-d");
    						  $equipo->centro_costo = '';
    						  $equipo->unidad_negocio = $equipo->desc_un;
    						  $equipo->fecha_registro = date("Y-m-d");
    						  $equipo->OT_idOT = $ot->idOT;
    						  $equipo->itemf_codigo = $it->codigo;
    						  $equipo->itemf_iditemf = $it->iditemf;
                  $equipo->propietario_recurso = $val['G']=='propio'?true:false;
                  $equipo->propietario_observacion = $val['F'];
    						  // Crear el recurso
    						  $id = $this->equ->setEquipoRecurso($equipo);
    						  // Crear el recurso OT
    						  $this->equ->setEquipoOT($equipo, $id);
    						  $val['A'] = 'Agregado y relacionado';
    						}else{
    						  $val["A"] = 'Relacion ya existente';
    						}
              }else{
                $val['A']='Item NO planeado en la Orden';
              }

  					}else{
    					$val['A'] = 'item no encontrado';
    				}
    			}else{
    				$val["A"] = 'Orden de trabajo no encontrada';
    			}
  		  }else{
          $val["A"] = 'Codigo siesa no cargado en la plataforma.';
        }
      }else{
        $val['A'] = 'No existe el equipo en el maestro o no se encuentra';
      }
      array_push($response, $val);
    }
    $returned = $this->equ->end_transact();
    if($returned != FALSE){
      $html = $this->load->view('miscelanios/reporteCargaXLS',array("filas"=>$response),TRUE);
      $this->load->view('miscelanios/resultadoUpdateMaestro', array("html"=>$html));
    }else{
      echo "fallo";
    }
  }

  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }
  }
  #Prueba
  public function testCargar($value='')
  {
      $this->cargarEquiposOT( $this->getDataEquipo('/equipos/26122016/eqot.xlsx') ); //
  }

  #  EN ESTA FUNCION REALIZAMOS EL PROCESO DE RECORRIDO DEL ARRAY DESPUES DE LEER LA HOJA DE CALCULO E INSERTAMOS LOS REGISTROS
  public function cargarEquipos($activeSheet)
  {
        $this->load->model(array('equipo_db'=>'equ'));
        $myrow = $activeSheet[1];
        $i=1;
        $headers = array();
        foreach ($myrow as $k => $r) {
          if(strtolower($r) == 'serial' || strtolower($r) == 'descripcion' || strtolower($r) == 'codigo siesa' || strtolower($r) == 'nombre ot'
              || strtolower($r) == 'item' || strtolower($r) == 'referencia')
          {
            $headers[$k] = strtolower($r);
          }
        }

        unset($activeSheet[1]);

        $num_insert = 0;
        $this->equ->init_transact();
        foreach ($activeSheet as $row){
          $equipo = new stdClass();
          foreach ($headers as $key => $content) {
            $equipo = $this->ajustadorDeFila($content, 'serial', $equipo, 'serial', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'descripcion', $equipo, 'descripcion', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'codigo siesa', $equipo, 'codigo_siesa', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'item', $equipo, 'item', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'nombre ot', $equipo, 'nombre_ot', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'referencia', $equipo, 'referencia', $row[$key]);
          }
          if(!$this->equ->existeEquipo($equipo->serial)){
            $equipo->idequipo = $this->equ->addObj($equipo);
            $num_insert++;
          }else{
            $equipo->idequipo = $this->equ->getField('serial = "'.$equipo->serial.'"', 'idequipo', 'equipo');
          }
          if (isset($equipo->nombre_ot) ) {
            $row = $this->equ->getField('nombre_ot LIKE "%'.$equipo->nombre_ot.'%"', 'idOT', 'OT')->row();
            $equipo->OT_idOT = $row->idOT;
            $it = $this->equ->getField('itemc_item LIKE "%'.$equipo->item.'%"', 'iditemf, codigo', 'itemf')->row();
            $equipo->itemf_codigo = $it->codigo;
            $equipo->itemf_iditemf = $it->iditemf;
            if (!$this->equ->existeRecursoOT($equipo) ) {
              $this->equ->setOT($equipo);
            }
          }
        }

        $returned = $this->equ->end_transact();
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
  public function getDataEquipo($ruta)
  {
    $this->load->helper('excel');
    $datos = readExcel($ruta)->toArray(null,true,true,true);
    return $datos;
  }

  public function delRecursoOT()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->database('ot');
    $this->db->delete('recurso_ot', array('idrecurso_ot'=>$post->idrecurso_ot) );
    $this->db->delete('recurso', array('idrecurso'=>$post->idrecurso) );
    echo "success";
  }

  public function historialOTs()
  {
    //$post = json_decode( file_get_contents('php://input') );
    $idequipo = $this->input->post('idequipo');
    $this->load->database('ot');
    $rows = $this->db->select('e.*, r.fecha_registro, rot.itemf_codigo, itf.itemc_item, itf.descripcion, OT.nombre_ot')
      ->from('equipo AS e')
      ->join('recurso AS r','r.equipo_idequipo = e.idequipo')
      ->join('recurso_ot AS rot','rot.recurso_idrecurso = r.idrecurso')
      ->join('itemf AS itf','itf.iditemf = rot.itemf_iditemf')
      ->join('OT','OT.idOT = rot.Ot_idOT')
      ->where('e.idequipo',$idequipo)
      ->get();
    $this->load->view('equipo/vistaHistorialOT', array('rows'=>$rows));
  }

}
