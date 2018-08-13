<section class="row">
  <h5>Selecciona el informe de PyCO que deseas generar:</h5>

  <section class="noMaterialStyles regularform">

    <!-- filtrar por contrato y CO -->
    <fieldset>
      <legend>Buscar ordenes por:</legend>
      <label>fecha de inicio: <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="fecha_inicio"> </label>
    </fieldset>
  </section>

  <hr>
  <div class="">

    <div class="col l2" ng-if="validPriv(52)">
      <a href="#" ng-click="clickeableLink('<?= site_url('export/form_informe_items') ?>', $event, 'Informes de OTs');" class="btn-panel black-text" style="width:100%">
        <h3 class="center-align" data-icon="&#xe041;"></h3>
        <p class="center-align">Informes Items OT </p>
      </a>
    </div>

    <div class="col l2" ng-show="validPriv(52)">
			<a href="<?= site_url('export/informePYCO') ?>/{{fecha_inicio}}" class="btn-panel  orange darken-3 white-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Informe por tareas de OT's</p>
			</a>
		</div>

		<div class="col l2" ng-show="validPriv(52)">
			<a href="<?= site_url('export/informeOtPyco') ?>/{{fecha_inicio}}" class="btn-panel black-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Informe consolidado por OT's</p>
			</a>
		</div>



    <div class="col l2" ng-if="validPriv(52)">
      <a href="#" ng-click="clickeableLink('<?= site_url('consulta/consolidadoOT') ?>', $event, 'Informes de OTs');" class="btn-panel black-text" style="width:100%">
        <h3 class="center-align" data-icon="&#xe041;"></h3>
        <p class="center-align">Informes costos por APU por OT </p>
      </a>
    </div>
  </div>
</section>
