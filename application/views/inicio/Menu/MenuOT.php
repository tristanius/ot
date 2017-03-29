	<div class="row">
		<h3>Gestión de Ordenes de trabajo</h3>

		<div class="col l2"  ng-if"validPriv(37) || validPriv(59)">
			<a href="#" ng-click="clickeableLink('<?= site_url('ot/listOT') ?>', $event, 'Gestion de OTs');" class="btn-panel" style="width:100%">
				<h3 class="center-align" data-icon="&#xe03e;"></h3>
				<p class="center-align">Gestión de ordenes  de trabajo </p>
			</a>
		</div>

		<div class="col l2" ng-if="validPriv(52)">
			<a href="#" ng-click="clickeableLink('<?= site_url('ot/getInformes') ?>', $event, 'Informes de OTs');" class="btn-panel" style="width:100%">
				<h3 class="center-align" data-icon="&#xe03b;"></h3>
				<p class="center-align">Informes de PyCO de OT´s </p>
			</a>
		</div>

	</div>
