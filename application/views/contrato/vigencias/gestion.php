<?php
  $random = rand();
  $idtag = 'formSelectContrato'.$random;
?>
<section ng-controller="vigencia_tarifas" class="noMaterialStyles" >
  <h5>Vigencias de tarifas por contrato</h5>

  <div class="row" ng-init="getVigencias( '<?= site_url('vigencia/get_By') ?>', <?= isset($idcontrato)?$idcontrato:'undefined'; ?> )">

    <div class="col s12 m4">
      <b>No. Contrato: </b>
      <span ng-bind="contrato.no_contrato"></span>
      <button type="button" class="btn btn-small blue-grey darken-4 modal-trigger"  data-target="<?= $idtag ?>">Seleccionar</button>
    </div>

    <div id="myTabsVigencias<?= $random ?>" ng-init="initTabs('#myTabsFactura<?= $random ?>')">
      <ul>
        <li><a href="#tabs-1">Vigencias</a></li>
        <li><a href="#tabs-2">Tarifas</a></li>
      </ul>
      <div id="tabs-1">
        <?php $this->load->view('contrato/vigencias/tabs_vigencias'); ?>
      </div>
      <div id="tabs-2">
        <?php $this->load->view('contrato/vigencias/tabs_tarifas'); ?>
      </div>
    </div>

  <div>
</section>
