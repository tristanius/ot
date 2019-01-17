<section id="formUploadItems"  class="modal modal-fixed-footer" ng-init="initModals('#formUploadItems.modal');  ?>')">

  <div class="modal-content">
    <h4> Cargue de items al contrato <span ng-bind="contrato.no_contrato"></span> </h4>

    <div class="row">
      <div class="col s12 m12 l6 padding1ex">
        <div class="card-panel">
          <h6>Cargue de plantilla de items:</h6>

          <div id="cargue_items">Seleccionar archivo</div>

          <button type="button" class="btn mini-btn" ng-click="IniciarUploadAdjunto()" ng-if="isSelectedFile">Subir archivo</button>
        </div>
      </div>

      <div class="col s12 m12 l6 padding1ex">
        <div class="card-panel">
          <h6>Descargar Plantilla de cargue de items</h6>
          <a href="<?= base_url('downloads/plantillas/cargue_items.xlsx') ?>" class="btn btn-small green">Descargar plantilla</a>
        </div>
      </div>
      <p></p>
    </div>

    <p class="callout red" ng-if="cargueItems.error"> El cargue no se ha podido finalizar</p>

    <div>
      <table class="striped">
        <thead class="brown lighten-5">
          <th>Resultado</th>
          <th>Item</th>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Descripcion interna</th>
          <th>Unidad</th>
        </thead>
        <tbody>
          <tr ng-repeat="it in cargueItems.resultados">
            <td ng-bind="it.resultado"></td>
            <td ng-bind="it[0]"></td>
            <td ng-bind="it[1]"></td>
            <td ng-bind="it[2]"></td>
            <td ng-bind="it[3]"></td>
            <td ng-bind="it[4]"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <p>
      <b>Para tener en cuenta:</b>
      <ol>
        <li>La plantilla valida por item y codigo interno.</li>
        <li>Deben existir codigos internos unicos, de lo contrario la herramienta se perderá. Cualquier codigo interno repetido será ignorado.</li>
      </ol>
    </p>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-small red" ng-click="closeForm('#formUploadItems'); getItemsByContrato( '<?= site_url('item/get_itemc') ?>', contrato.idcontrato )"> Salir</button>
  </div>

</section>
