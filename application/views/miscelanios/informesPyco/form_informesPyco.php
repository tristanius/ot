<section class="row">
  <h5>Selecciona el informe de PyCO que deseas generar:</h5>
  <hr>
  <div class="">
    <div class="col l2" ng-show="validPriv(52)">
			<a href="<?= site_url('export/informePYCO') ?>" class="btn-panel  orange darken-3 white-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Informe por tareas PyCO V1</p>
			</a>
		</div>

		<div class="col l2" ng-show="validPriv(52)">
			<a href="<?= site_url('export/informeOtPyco') ?>" class="btn-panel lime lighten-1 black-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Informe sabana de ordenes V2</p>
			</a>
		</div>
  </div>
</section>
