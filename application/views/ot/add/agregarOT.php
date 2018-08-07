<div class="windowCentered2 row" ng-controller="agregarOT">
	<section class="area">

		<div class="btnWindow">
	    <h5>
				<img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="80px" />
				<?= $titulo_gestion ?>
			</h5>
	  </div>

		<!-- Información de la básica OT -->
		<table class="mytabla" ng-init="getFormData('<?= site_url('Ot/getDataNewForm') ?>')">
			<thead>
				<tr style="background: #3A4B52; color: #FFF">
					<th>Nombre de OT</th>
					<th>C.O./Oficina</th>
					<th>Zona</th>
					<th>Especialidad</th>
					<th>Tipo OT</th>
					<th>C.C. ECP</th>
					<th>Clasificacion</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> <input type="" ng-model="ot.nombre_ot"> </td>
					<td>
						<select class="col m7" ng-model="ot.base_idbase" id="bases">
							<option value=""> Seleccione una base </option>
							<option ng-repeat="base in log.bases" value="{{ base.idbase }}">{{base.idbase + " - "+ base.nombre_base}}</option>
						</select>
					</td>
					<td>
						<select name="zona" id="zona" id="zona" ng-model="ot.zona">
							<option value="N/A">N/A</option>
							<option value="NORTE" selected=selected"">NORTE</option>
							<option value="CENTRO_ORIENTE">CENTRO_ORIENTE</option>
							<option value="OCCIDENTE">OCCIDENTE</option>
							<option value="SUR">SUR</option>
							<option value="LLANOS_ANDINA">LLANOS_ANDINA</option>
							<option value="General">General</option>
						</select>
					</td>
					<td>
						<select name="" style="width: 50%" id="espacialiad" ng-model="ot.especialidad">
							<option value="">seleccione una opción</option>
							<?php foreach ($especialidades->result() as $esp) {
								?>
								<option value="<?= $esp->idespecialidad ?>"><?= $esp->nombre_especialidad ?></option>
								<?php
							} ?>
						</select>
					</td>
					<td>
						<select name="" style="width: 50%" id="tipo_ot" ng-model="ot.tipo_ot">
							<option value="">seleccione una opción</option>
							<?php foreach ($tipos_ot->result() as $tp) {
								?>
								<option value="<?= $tp->idtipo_ot ?>"><?= $tp->nombre_tipo_ot ?></option>
								<?php
							} ?>
						</select>
					</td>

					<td>
						<input type="text"  style="width:10ex;" ng-model="ot.cc_ecp" ><!-- Campo habilitado a todos en PYCO
						<input type="text" ng-model="ot.cc_ecp" ng-if="validPriv(54)" readonly> -->
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
						C.C. termotecnica:
					</td>
					<td>
						<input type="text" ng-model="ot.ccosto" ><!-- Campo habilitado a todos en PYCO
						<input type="text" ng-model="ot.ccosto" ng-if="validPriv(54)" readonly> -->
					</td>
					<td class="noMaterialStyles regularForm">Orden Basica: <input type="checkbox" ng-model="ot.basica"  ng-false-value="'0'"  ng-true-value="'1'"/></td>
					<td colspan="4">
						Valor OT: <span ng-bind="ot.valor_ot | currency"></span>
					</td>
				</tr>
			</tbody>

			<thead style="background: #3A4B52; color: #FFF">
				<tr>
					<th>Gerencia</th>
					<th>Sistemas ECP</th>
					<th colspan="2">Contrato (Macro)</th>
					<th colspan="3"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<select class="noMaterialStyles" ng-model="ot.gerencia" ng-init="ot.gerencia = 'N/A'">
							<option value="N/A">N/A</option>
							<option value="GOT">GOT: OLEDUCTOS</option>
							<option value="GPO">GPO: POLIDUCTOS</option>
							<option value="GPT">GPT: FLUVIAL</option>
						</select>
					</td>
					<td>
						<select class="noMaterialStyles" ng-model="ot.departamento_ecp" ng-init="ot.departamento_ecp = 'N/A'">
							<option value="N/A">N/A</option>
							<option value="PCL">PCL</option>
							<option value="OBC">OBC</option>
							<option value="PNO">PNO</option>
							<option value="PFL">PFL</option>
							<option value="POR">POR</option>
						</select>
					</td>
					<td colspan="2">
						<select ng-model="ot.idcontrato" ng-options="c.idcontrato as (c.no_contrato+' '+c.contratista) for c in contratos track by c.idcontrato" ng-disabled="ot.vigencias"></select>
					</td>
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
			<div class="noMaterialStyles">
				<label>Selecciona una Tarea: </label>
				<select ng-model="tr"	ng-options="tarea.nombre_tarea for tarea in ot.tareas" ng-change="getItemsVg('<?= site_url('vigencia/get_tarifas') ?>/'+tr.idvigencia_tarifas)"></select>
				<button class="btn mini-btn" style="margin-top: 0" data-icon="&#xe052;" ng-click="addTarea()"></button>
				&nbsp;
			</div>

			<section class="row">
				<div class="col s12 m2 l2" style="border:1px solid #CCC; padding:3px;">
					<h6>Descripcion de la O.T.: </h6>
					<button class="btn blue mini-btn2" ng-click="toggleContent('#descripcion', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> Descripción</button>
					<button class="btn teal accent-4 mini-btn2" ng-click="toggleContent('#frentes', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> Frentes</button>
				</div>

				<div class="col s12 m6 l5" style="border:1px solid #CCC; padding:3px;">
					<h6>Planeación Tarea: </h6>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#planeacion', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> Recursos</button>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#indirectos_ot', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> G.V. / H.E / Otros</button>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#responsabilidades', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> Requisitos</button>
				</div>

				<div class="col s12 m4 l5" style="border:1px solid #CCC; padding:3px;">
					<h6>Vista general: </h6>
					<button class="btn blue darken-4 mini-btn2" ng-click="toggleContent('#general', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> General</button>
					<button class="btn blue mini-btn2" ng-click="toggleContent('#info_general', 'nodisplay', '.mypanel > div')" ng-disabled="!ot.idcontrato"> Inf. adicional de O.T.</button>
				</div>
			</section>
			<!-- <button class="btn blue darken-4 orange mini-btn" ng-click="toggleContent('#resumen', 'nodisplay', '.mypanel > div')">resumen</button> -->
		</div>

		<!-- panel de contenidos -->
		<div class="mypanel inset">

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

		</div>

		<br>

		<img src="<?= base_url('assets/img/ajax-loader.gif') ?>" ng-show="loader" width="50">

		<!-- opciones -->
		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-if="validPriv(37)" ng-click="guardarOT('<?= site_url('ot/saveOT') ?>', '<?= site_url('ot/getBy') ?>')"> Finalizar</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindowLocal('#ventanaOT', enlaceGetOT)">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow2('#ventanaOT', '#ventanaOTOculta')">Ocultar</button>
	  	</div>

	</section>
</div>
