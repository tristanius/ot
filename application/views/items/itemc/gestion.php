<section ng-controller="itemc" ng-init="getItemsByContrato( '<?= site_url('item/get_itemc') ?>', <?= isset($idcontrato)?$idcontrato:'undefined'; ?> )">
  <div class="card-panel padding1ex">
    <h5>Items asociados a contrato</h5>
    <div class="row noMaterialStyles">

      <div class="col s12 m6">
        <label>No. Contrato: </label>
        <b ng-bind="myContrato"></b>
        <button type="button" class="btn btn-small teal accent-3">Seleccionar</button>
      </div>

    </div>
  </div>

  <table class="mytabla">
    <thead>
      <tr class="blue-grey lighten-4">
        <th></th>
        <th>Item</th>
        <th>Descripcion oferta</th>
        <th>Codigo interno</th>
        <th>Descripcion interna</th>
        <th>Tipo</th>
        <th>Grupo</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>

</section>
