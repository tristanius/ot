	<div class="row">
		<h3>Gestión de Ordenes de trabajo</h3>

		<div class="col l2">
			<a href="#" ng-click="clickeableLink('<?= site_url('ot/listOT') ?>', $event, 'Gestion de OTs');" class="btn-panel" style="width:100%">
				<h3 class="center-align" data-icon="&#xe03e;"></h3>
				<p class="center-align">Gestión de OT´s </p>
			</a>
		</div>

		<div class="col l2" ng-show"validPriv(52)">
			<a href="<?= site_url('export/informePYCO') ?>" class="btn-panel  orange darken-3 white-text" style="width:100%">
				<h3 class="center-align" data-icon="x"></h3>
				<p class="center-align">Inf. sabana de PyCO (70%)</p>
			</a>
		</div>

	</div>
