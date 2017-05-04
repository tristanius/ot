<div id="add-reporte" class="windowCentered2 row" ng-controller="editReporte">
    <script type="text/javascript">
      $(document).ready(function(){
        $('.sticked').stickyRows();
      });
    </script>
    <div class="" ng-init="getDataInfo('<?= site_url('reporte/getRecursos/'.$r->idreporte_diario) ?>');">
      <?php $this->load->view('reportes/edit/duplicar'); ?>

      <section class="area reportes" ng-init="site_url = '<?= site_url() ?>'">
        <div class="btnWindow">
          <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
          <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindowLocal('#ventanaReporte', enlaceGetReporte)">Salir</button>
          <button type="button" class="waves-effect waves-light btn" ng-click="formDuplicar()">Duplicar</button>
          <img ng-if="validPriv(56)" src="<?= base_url('assets/img/info.png') ?>" width="15" ng-click="getLogMovimientos( '<?= site_url('miscelanio/getLog') ?>' , <?= $r->idreporte_diario ?>, 'reporte_diario')">
        </div>
      </section>
      <h5 class="center-align" style="border:1px solid #2196F3;  padding:2px;"> Reporte Diario (producción): <?= $r->nombre_ot ?> </h5>

      <style>
        button.btn, button.mini-btn2{
          margin-top: 0;
        }
        .noHoverColor {
          background: #FFF;
        }
        .mypanel{
          border:3px solid #888;
          min-height: 30px;
          min-width: 100%;
          overflow: auto;
          /*box-shadow: 0px 0px 10px #AAA inset;*/
        }
        .mypanel input:disabled, .mypanel input[readonly]{
          color:#111;
        }
        .mypanel input[type="checkbox"]:checked{
          color: #000;
        }
      </style>

      <form class="hidden" action="#">
        <input type="hidden" ng-model="rd.idreporte_diario" ng-init="rd.idreporte_diario = '<?= $r->idreporte_diario ?>' ">
        <input type="hidden" ng-model="rd.idbase" ng-init="rd.idbase = '<?= $r->base_idbase ?>' ">
        <input type="hidden" ng-model="rd.info.idOT" ng-init="rd.info.idOT = '<?= $r->idOT ?>'">
        <input type="hidden" ng-model="rd.info.ccosto" ng-init="rd.info.ccosto = '<?= $r->ccosto ?>'">
        <input type="hidden" ng-model="rd.nombre_ot" ng-init="rd.nombre_ot = '<?= $r->nombre_ot ?> '">
      </form>

      <div class="font12">
        <table class="mytabla centered">
          <thead>
            <tr style="background: #6FA5ED">
              <th>No. de O.T.:</th>
              <th>Fecha reporte (Y/m/d): </th>
              <th>Estado</th>
              <th>Secciones: </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><b><?= $r->nombre_ot ?></b> <input type="hidden" ng-model="rd.info.nombre_ot" ng-init="rd.info.nombre_ot = '<?= $r->nombre_ot ?>'"> </td>
              <td>
                <b ng-bind="rd.info.fecha_reporte"></b>
                <input type="hidden" ng-model="rd.fecha_reporte" ng-init="rd.fecha_reporte = '<?= $r->fecha_reporte ?>'">
                -  ( <?= $diasemana ?> )
              </td>
              <td class="noMaterialStyles">
                <?php if (TRUE): ?>
                  <span ng-bind="rd.info.estado"></span>
                <?php else: ?>

                <?php endif; ?>
              </td>
              <td>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#info', 'nodisplay', '.mypanel > div')" data-icon="&#xe021;"> Detalles Reporte</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#recursosOT', 'nodisplay', '.mypanel > div')" data-icon="+"> Tiempo/Recursos</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#firmas', 'nodisplay', '.mypanel > div')" data-icon="^">Firmas</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#observacion', 'nodisplay', '.mypanel > div')" data-icon="&#xe03d;"> Observaciones</button>
                <button type="button" ng-show="validPriv(45)" class="btn mini-btn orange" ng-click="toggleContent('#validaciones', 'nodisplay', '.mypanel > div')">Validaciones</button>
              </td>
            </tr>
            <tr class="noMaterialStyles">
              <td>Festivo: <input type="checkbox" ng-model="rd.info.festivo" ng-init="rd.info.festivo = <?= $r->festivo ?>" ng-disabled="rd.info.estado == 'CERRADO' "></td>
              <td colspan="">
                Tiempo Laborado: <a class="btn cyan mini-btn2" ng-href="<?= site_url('reportepersonal/tiempolaborado/'.$r->idOT.'/'.$r->idreporte_diario)?>" target="_blank" data-icon="&#xe048;">  </a>
              </td>
              <td>
                Reporte día: <a class="btn mini-btn2" ng-href="<?= site_url('export/reportePDF/'.$r->idOT.'/'.$r->idreporte_diario) ?>" target="_blank" data-icon="h">  </a>
              </td>
              <td>
                <div class="row regularForm" >
                  <div class="col s6 m3 l2">
                    ( <span style="color:#4CAF50" ng-bind="rd.info.validado_pyco"></span> )
                  </div>
                  <span ng-if="validPriv(38)">
                    <div ng-if="myestado_doc.indicador_validacion == 'elaborador' " class="col s6 m3 l2">Aplicar estado: </div>
                  	<div ng-if="myestado_doc.indicador_validacion == 'elaborador' " class="col s6 m4 l4">
                  	  <select class="" ng-model="selected_validacion_doc2">
                    		<option ng-if="myestado_doc.anterior_validacion_doc != null" value="{{ myestado_doc.anterior_validacion_doc }}">{{myestado_doc.anterior_label}}</option>
                    		<option ng-if="myestado_doc.siguiente_validacion_doc != null" value="{{ myestado_doc.siguiente_validacion_doc }}">{{myestado_doc.siguiente_label}}</option>
                  	  </select>
                    	<button type="button" class="btn mini-btn corregirrd" ng-if="selected_validacion_doc2" ng-click="appyEstadoDoc(selected_validacion_doc2)">Aplicar.</button>
                  	</div>
                  </span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <br>

      <div class="mypanel">
        <div id="info" class="font11"> <?php $this->load->view('reportes/form/info'); ?> </div>
        <div id="recursosOT" class="font11 nodisplay"> <?php $this->load->view('reportes/form/recursosOT', array('ot'=>$r, 'un_equipos'=>$un_equipos, 'item_equipos'=>$item_equipos, 'estados_labor'=>$estados_labor)); ?> </div>
        <div id="firmas" class="font11 nodisplay"> <?php $this->load->view('reportes/form/firmas'); ?> </div>
        <div id="observacion" class="font11 nodisplay"> <?php $this->load->view('reportes/form/observaciones'); ?> </div>
        <div id="validaciones" class="font11 nodisplay"> <?php $this->load->view('reportes/form/validaciones'); ?> </div>
      </div>
      <br>


	  <div>
		<section>
			<div class="" ng-repeat="obsp in rd.observaciones_pyco track by $index">
			  <hr>
			  Observación <span ng-bind="obsp.fecha"></span> | ( <span ng-bind="obsp.usuario"></span> ):
			  <p style="padding:1ex; border:1px solid #CCC; margin:1px;" ng-bind="obsp.msj"></p>
			</div>
		</section>
	  </div>
	  <br>

      <div class="btnWindow">

        <button id="guardar_reporte" type="button" class="waves-effect waves-light btn mini-btn2" ng-if=" (validPriv(38) || validPriv(45) || validPriv(46) ) "
            ng-click="guardarRD('<?= site_url('reporte/insert') ?>', '<?= site_url('reporte/update') ?>')">
          <b data-icon="&#xe015;"></b> Guardar
        </button>
        <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow2('#ventanaReporte', '#ventanaReporteOCulta')" data-icon="&#xe036;"> Ocultar</button>
        <button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="cerrarWindowLocal('#ventanaReporte', enlaceGetReporte)" data-icon="n"> Cerrar</button>
      </div>
    </div>

  </div>
