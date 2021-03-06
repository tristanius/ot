	<div>
		<section class="row">
			<h5>Maestros de OT/Reportes diarios</h5>

			<div class="col l2" ng-show="validPriv(41)">
				<a href="#" ng-click="clickeableLink('<?= site_url('recurso/recursosOT') ?>', $event, 'Recursos de OT');" class="btn-panel" style="width:100%">
					<h3 class="center-align" data-icon="&#xe050;"></h3>
					<p class="center-align">Recursos x OT</p>
				</a>
			</div>

			<div class="col l2" ng-show="validPriv(64)">
				<a href="#" ng-click="clickeableLink('<?= site_url('persona/byOT') ?>', $event, 'Personal por OT');" class="btn-panel" style="width:100%">
					<h3 class="center-align" data-icon="&#xe047;"></h3>
					<p class="center-align">Personal x OT</p>
				</a>
			</div>

			<div class="col l2">
				<a href="#" class="btn-panel" ng-show="validPriv(48) || validPriv(65)" style="width:100%"  ng-click="clickeableLink('<?= site_url('equipo/listado/edit') ?>', $event, 'Equipos por OT');">
					<h3 class="center-align" data-icon="&#xe042;"></h3>
					<p class="center-align">Equipos X OT</p>
				</a>
			</div>

			<div class="col l2"  ng-show="validPriv(48) || validPriv(65)">
				<a href="#" class="btn-panel" style="width:100%" ng-click="clickeableLink('<?= site_url('equipo/listado') ?>', $event, 'Equipos');">
					<h3 class="center-align" data-icon="&#xe042;"></h3>
					<p class="center-align">Equipos</p>
				</a>
			</div>

		</section>

		<hr class="col l12 m12 s12">

		<section class="row" ng-show="validPriv(42)">
			<h5>Maestros de la aplicación</h5>

			<div class="col l2" ng-show="validPriv(64)">
				<a href="#" ng-click="clickeableLink('<?= site_url('persona/listado') ?>', $event, 'Personal');" class="btn-panel" style="width:100%">
					<h3 class="center-align" data-icon="&#xe047;"></h3>
					<p class="center-align">Personal</p>
				</a>
			</div>

			<div class="col l2" ng-show="validPriv(48) || validPriv(65)">
				<a href="#" class="btn-panel" style="width:100%" ng-click="clickeableLink('<?= site_url('equipo/listado') ?>', $event, 'Equipos');">
					<h3 class="center-align" data-icon="&#xe042;"></h3>
					<p class="center-align">Equipos</p>
				</a>
			</div>

			<div class="col l2" ng-if="validPriv(73)">
				<a href="#" ng-click="clickeableLink('<?= site_url('historicoFacturacion/cargue_historico/') ?>', $event, 'Cargue de historico');" class="btn-panel" style="width:100%">
					<h4 class="center-align" data-icon="&#xe015;"></h4>
					<p class="center-align"> Historicio de facturación </p>
				</a>
			</div>

			<div class="col l2" ng-if="validPriv(1)">
				<a href="#" ng-click="clickeableLink('<?= site_url('tarifa/form_upload') ?>', $event, 'Tarifas internas');" class="btn-panel" style="width:100%">
					<h3 class="center-align" data-icon="*"></h3>
					<p class="center-align">ITEM por cod. interno</p>
				</a>
			</div>
		</section>

	</div>
