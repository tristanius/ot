<?php $idtag = 'formSelectContrato'.rand(); ?>
<section ng-controller="vigencia_tarifas" class="noMaterialStyles" >
  <h5>Vigencias de tarifas por contrato</h5>

  <div class="row" ng-init="getVigencias( '<?= site_url('vigencia/get_By') ?>', <?= isset($idcontrato)?$idcontrato:'undefined'; ?> )">

    <div class="col s12 m4">
      <b>No. Contrato: </b>
      <span ng-bind="contrato.no_contrato"></span>
      <button type="button" class="btn btn-small blue-grey darken-4 modal-trigger"  data-target="<?= $idtag ?>">Seleccionar</button>
    </div>

    <div class="col s12 m8 regularForm">
      <b>Seleccionar vigencia</b>
      <select class="" ng-model="vg" ng-options="v as ( v.descripcion_vigencia ) for v in vigencias"></select>
      <button type="button" ng-disabled="vigencias.length == 0" class="btn btn-small green">Agregar vigencia</button>
    </div>

  </div>
  <br>
  <div class="" ng-init="getContratos('<?= site_url('contrato/get_contratos') ?>')">
    <?php $this->load->view('contrato/vigencias/tabs_vigencias'); ?>

    <?php  $this->load->view('contrato/select_contrato', array( 'idtag'=>$idtag )); ?>
  </div>
</section>
