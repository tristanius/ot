<div>
	<section class="area" ng-controller="addTarifa">
    <h4>Carga de nuevas itemF</h4>

    <div class="" ng-init="initAdjunto('<?= site_url("tarifa/upload_doc") ?>')">
      <button id="FileUploader">Archivo</button>
    </div>

		<br>
		<img style="border:2px solid #999; width:100%; max-width:1200px" src="<?= base_url('assets/img/cargueequipos.png'); ?>" alt="" />
		<br>

		<section id="resultado" style="overflow:auto; max-height: 200px;">

		</section>

		<br>
    <div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="IniciarUploadAdjunto()">Realizar carga</button>
			<button type="button" id="btn-validar" class="nodisplay btn mini-btn" ng-click="go('<?= site_url('tarifa/validar') ?>')">Validar</button>
			<button type="button" id="confirmar" class="nodisplay btn mini-btn green" ng-click="submit('<?= site_url('tarifa/aplicar') ?>')">Confirmar</button>
	  </div>
  </section>
</div>
