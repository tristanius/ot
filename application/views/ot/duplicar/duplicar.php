<div class="windowCentered2 row" ng-controller="OT">
	<section class="area" ng-controller="editarOT">

		<section ng-controller="duplicarOT">
		  <div ng-show="myot.show" ng-init="myot.show = true">
		    <h5>Nombre de la O.T. a copiar: <?= $ot->nombre_ot ?> </h5>
				<hr>
		    <input type="hidden" ng-model="myot.idOT" value="<?= $ot->idOT ?>" ng-init="myot.idOT = '<?= $ot->idOT ?>'">
		    <div class="noMaterialStyles">
		      <?php foreach ($ot->tareas as $key => $val): ?>
		      <div class="row">
		        <input type="checkbox"
		            ng-model="tarea<?= $val->idtarea_ot ?>"
		            name="tarea"
		            ng-change="delAddFromList(myot.tareas, <?= $val->idtarea_ot ?>)"
		            value="<?= $val->idtarea_ot ?>"
		            class="col s1 m1 l1">
						<b class="col s11 m11 l11"> <?= $val->nombre_tarea ?> </b>
		      </div>
		      <?php endforeach; ?>
		    </div>

				<hr>

				<div class="">
					<button type="button" class="waves-effect waves-light btn green mini-btn2" ng-click="getDuplicateOT('<?= site_url('ot/getDupeData') ?>', myot)">Duplicar</button>
					<button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="cerrarWindow()">Cerrar</button>
				  <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow()">Ocultar</button>
				</div>
		  </div>


		  <div ng-show="!myot.show">
		    <?php $this->load->view('ot/duplicar/add_ot',array('ot'=>$ot)); ?>
		  </div>
		</section>

	</section>
</div>
