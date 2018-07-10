<section ng-controller="itemc" ng-init="getItemsByContrato( '<?= site_url('item/get_itemc') ?>', <?= isset($idcontrato)?$idcontrato:'undefined'; ?> )">
  <div class="card-panel padding1ex">
    <h5>Maestro de Items de contrato</h5>
    <div class="row noMaterialStyles">

      <div class="col s12 m6 l4">
        <span>No. Contrato: </span>
        <b ng-bind="contrato.no_contrato"></b>
        <button type="button" class="btn btn-small teal accent-3">Selec. contrato</button>
      </div>

      <div class="col s12 m6 l5">

        <table class="mytabla">
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

    </div>
  </div>

  <div class="card padding1ex">
    <h5>Listado general de items del contrato</h5>

    <fieldset>
      <legend>Opciones:</legend>

      <button type="button" data-target="formItem" class="modal-trigger btn btn-small blue darken-4">Agregar nuevo item</button>

      <button type="button" class="btn btn-small purple darken-1"> Importar items</button>

      <button type="button" class="btn btn-small green">Exportar (xlsx)</button>
    </fieldset>

    <?php
      $this->load->view('items/itemc/lista');
    ?>
  </div>

  <?php  $this->load->view('items/itemc/form_item'); ?>
</section>
