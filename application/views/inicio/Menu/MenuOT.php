	<div class="row">
		<h3>Gestión de Ordenes de trabajo</h3>

		<div class="col l2"  ng-if"validPriv(37) || validPriv(59)">
			<a href="#" ng-click="clickeableLink('<?= site_url('ot/listOT') ?>', $event, 'Gestion de OTs');" class="btn-panel" style="width:100%">
				<h3 class="center-align" data-icon="&#xe03e;"></h3>
				<p class="center-align">Gestión de ordenes  de trabajo </p>
			</a>
		</div>

	</div>
