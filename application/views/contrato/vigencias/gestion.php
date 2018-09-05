<section ng-controller="vigencia_tarifas">
  <h4>Vigencias de tarifas por contrato</h4>

  <div class="row" ng-init="getVigencias( '<?= site_url('vigencia/get_By') ?>', <?= isset($idcontrato)?$idcontrato:'undefined'; ?> )">
    <div class="col s12 m4">
      <label>No. Contrato: </label>
      <b ng-bind="contrato.no_contrato"></b>
      <button type="button" class="btn btn-small blue-grey darken-4 modal-trigger"  data-target="formSelectContrato">Seleccionar</button>
    </div>

    <div class="col s12 m7">
      <table class="mytabla font11">
        <thead class=" indigo lighten-5">
          <tr>
            <th colspan="4">Informacion contrato No. <span ng-bind="contrato.no_contrato"></span> </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Contratista:</th>
            <td ng-bind="contrato.contratista"></td>

            <th>Objeto del contrato:</th>
            <td ng-bind="contrato.objeto"></td>
          </tr>
          <tr>
            <th>Cliente:</th>
            <td ng-bind="contrato.cliente"></td>

            <th>Estado:</th>
            <td ng-bind="contrato.estado?'Activo':'No activo'"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col m12">
      <button type="button" class="btn btn-small green">Agregar vigencia</button>
    </div>

  </div>
  <br>
  <div class="" ng-init="getContratos('<?= site_url('contrato/get_contratos') ?>')">
    <?php $this->load->view('contrato/vigencias/tabs_vigencias'); ?>

    <?php  $this->load->view('contrato/select_contrato'); ?>
  </div>
</section>
