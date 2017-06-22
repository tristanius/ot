<div class="windowCentered2 row">
	<section class="area" ng-controller="personalUp">
    <h4>Carga de personal para asociar a normina</h4>

    <div class="" ng-init="initAdjunto('<?= site_url("reportepersonal/uploadValidacionHorario") ?>')">
      <div id="fileuploader">Archivo</div>
    </div>

		<br>
		Estructura del cargue de personal (Formato libro de excel ó .xlsx):
		<small>Se debe respetar las columnas en blanco</small>
		<br>
		<img style="border:2px solid #999; max-width:1200px" src="<?= base_url('assets/img/carguepersonalAsociacion.png'); ?>" alt="" />
		<br>

		<section id="resultado" style="overflow:auto; max-height: 200px;">

		</section>

    <br>
    <div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="IniciarUploadAdjunto()">Realizar carga</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  </div>
  </section>
</div>
