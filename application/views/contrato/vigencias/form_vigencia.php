<?php
  $random = rand();
  $formtag = 'formVigencia'.$random;
?>
<button type="button" class="btn btn-small green modal-trigger"  data-target="<?= $formtag ?>">+ Agregar Vigencia</button>

<section id="<?= $formtag ?>" class="modal modal-fixed-footer" ng-init="initModals('#<?= $formtag ?>.modal')">
  <div class="modal-content noMaterialStyles">
    <h4 class="grey lighten-5"> <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" style="max-width:100px;" /> Formulario de items de contrato</h4>

    <hr class="hr-termo">

    <div class="row">
      <div class="col l12 m12">
        <label for="no_vigencia">
          No. de vigencia:
          <input type="text" ng-model="myvg.descripcion_vigencia" value="">
        </label>
      </div>

      <div class="col l6 m12">
        <label for="f_inicio">
          Fecha de inicio:
          <input type="text" ng-model="myvg.fecha_inicio_vigencia" class="datepicker">
        </label>
      </div>

      <div class="col l6 m12">
        <label for="f_inicio">
          Fecha de fin:
          <input type="text" ng-model="myvg.fecha_fin_vigencia" class="datepicker" ng-init="datepicker_init()">
        </label>
      </div>
      <hr>
      <h6>A.I.U.:</h6>
      <div class="col m4 s12">
        <label for="f_inicio">
          A:
          <input type="text" ng-model="myvg.a" value="">
        </label>
      </div>
      <div class="col m4 s12">
        <label for="f_inicio">
          I:
          <input type="text" ng-model="myvg.i" value="">
        </label>
      </div>
      <div class="col m4 s12">
        <label for="f_inicio">
          U:
          <input type="text" ng-model="myvg.u" value="">
        </label>
      </div>
    </div>

  </div>

  <div class="modal-footer">

    <button type="button" class="btn btn-small green" ng-disabled="!myvg.descripcion_vigencia || !myitem.fecha_inicio_vigencia || !myitem.fecha_fin_vigencia"
      ng-click="save('<?= site_url('vigencia/save') ?>', myvg, '<?= site_url('item/get_itemc') ?>')">
      Guardar
    </button>
    <button type="button" class="btn btn-small red" ng-click="closeForm('#formItem')"> Salir</button>

  </div>

</section>
