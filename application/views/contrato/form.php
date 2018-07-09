<section id="formContrato" class="windowCentered2" ng-controller="form_contrato">

  <fieldset class="padding1ex noMaterialStyles">
    <h4 class="grey lighten-5"> <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" style="max-width:100px;" /> Formulario de contrato</h4>

    <hr class="hr-termo">

    <div ng-init="getContrato('<?= site_url('contrato/get/') ?>', <?= isset($id)?$id:'undefined'; ?>);">

      <div class="row">
        <div class="col s12 m3 padding1ex">
          <span>No. del contrato: </span>
          <input type="text" ng-model="cont.no_contrato" placeholder="ingrese No. de contrato">
        </div>

        <div class="col s12 m3 padding1ex">
          <span>Contratista: </span>
          <input type="text" ng-model="cont.contratista" placeholder="Ej: termotecnica">
        </div>
      </div>

      <div class="row">
        <div class="col s12 m3 padding1ex">
          <span>Cliente: </span>
          <input type="text" ng-model="cont.cliente" placeholder="EJ: Ecopetrol">
        </div>

        <div class="col s12 m3 padding1ex" class="browser-default">
          <p>
            <span>Estado: </span>
            <input type="checkbox" ng-model="cont.estado" class="browser-default">
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col s12 m3 padding1ex">
          <span>Inicio estimado: </span>
          <input type="text" ng-init="datepicker_init()" class="datepicker" ng-model="cont.fecha_inicio_estimado" placeholder="Fecha Y-m-d">
        </div>

        <div class="col s12 m3 padding1ex">
          <span>Fin estimado: </span>
          <input type="text" ng-init="datepicker_init()" class="datepicker" ng-model="cont.fecha_fin_estimado" placeholder="Fecha Y-m-d">
        </div>
      </div>

      <div class="col s12 m8 padding1ex">
        <p>
          <span> Objeto del contrato: </span>
          <textarea style="resize: none; min-height:90px; width:100%;" rows="20" cols="80" ng-model="cont.objeto" placeholder="Ingrese objeto del contrato"></textarea>
        </p>
      </div>

    </div>

  </fieldset>

  <br>

  <div>
    <button type="button" class="btn btn-small green" ng-disabled="!cont.no_contrato || ! cont.cliente || !cont.contratista"
      ng-click="save('<?= site_url('contrato/save') ?>', cont, '<?= site_url('contrato/get_contratos') ?>')">
      Guardar
    </button>
    <button type="button" class="btn btn-small red" ng-click="confirmarCerrar('¿Estas seguro de cerrar el formulario de factura?','#ventanaContrato', enlaceVentana);  cont = {}"> Cancelar</button>
  </div>
</section>
