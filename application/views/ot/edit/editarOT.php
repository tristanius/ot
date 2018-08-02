<div class="windowCentered2 row" ng-controller="editarOT">
	<section class="area" >
		<div class="btnWindow">
		    <h5 ng-init="getData('<?= site_url('ot/getData/'.$idot) ?>')">
					<img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="80px" />
					<?= $titulo_gestion ?>
					<img ng-if="validPriv(56)" src="<?= base_url('assets/img/info.png') ?>" width="15" ng-click="getLogMovimientos( '<?= site_url('miscelanio/getLog') ?>' , <?= $idot ?>, 'OT')">
				</h5>
	   </div>

		<!-- Información de la básica OT -->
		<table class="mytabla" ng-init="getFormData('<?= site_url('Ot/getDataNewForm') ?>')">
			<thead>
				<tr style="background: #3A4B52; color: #FFF">
					<th>Nombre de OT</th>
					<th>C.O. / Oficina</th>
					<th>Zona</th>
					<th>Especialidad</th>
					<th>Tipo OT</th>
					<th>C.C. ECP</th>
					<th>clasificacion </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<span ng-show="!validPriv(54)" ng-bind="ot.nombre_ot"></span>
						<input type="text" ng-model="ot.nombre_ot" ng-show="validPriv(54)">
					</td>
					<td>
						<span ng-show="!validPriv(54)" ng-bind="ot.base_idbase"></span>
						<select ng-show="validPriv(54)" class="col m7" ng-model="ot.base_idbase" >
							<option ng-repeat="base in log.bases" value="{{ base.idbase }}">{{base.idbase + " - "+ base.nombre_base}}</option>
						</select>
					</td>
					<td ng-bind="ot.zona"></td>
					<td>
						<div ng-show="!validPriv(54)" ng-bind="ot.nombre_especialidad"></div>
						<select ng-show="validPriv(54)" style="width: 50%" id="especialidad_idespecialidad" ng-model="ot.especialidad_idespecialidad">
							<option value="">seleccione una opción</option>
							<?php foreach ($especialidades->result() as $esp) {
								?>
								<option value="<?= $esp->idespecialidad ?>"><?= $esp->nombre_especialidad ?></option>
								<?php
							} ?>
						</select>
					</td>
					<td>
						<div ng-show="!validPriv(54)" ng-bind="ot.nombre_tipo_ot"></div>
						<select ng-show="validPriv(54)" style="width: 50%" id="tipo_ot_idtipo_ot" ng-model="ot.tipo_ot_idtipo_ot">
							<option value="">seleccione una opción</option>
							<?php foreach ($tipos_ot->result() as $tp) {
								?>
								<option value="<?= $tp->idtipo_ot ?>"><?= $tp->nombre_tipo_ot ?></option>
								<?php
							} ?>
						</select>
					</td>
					<td>
						<input type="text" style="width:10ex;" ng-model="ot.cc_ecp" ><!-- Campo habilitado a todos en PYCO -->
						<!-- <input type="text" ng-model="ot.cc_ecp" ng-if="validPriv(54)" readonly> -->
					</td>
					<td>
						<select style="width:10ex;" ng-model="ot.clasificacion_ot">
							<?php foreach ($clasificacion_ot as $cl): ?>
								<option value="<?= $cl ?>"><?= $cl ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						C.C. Termotecnica:
					</td>
					<td>
						<input type="text" ng-model="ot.ccosto" ><!-- Campo habilitado a todos en PYCO -->
						<!-- <input type="text" ng-model="ot.ccosto" ng-if="validPriv(54)" readonly> -->
					</td>
					<td class="noMaterialStyles regularForm"> Orden Basica: <input type="checkbox" ng-model="ot.basica"  ng-false-value="'0'"  ng-true-value="'1'"/></td>
					<td colspan="4">
						Valor OT: <span ng-bind="ot.valor_ot | currency"></span>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr style="background: #3A4B52; color: #FFF">
					<th>Gerencia</th>
					<th>Departamento ECP</th>
					<th colspan="2"></th>
					<th colspan="3"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<select class="noMaterialStyles" ng-model="ot.gerencia">
							<option value="GOT">GOT: OLEDUCTOS</option>
							<option value="GPO">GPO: POLIDUCTOS</option>
							<option value="GPT">GPT: FLUVIAL</option>
							<option value="N/A">N/A</option>
						</select>
					</td>
					<td>
						<select class="noMaterialStyles" ng-model="ot.departamento_ecp">
							<?php foreach ($this->nombre_departamento_ecp as $key => $value): ?>
								<option value="<?= $key ?>"><?= $value ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td colspan="2"> <span ng-bind="ot.no_contrato"></span> <span ng-bind="ot.contratista"></span> </td>
					<td colspan="3"></td>
				</tr>
			</tbody>
		</table>
		<!-- Panel de opciones -->
		<style type="text/css">
			.inset{
				box-shadow: inset 0px 0px 5px #AAA;
			}
			.mypanel{
				border: 1px solid #AAA;
				padding: 3px;
				margin-bottom: 5px;
				overflow: auto;
			}
			.mybtn{
				background: #FFF;
				color: #111;
				border:1px solid #555;
			}
		</style>

		<div class="row">
			<br>
			<!-- seleccion de tarea -->
			<div class="noMaterialStyles" ng-show="!showCopiar" ng-init="showCopiar = false">
				<label>Selecciona una Tarea: </label>
				<select id="selected_tarea" ng-model="mytr"	ng-options="tarea as (tarea.nombre_tarea) for tarea in ot.tareas track by $index">
				</select>
				<button class="btn mini-btn" style="margin-top: 0" data-icon="&#xe052;" ng-click="addTarea()"></button>
				&nbsp;
				<!--
				<a href="<?= site_url('ot/imprimirOT') ?>/{{ot.idOT +'/'+ tr.idtarea_ot}}" class="btn mini-btn orange black-text"  style="margin-top: 0" data-icon=";"></a>
				<a href="<?= site_url('ot/imprimirAnexos') ?>/{{ot.idOT +'/'+ tr.idtarea_ot}}" class="btn mini-btn amber black-text"  style="margin-top: 0"> <small>H.E./G.V.</small> </a>
				-->

			</div>

			<?php $this->load->view("ot/edit/copiar_tarea"); ?>

			<section class="row"  ng-show="!showCopiar">
				<div class="col s6 m2 l2" style="border:1px solid #CCC; padding:3px;">
					<h6>Información de O.T.:</h6>
					<button class="btn blue mini-btn2" ng-click="toggleContent('#descripcion', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato">Descripción</button>
					<button class="btn teal accent-4 mini-btn2" ng-click="toggleContent('#frentes', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato">Frentes</button>
				</div>

				<div class="col s6 m6 l6" style="border:1px solid #CCC; padding:3px;">
					<h6>Planeación Tarea:</h6>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#planeacion', 'nodisplay', '.mypanel > div')" ng-show="ot.estado_doc !='FINALIZÓ' " ng-disabled="!ot.idcontrato">Recursos</button>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#indirectos_ot', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato">G.V. / H.E / Otros</button>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#responsabilidades', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato">Requisitos</button>
				</div>

				<div class="col s6 m2 l2" style="border:1px solid #CCC; padding:3px;">
					<h6>Consulta:</h6>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#general', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato">General</button>
					<button class="btn blue mini-btn2" ng-click="toggleContent('#info_general', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato">Inf. adicional de O.T.</button>
				</div>

				<div class="col s6 m2 l2" style="border:1px solid #CCC; padding:3px;">
					<h6>Resumen:</h6>
					<button class="btn blue darken-4 orange mini-btn2" ng-click="getResumenGeneral('<?= site_url('ot/resumenItems/'.$idot) ?>')" ng-disabled="!ot.idcontrato">resumen</button>
				</div>
			</section>
		</div>

		<!-- panel de contenidos -->
		<div class="mypanel inset"  ng-show="!showCopiar">

			<div id="descripcion" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/info'); ?>
			</div>

			<div id="frentes" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/frentes'); ?>
			</div>

			<div id="planeacion" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/planeacion', array('sectores'=>$sectores)) ?>
			</div>

			<div id="indirectos_ot" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/indirectos_ot') ?>
			</div>

			<div id="general" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/resumen') ?>
			</div>

			<div id="responsabilidades" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/responsabilidades') ?>
			</div>

			<div id="info_general" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/info_general') ?>
			</div>

			<div id="resumenItems" class="nodisplay">
			</div>

		</div>
		<br>

		<img src="<?= base_url('assets/img/ajax-loader.gif') ?>" ng-show="loader">

		<!-- opciones -->
		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-if="validPriv(37)" ng-click="guardarOT('<?= site_url('ot/update') ?>')">Guardar</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindowLocal('#ventanaOT', enlaceGetOT)">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow2('#ventanaOT', '#ventanaOTOculta')">Ocultar</button>
	  </div>

	</section>
</div>
