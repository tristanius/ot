<div class="row">
	<section class="area">
    <h4>Carga de personal para asociar a normina</h4>

    <div class="" ng-init="initAdjunto('<?= site_url("MigracionReporte/uploadTraferenciaRecursos") ?>')">
      <div id="fileuploader">Archivo</div>
    </div>

		<br>
		Estructura del cargue (Formato libro de excel ó .xlsx):
		<br>
		<img style="border:2px solid #999; max-width:1200px" src="<?= base_url('assets/img/trasladoRecursosReportados.png'); ?>" alt="" />
		<br>

		<section id="resultado" style="overflow:auto; max-height: 200px;">

		</section>

    <br>
    <div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="IniciarUploadAdjunto()">Realizar carga</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cargaTraslado=false">Cerrar</button>
	  </div>
  </section>
</div>
