<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ot extends CI_Controller {

	private $clasificacion_ot = array(
		"APIQUE",	"ATENTADO",	"ADMINISTRATIVA",	"CIVIL",	"CRATER",	"DEFORMIMETRO",	"DRENAJE",
		"EGOS",	"ELE. VARIABLE",	"ILICITA",	"INSPECCION",	"INS. VARIABLE", "INTEGRIDAD",	"INYECCION", "VALVULAS",
		"MEC. VARIABLE",	"MONITOREO",	"OT. APOYO",	"PDE",	"RECORRIDO",	"REPARACION",		"ROCERIA", "MTTO. VIAS",
		"PRELIMINARES REP.", "URPC", "CONSTRUCCION GENERAL", "CANALIZACION", "N/A"
	);
	private $nombre_departamento_ecp = array(
		'PCL'=>'Oriente', 'PFL'=>'Fluvial', 'POR'=>'Magdalena', 'PNO'=>'Caribe', 'OBC'=>'Bicentenario','N/A'=>'N/A'
	);

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Bogota');
	}

	public function index()
	{
	}

	public function getBy()
	{
		$post = json_decode( file_get_contents('php://input') );
		$this->load->model(array('ot_db'=>'ot'));
		$base = (isset($post->base) && $post->base != '')?$post->base:NULL;
		$nom = (isset($post->indicio_nombre_ot) && $post->indicio_nombre_ot != '')?$post->indicio_nombre_ot:NULL;
		$estado = (isset($post->estado) && $post->estado !="" )?$post->estado:NULL;
		$ots = $this->ot->getAllOTs($base, $nom, $estado);
		echo json_encode($ots->result());
	}

	public function getByBase($base)
	{
		$this->load->model('ot_db', 'otdb');
		$ots = $this->otdb->getAllOTs($base);
		echo json_encode($ots->result());
	}

	public function getByName($value='')
	{
		$post = json_decode( file_get_contents('php://input') );
		$this->load->database('ot');
		if(isset($post->indicio_nombre_ot)){
			$rows = $this->db->select('*')->from('OT')->like('nombre_ot',$post->indicio_nombre_ot)->get();
			// echo $this->db->last_query();
			echo json_encode($rows->result());
		}
	}

	#=============================================================================
	# GUARDAR UNA ORDEN DE TRABAJO
	public function addNew($idOT=NULL)
	{
		$this->load->model('miscelanio_db');
		$depars = $this->miscelanio_db->getDepartamentos();
		$tipos_ot = $this->miscelanio_db->getTiposOT();
		$especialidades = $this->miscelanio_db->getEspecialidadesOT();
		$sectores = $this->miscelanio_db->getSectorItems();
		$tarifagv = $this->miscelanio_db->getTarifasGV();
		$this->load->view('ot/add/agregarOT', array(
				"depars"=>$depars,
				"tipos_ot"=>$tipos_ot,
				"especialidades"=>$especialidades,
				"tarifagv"=>$tarifagv,
				'sectores'=>$sectores,
				'clasificacion_ot'=>$this->clasificacion_ot,
				"titulo_gestion"=>"Agregar una nueva Orden de Trabajo:",
				'isEdit'=>FALSE
			)
		);
	}

	public function getDataNewForm()
	{
		$this->load->model(array("Ot_db","item_db","miscelanio_db","contrato_db"));
		$bases = $this->Ot_db->getBases();
		$items['actividad']  = $this->item_db->getBytipo(1)->result();
		$items['personal']  = $this->item_db->getBytipo(2)->result();
		$items['equipo']  = $this->item_db->getBytipo(3)->result();
		$items['material']  = $this->item_db->getBytipo('material')->result();
		$items['otros']  = $this->item_db->getBytipo('otros')->result();
		$vigencias = $this->item_db->getVigenciasActivas()->result();
		$contratos = $this->contrato_db->getContratos(NULL, TRUE)->result();
		$this->load->helper('config');
		$usuarios = getUsuarios(NULL, TRUE);
		$arr =array(
			"bases"=>json_encode($bases->result()),
			'items'=>json_encode($items),
			'vigencias'=>json_encode($vigencias),
			'allVigencias'=>json_encode($vigencias),
			'contratos'=>json_encode($contratos),
			'usuarios'=>$usuarios
			);
		echo json_encode($arr);
	}

	public function saveOT($dupe=NULL)
	{
		$post = file_get_contents('php://input');
		$ots = json_decode($post);
		$ot = $ots->ot;
		#Crear la OT
		$orden = $ots->ot;
		if( $this->existeOT($orden->nombre_ot) ){
			echo "La Orden de trabajo ya existe.";
		}else{
			$this->load->model('Ot_db','ot');
			$orden->fecha_creacion = date('Y-m-d H:i:s');
			try {
				$this->ot->init_transact();
				# --------------------
				#crear la OT
				$idot = $this->ot->add(
						$orden->nombre_ot,
						isset($orden->ccosto)?$orden->ccosto:NULL,
						$orden->base_idbase,
						$orden->zona,
						$orden->fecha_creacion,
						isset($dupe)?$orden->especialidad_idespecialidad:$orden->especialidad,
						isset($dupe)?$orden->tipo_ot_idtipo_ot:$orden->tipo_ot,
						$orden->actividad,
						$orden->justificacion,
						isset($orden->locacion)?$orden->locacion:NULL,
						isset($orden->abscisa)?$orden->abscisa:NULL,
						isset($orden->departamento)?$orden->departamento:NULL,
						isset($orden->municipio)?$orden->municipio:NULL,
						isset($orden->vereda)?$orden->vereda:NULL,
						isset($orden->cc_ecp)?$orden->cc_ecp:NULL,
						isset($orden->json)?json_encode($orden->json):'{"p1":false,"p2":false,"p3":false,"p4":false,"p5":false}',
						isset($orden->clasificacion_ot)?$orden->clasificacion_ot:NULL,
						isset($orden->gerencia)?$orden->gerencia:NULL,
						isset($orden->departamento_ecp)?$orden->departamento_ecp:NULL,
						isset($orden->departamento_ecp)?$this->nombre_departamento_ecp[$orden->departamento_ecp]:NULL,
						isset($orden->estado_doc)?$orden->estado_doc:NULL,
						isset($orden->ot_legalizada)?$orden->ot_legalizada:NULL,
						isset($orden->fecha_inicio)?$orden->fecha_inicio:NULL,
						isset($orden->fecha_fin)?$orden->fecha_fin:NULL,
						isset($orden->presupuesto_fecha_ini)?$orden->presupuesto_fecha_ini:NULL,
						isset($orden->presupuesto_porcent_ini)?$orden->presupuesto_porcent_ini:NULL,
						isset($orden->presupuesto_fecha_fin)?$orden->presupuesto_fecha_fin:NULL,
						isset($orden->presupuesto_porcent_fin)?$orden->presupuesto_porcent_fin:NULL,
						isset($orden->fecha_creacion_cc)?$orden->fecha_creacion_cc:NULL,
						isset($orden->basica)?$orden->basica:FALSE,
						isset($orden->idcontrato)?$orden->idcontrato:NULL
					);
				$this->load->helper('log');
				if (isset($ots->log)) {	addLog($ots->log->idusuario, $ots->log->nombre_usuario, $idot, 'OT', 'Orden '.$orden->nombre_ot.' creada', date('Y-m-d H:i:s'), 'OT CREADA' );	}
				#--------------------------------------------------------------------------------------------
				#Adcionar frentes de trabajo
				$this->frentesOT($orden->frentes, $idot);
				#--------------------------------------------------------------------------------------------
				#Adicionar tarea nueva
				$this->load->model('Tarea_db','tarea');
				$i = 0;
				foreach ($ot->tareas as $tar){
					$i++;
					# creamos la tarea
					$idTr = $this->crearTareaOT($tar, $idot, $tar->nombre_tarea);
					#insertamos los items planeados a la tarea
					$this->insetarITemsTarea($idTr, $tar->personal);
					$this->insetarITemsTarea($idTr, $tar->actividades);
					$this->insetarITemsTarea($idTr, $tar->equipos);
					$this->insetarITemsTarea($idTr, $tar->material);
					$this->insetarITemsTarea($idTr, $tar->otros);
				}
				$status = $this->ot->end_transact();
				if($status){
					if (!isset($dupe)) {
						echo "Orden de trabajo guardada correctamente";
					}else{
						echo 'Orden de trabajo duplicada y guardada con exito';
					}
				}else { echo "No se ha guardado";	}
			} catch (Exception $e) {
				echo "Error al insertar la OT: ".$e->getMessege();
			}
		}
	}
	# ----------------------------------------------------------------------------
	# Frente de trabajo

	# add FRENTE
	public function add_frente($idot=NULL)
	{
		$f = json_decode( file_get_contents("php://input") );
		$this->load->model('ot_db', 'ot');
		$f->OT_idOT = $idot;
		$f->idfrente_ot = $this->ot->addFrenteOT($f);
		$ret = new stdClass();
		$ret->success = 'success';
		$ret->frente = $f;
		$ret->array = (array) $f;
		echo json_encode($ret);
	}

	# Gestiona cuando hay que agregar o modificar frentes de trabajo de una OT.
	private function frentesOT($frente, $idot){
		$this->load->model('ot_db', 'ot');
		foreach ($frente as $key => $f) {
			if(isset($f->idfrente_ot) && $f->idfrente_ot != ''){
				$f->OT_idOT = $idot;
				$idfrente = $f->idfrente_ot;
				$f->idfrente_ot = NULL;
				unset($f->idfrente_ot);
				$this->ot->modFrenteOT($f, $idfrente);
			}else {
				$f->OT_idOT = $idot;
				$this->ot->addFrenteOT($f);
			}
		}
	}
	# ----------------------------------------------------------------------------
	# Crear tarea de OT
	private function crearTareaOT($tar, $idot, $nombre_tarea)
	{
		return $this->tarea->add(
				$nombre_tarea,
				date('Y-m-d', strtotime($tar->fecha_inicio)),
				date('Y-m-d', strtotime($tar->fecha_fin)),
				$tar->valor_recursos,
				$tar->valor_tarea_ot,
				json_encode($tar->json_indirectos),
				json_encode($tar->json_viaticos),
				json_encode($tar->json_horas_extra),
				json_encode($tar->json_reembolsables),
				'',
				json_encode($tar->json_recursos),
			    isset($tar->responsables)?json_encode($tar->responsables):'{}',
			    isset($tar->requisitos_documentales)?json_encode($tar->requisitos_documentales):'{}',
				$idot,
				isset($tar->sap)?$tar->sap:NULL,
				isset($tar->clase_sap)?$tar->clase_sap:NULL,
				isset($tar->tipo_sap)?$tar->tipo_sap:NULL,
				isset($tar->sap_pago)?$tar->sap_pago:NULL,
				isset($tar->clase_sap_pago)?$tar->clase_sap_pago:NULL,
				isset($tar->tipo_sap_pago)?$tar->tipo_sap_pago:NULL,
				isset($tar->editable)?TRUE:TRUE,
				isset($tar->idvigencia_tarifas)?$tar->idvigencia_tarifas:NULL
			);
	}

	# recorrer items de una tarea nueva
	private function insetarITemsTarea($idTr, $items)
	{
		foreach ($items as $item) {
			$this->addNewItemTarea($idTr, $item);
		}
	}

	# agregar nuevos items de una tarea
	public function addNewItemTarea($idTr, $item)
	{
		$this->load->model('Item_db', 'it');
		$this->it->setItemTarea(
				$item->cantidad,
				$item->duracion,
				$item->unidad,
				$item->tarifa,
				($item->tarifa * ($item->cantidad * $item->duracion)),
				date('Y-m-d H:i:s'),
				$item->iditemf,
				$item->codigo,
				$idTr,
				( isset($item->facturable)?$item->facturable:FALSE ),
				( isset($item->idsector_item_tarea)?$item->idsector_item_tarea:NULL ),
				$item->idvigencia_tarifas,// Nuevo preparar BD !!!!!!!!!!
				isset($item->idfrente_ot)?$item->idfrente_ot:NULL// Nuevo preparar BD !!!!!!!!!!
			);
	}
	#=============================================================================
	# LISTAR ORDENES
	public function listOT($tipo=NULL,  $sector=NULL){
		$this->load->model('ot_db');
		$bases = $this->ot_db->getBases($tipo, $sector);
		$this->load->view('ot/lista/listOT', array( 'bases' => $bases ) );
	}

	#=============================================================================
	# Generar OT impresión
	public function imprimirOT($id, $idtr)
	{
		if(isset($id) && isset($idtr)){
		$this->load->helper('pdf');
		$this->load->helper('file');
		//$this->load->helper('download');
		$this->load->model(array('ot_db', 'item_db'));
		$ot = $this->ot_db->getData($id)->row();
		$tr = $this->ot_db->getTarea($id, $idtr)->row();

		$indirectos = json_decode($tr->json_indirectos);
		$viaticos = json_decode($tr->json_viaticos);
		$reembolsables = json_decode($tr->json_reembolsables);
		$horas_extra = json_decode($tr->json_horas_extra);

		$acts = $this->item_db->getItemsByTarea($idtr, 1, TRUE);
		$sub_acts = $this->subtotales($acts);
		$pers = $this->item_db->getItemsByTarea($idtr, 2, TRUE);
		$sub_pers = $this->subtotales($pers);
		$equs = $this->item_db->getItemsByTarea($idtr, 3, TRUE);
		$sub_equs = $this->subtotales($equs);
		$data = array(
			'ot' => $ot,
			'pers'=>$pers,
			'equs'=>$equs,
			'acts'=>$acts,
			'sub_acts'=>$sub_acts,
			'sub_pers'=>$sub_pers,
			'sub_equs'=>$sub_equs,
			'indirectos'=>$indirectos,
			'viaticos'=>$viaticos,
			'reembolsables'=>$reembolsables,
			'horas_extra'=>$horas_extra,
			'tr'=>$tr
		);
		$html = $this->load->view('ot/imprimir/formatoOT',$data,TRUE);
		doPDF($html, $ot->nombre_ot, './uploads/ordenes/');
		//write_file('./uploads/ordenes/'.$titulo.'.pdf', $pdf);
	  //force_download('./uploads/ordenes/'.$titulo.'.pdf', NULL);
		}
	}

	public function imprimirAnexos($id, $idtr)
	{
		$this->load->helper('pdf');
		$this->load->helper('config');
		$this->load->model(array('ot_db', 'item_db'));
		$ot = $this->ot_db->getData($id)->row();
		$tr = $this->ot_db->getTarea($id, $idtr)->row();
		$viaticos = json_decode($tr->json_viaticos);
		$reembolsables = json_decode($tr->json_reembolsables);
		$horas_extra = json_decode($tr->json_horas_extra);

		$html = $this->load->view('ot/imprimir/anexosOT',array('viaticos'=>$viaticos, 'horas_extra'=>$horas_extra, 'nombre_ot'=>$ot->nombre_ot),TRUE);
		//echo $html;
		doPDF($html, $ot->nombre_ot.'-Anexos', './uploads/ordenes/', FALSE);
	}

	public function pruebaImprimir()
	{
		$this->load->helper('pdf');
		$this->load->helper('file');
		$this->load->helper('download');
		$html =$this->load->view('imprimirTEST','',TRUE);
		doPDF($html, 'prueba', './uploads/');
	}
	public function subtotales($items)
	{
		$valor = 0;
		foreach ($items->result() as $value) {
			$valor += $value->valor_plan;
		}
		return $valor;
	}

	# ============================================================================
	# Editar/Ver
	# ============================================================================

	public function edit($id)
	{
		$this->load->model('miscelanio_db');
		$depars = $this->miscelanio_db->getDepartamentos();
		$tipos_ot = $this->miscelanio_db->getTiposOT();
		$especialidades = $this->miscelanio_db->getEspecialidadesOT();
		$sectores = $this->miscelanio_db->getSectorItems();
		$tarifagv = $this->miscelanio_db->getTarifasGV();

		$this->load->model('ot_db');
		$bases = $this->ot_db->getBases();
		$data = array(
			'idot'=>$id,
			'titulo_gestion' => ' Edición de Orden de Trabajo:',
			'depars'=>$depars,
			'tipos_ot'=>$tipos_ot,
			'especialidades'=>$especialidades,
			'clasificacion_ot'=>$this->clasificacion_ot,
			'sectores'=>$sectores,
			'tarifagv'=>$tarifagv,
			'isEdit'=>TRUE,
			'bases'=>$bases
		);
		$this->load->view('ot/edit/editarOT', $data);
	}

	public function update($idOT=NULL){
		$ots = json_decode(file_get_contents('php://input'));
		$ot = $ots->ot;
		$orden = $ots->ot;
		$this->load->model(array('ot_db'=>'ot_db', 'tarea_db'=>'tarea', 'item_db'=>'item', 'Costo_mes_ot'=>'inf_ot' ));
		# inicio de seguimiento de transacciones
		$this->ot_db->init_transact();

		$this->ot_db->update(
				$orden->idOT,
				$orden->nombre_ot,
				$orden->ccosto,
				$orden->base_idbase,
				$orden->zona,
				$orden->fecha_creacion,
				$orden->especialidad_idespecialidad,
				$orden->tipo_ot_idtipo_ot,
				$orden->actividad,
				$orden->justificacion,
				$orden->locacion,
				$orden->abscisa,
				$orden->departamento,
				$orden->municipio,
				$orden->vereda,
				isset($orden->cc_ecp)?$orden->cc_ecp:NULL,
				isset( $orden->json )?json_encode($orden->json):'{"p1":false,"p2":false,"p3":false,"p4":false,"p5":false}',
				isset($orden->clasificacion_ot)?$orden->clasificacion_ot:NULL,
				isset($orden->gerencia)?$orden->gerencia:NULL,
				isset($orden->departamento_ecp)?$orden->departamento_ecp:NULL,
				isset($orden->departamento_ecp)?$this->nombre_departamento_ecp:NULL,
				isset($orden->estado_doc)?$orden->estado_doc:NULL,
				isset($orden->ot_legalizada)?$orden->ot_legalizada:NULL,
				isset($orden->fecha_inicio)?$orden->fecha_inicio:NULL,
				isset($orden->fecha_fin)?$orden->fecha_fin:NULL,
				isset($orden->presupuesto_fecha_ini)?$orden->presupuesto_fecha_ini:NULL,
				isset($orden->presupuesto_porcent_ini)?$orden->presupuesto_porcent_ini:NULL,
				isset($orden->presupuesto_fecha_fin)?$orden->presupuesto_fecha_fin:NULL,
				isset($orden->presupuesto_porcent_fin)?$orden->presupuesto_porcent_fin:NULL,
				isset($orden->fecha_creacion_cc)?$orden->fecha_creacion_cc:NULL,
				isset($orden->basica)?$orden->basica:FALSE,
				isset($orden->idcontrato)?$orden->idcontrato:NULL
			);

		#--------------------------------------------------------------------------------------------
		#Adcionar frentes de trabajo
		$this->frentesOT($orden->frentes, $orden->idOT);
		#--------------------------------------------------------------------------------------------
		# Guardar costos de ot mes a mes
		$this->inf_ot->saveAllMeses($orden->allMeses);

		$this->load->helper('log');
		if (isset($ots->log)) {	addLog($ots->log->idusuario, $ots->log->nombre_usuario, $orden->idOT, 'OT', 'Orden '.$orden->nombre_ot.' modificada', date('Y-m-d H:i:s'), 'OT ACTUALIZADA' );	}
		#--------------------------------------------------------------------------------------------
		# actualizar / guardar tareas
		foreach($orden->tareas as $tr){
			if(isset($tr->idtarea_ot) &&  $tr->idtarea_ot != 0 ){
				$valid = $this->update_tarea($tr);
				$this->recorrerItems($tr->actividades, $tr->idtarea_ot);
				$this->recorrerItems($tr->personal, $tr->idtarea_ot);
				$this->recorrerItems($tr->equipos, $tr->idtarea_ot);
				if (isset($tr->material))
					$this->recorrerItems($tr->material, $tr->idtarea_ot);
				if (isset($tr->otros))
					$this->recorrerItems($tr->otros, $tr->idtarea_ot);
			}else{
				$idTr = $this->crearTareaOT($tr, $orden->idOT, $tr->nombre_tarea);
				$this->insetarITemsTarea($idTr, $tr->personal);
				$this->insetarITemsTarea($idTr, $tr->actividades);
				$this->insetarITemsTarea($idTr, $tr->equipos);
				if (isset($tr->material))
					$this->insetarITemsTarea($idTr, $tr->material);
				if (isset($tr->otros))
					$this->insetarITemsTarea($idTr, $tr->otros);
			}
		}
		# fin de seguimiento de transacciones concapacidad de RollBack
		$status = $this->ot_db->end_transact();
		if($status != FALSE){
			$succ = new stdClass();
			$succ->success = 'Orden de trabajo guardada correctamente';
			$succ->ot = $this->get($orden->idOT);
			echo json_encode($succ);
			//echo "Orden de trabajo guardada correctamente";
		}else{
			echo 'ha sucedido un error inesperado, estamos trabajando para mejorar.';
		}
	}

	# Proceso para actualizar una tarea de una OT
	public function update_tarea($tr){
		return $this->tarea->update(
				$tr->idtarea_ot,
				$tr->nombre_tarea,
				$tr->fecha_inicio,
				$tr->fecha_fin,
				$tr->valor_recursos,
				$tr->valor_tarea_ot,
				json_encode($tr->json_indirectos),
				json_encode($tr->json_viaticos),
				json_encode($tr->json_horas_extra),
				json_encode($tr->json_reembolsables),
				json_encode($tr->json_raciones),
				json_encode($tr->json_recursos),
				isset($tr->responsables)?json_encode($tr->responsables):NULL,
	      isset($tr->requisitos_documentales)?json_encode($tr->requisitos_documentales):NULL,
				$tr->OT_idOT,
				isset($tr->sap)?$tr->sap:NULL,
				isset($tr->clase_sap)?$tr->clase_sap:NULL,
				isset($tr->tipo_sap)?$tr->tipo_sap:NULL,
				isset($tr->sap_pago)?$tr->sap_pago:NULL,
				isset($tr->clase_sap_pago)?$tr->clase_sap_pago:NULL,
				isset($tr->tipo_sap_pago)?$tr->tipo_sap_pago:NULL,
				isset($tr->editable)?$tr->editable:NULL,
				isset($tr->idvigencia_tarifas)?$tr->idvigencia_tarifas:NULL
			);
	}
	# proceso que recorre los items de las tareas e inserta o actualiza los cambios
	public function recorrerItems($items, $idTr){
		foreach($items as $it){
			if(isset($it->iditem_tarea_ot)){
				$this->update_item_tarea($it);
			}else{
				$this->addNewItemTarea($idTr, $it);
			}
		}
	}
	# Proceso que actualiza los items de las tareas
	public function update_item_tarea($it){
		return $this->item->updateItemTarea(
				$it->iditem_tarea_ot,
				$it->cantidad,
				$it->duracion,
				$it->unidad,
				$it->tarifa,
				($it->tarifa * ($it->cantidad * $it->duracion)),
				date('Y-m-d H:i:s'),
				$it->itemf_iditemf,
				$it->itemf_codigo,
				$it->tarea_ot_idtarea_ot,
				isset($it->facturable)?$it->facturable:FALSE,
				( isset($it->idsector_item_tarea)?$it->idsector_item_tarea:NULL ),
				$it->idvigencia_tarifas,// Nuevo preparar BD !!!!!!!!!!
				$it->idfrente_ot
			);
	}

	#=================================================================================
	# DUPLICAR
	#=================================================================================
	# Form duplicar
	public function duplicar($idOT=NULL)
	{
		$this->load->model('miscelanio_db');
		$depars = $this->miscelanio_db->getDepartamentos();
		$tipos_ot = $this->miscelanio_db->getTiposOT();
		$especialidades = $this->miscelanio_db->getEspecialidadesOT();
		$sectores = $this->miscelanio_db->getSectorItems();
		$tarifagv = $this->miscelanio_db->getTarifasGV();

		$this->load->model('ot_db');
		$ots = $this->ot_db->getOtBy('idOT', $idOT);
		$ot = $ots->row();
		$ot->tareas = $this->ot_db->getTareas($idOT)->result();
		$bases = $this->ot_db->getBases();
		$this->load->view('ot/duplicar/duplicar',
			array(
				'ot'=>$ot,
				'titulo_gestion'=>'Duplicado de OT',
				'depars'=>$depars,
				'tipos_ot'=>$tipos_ot,
				'sectores'=>$sectores,
				'especialidades'=>$especialidades,
				'tarifagv'=>$tarifagv,
				'isEdit'=>TRUE,
				'bases'=>$bases
			)
		);
	}

	public function getDupeData()
	{
		$post = json_decode(file_get_contents('php://input'));
		$this->load->model('ot_db');
		$ot = $this->ot_db->getData($post->idOT)->row();
		$ot->idOT = NULL;
		$ot->nombre_ot = NULL;
		$ot->estado_doc = "POR EJECUTAR";
		$ot->json = json_decode($ot->json);
		$ot->tareas = $this->getTareasByOT($post->idOT, $post->tareas);
		$i = 0;
		foreach ($ot->tareas as $key => $val) {
			$val->idtarea_ot = NULL;
			$val->editable = TRUE;
			$val->OT_idOT = NULL;
			$i++;
			if ( $i == 1  ) {	$val->nombre_tarea = 'TAREA INICIAL';	}else {	$val->nombre_tarea = 'TAREA '.$i;	}
			foreach ($val->personal as $k => $v) {
				$v->iditem_tarea_ot = NULL;
				$v->fecha_agregado = NULL;
				$v->tarea_ot_idtarea_ot  = NULL;
			}
			foreach ($val->actividades as $k => $v) {
				$v->iditem_tarea_ot = NULL;
				$v->fecha_agregado = NULL;
				$v->tarea_ot_idtarea_ot  = NULL;
			}
			foreach ($val->equipos as $k => $v) {
				$v->iditem_tarea_ot = NULL;
				$v->fecha_agregado = NULL;
				$v->tarea_ot_idtarea_ot  = NULL;
			}
			foreach ($val->material as $k => $v) {
				$v->iditem_tarea_ot = NULL;
				$v->fecha_agregado = NULL;
				$v->tarea_ot_idtarea_ot  = NULL;
			}
			foreach ($val->otros as $k => $v) {
				$v->iditem_tarea_ot = NULL;
				$v->fecha_agregado = NULL;
				$v->tarea_ot_idtarea_ot  = NULL;
			}
		}
		if(isset($ot)){
			$response = new stdClass();
			$response->success = 'exito';
			$response->ot = $ot;
			echo json_encode($response);
		}else{
			echo 'invalid';
		}
	}

	#=================================================================================
	# Consultas
	#=================================================================================
	# Obtener datos de una OT
	public function get($id)
	{
		$this->load->model(array('ot_db'=>'ot_db','Costo_mes_ot'=>'inf_ot'));
		$ot = $this->ot_db->getData($id)->row();
		$ot->json = json_decode($ot->json);
		$ot->tareas = $this->getTareasByOT($id);
		$ot->frentes = $this->ot_db->getFrentesOT($id)->result();
		$ot->allMeses = $this->inf_ot->getAllMeses($id, NULL);
		return $ot;
	}
	# Obtener datos de una OT en JSON
	public function getData($id)
	{
		$this->load->model(array('ot_db'=>'ot_db','Costo_mes_ot'=>'inf_ot'));
		$ot = $this->ot_db->getData($id)->row();
		$ot->json = json_decode($ot->json);
		$ot->tareas = $this->getTareasByOT($id);
		$ot->frentes = $this->ot_db->getFrentesOT($id)->result();
		$ot->allMeses = $this->inf_ot->getAllMeses($id, NULL);
		echo json_encode($ot);
		#echo '<pre>'.json_encode($ot).'</pre>';
	}
	# Obtener un listado de tareas de una OT
	public function getTareasByOT($id, $arr_tareas=NULL)
	{
		$this->load->model('ot_db');
		$trs = $this->ot_db->getTareas($id, $arr_tareas);
		foreach ($trs->result() as $t) {
			$t->json_indirectos = json_decode($t->json_indirectos);
			$t->json_viaticos = json_decode($t->json_viaticos);
			$t->json_horas_extra = json_decode($t->json_horas_extra);
			$t->json_raciones = json_decode($t->json_raciones);
			$t->json_recursos = json_decode($t->json_recursos);
			$t->json_reembolsables = json_decode($t->json_reembolsables);
			$t->responsables = json_decode($t->responsables);
			$t->requisitos_documentales = json_decode($t->requisitos_documentales);
			$t->actividades = $this->getItemsByTipo($t->idtarea_ot, 1);
			$t->personal = $this->getItemsByTipo($t->idtarea_ot, 2);
			$t->equipos = $this->getItemsByTipo($t->idtarea_ot, 3);
			$t->material = $this->getItemsByTipo($t->idtarea_ot, 'material');
			$t->otros = $this->getItemsByTipo($t->idtarea_ot, 'otros');
			// Materiales
		}
		return $trs->result();
	}

	# Obtener un listado de items por tarea de ot
	public function getItemsByTipo($id, $tipo)
	{
		$this->load->model('tarea_db');
		$items = $this->tarea_db->getItemsByTipo($id, $tipo);
		return $items->result();
	}

	# Obtener un listado de frentes de trabajo de una OT
	public function get_frentes_ot($idot)
	{
		$this->load->model('ot_db', 'ot');
		$ret = $this->ot->getFrentesOT($idot);
		echo json_encode( $ret->result() );
	}

	# ============================================================================
	# Consltas de items
	# ============================================================================

	# Obtener items por tipo [AJAX]
	public function getItemByTipeOT($idOT, $tipo, $llave = NULL)
	{
		$this->load->model('OT_db', 'ot_db');
		$rows = $this->ot_db->getItemByTipeOT($idOT, $tipo);
		echo json_encode($rows->result());
	}

	# Obtener cantidades por item [AJAX]
	public function getCantidadByItemf($item)
	{
		# pendiente
	}

	# Existe orden de trabajo
	public function existeOT($nombre_ot = NULL)
	{
		if(!isset($nombre_ot)){
			$post = json_decode(file_get_contents('php://input'));
			$nombre_ot = $post->nombre_ot;
		}

		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->where('nombre_ot', $nombre_ot);
		$rows = $this->db->get();

		if($rows->num_rows() > 0){
			return true;
		}
		return false;
	}

	# Resumen de tareas
	public function resumenItems($idOT)
	{
		$this->load->model('ot_db', 'ot');
		$frentes = $this->ot->getFrentesOT($idOT);
		if($frentes->num_rows() > 0){
			$resumen = $this->ot->resumenOT($idOT, TRUE);
		}else{
			$resumen = $this->ot->resumenOT($idOT);
		}
		$this->load->view('ot/vista_resumen', array('items'=>$resumen, 'idOT'=>$idOT) );
		//$items = $this->ot->getResumenCantItems($idOT);
		//echo $this->load->view('ot/forms/consolidado', array('items'=>$items), TRUE );
	}

	public function resumenOT($idOT)
	{
		$this->load->model('ot_db', 'ot');
		$frentes = $this->ot->getFrentesOT($idOT);
		if($frentes->num_rows() > 0){
			$resumen = $this->ot->resumenOT($idOT, TRUE);
		}else{
			$resumen = $this->ot->resumenOT($idOT);
		}
		$this->load->view('ot/vista_resumen', array('items'=>$resumen, 'idOT'=>$idOT ) );
	}
	# ===============================================================================
	// Informes de PYCO en excel
	public function getInformes($value='')
	{
		$this->load->view('miscelanios/informesPyco/form_informesPyco.php');
	}

	// BORRADOS

	public function delete($idOT)
	{
		$this->load->database('ot');
		$trs = $this->db->get_where('tarea_ot', array('OT_idOT'=>$idOT));
		foreach ($trs->result() as $key => $value) {
			$this->delete_tarea($value->idtarea_ot);
		}
		$this->del_costos_mes($idOT);
		$this->db->delete('OT', array('idOT'=>$idOT));
		echo "success";
	}
	public function delete_tarea($id)
	{
		$this->load->database('ot');
		$this->db->delete('item_tarea_ot', array('tarea_ot_idtarea_ot'=>$id));
		$this->db->delete('tarea_ot', array('idtarea_ot'=>$id));
	}
	public function del_item_tarea($id)
	{
		$this->load->database('ot');
		$this->db->delete('item_tarea_ot', array('iditem_tarea_ot'=>$id));
		echo 'success';
	}

	private function del_costos_mes($id)
	{
		$this->load->database('ot');
		$this->db->delete('costo_mes_ot', array('OT_idOT'=>$id) );
	}
	private function del_frentes_ot($id)
	{
		$this->load->database('ot');
		$this->db->delete('frente_ot', array('OT_idOT'=>$id) );
	}
}
/* End of file Ot.php */
/* Location: ./application/controllers/Ot.php */
