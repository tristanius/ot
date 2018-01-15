<section class="row">
  <h5>Selecciona el informe de PyCO que deseas generar:</h5>

  <section class="noMaterialStyles regularform">
    <fieldset>
      <legend>Buscar ordenes por:</legend>
      <label>fecha de inicio: <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="fecha_inicio"> </label>
    </fieldset>
  </section>

  <hr>
  <div class="">
    <div class="col l2" ng-show="validPriv(52)">
			<a href="<?= site_url('export/informePYCO') ?>/{{fecha_inicio}}" class="btn-panel  orange darken-3 white-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Informe por tareas PyCO V1</p>
			</a>
		</div>

		<div class="col l2" ng-show="validPriv(52)">
			<a href="<?= site_url('export/informeOtPyco') ?>/{{fecha_inicio}}" class="btn-panel lime lighten-1 black-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Informe sabana de ordenes V2</p>
			</a>
		</div>
  </div>
</section>
