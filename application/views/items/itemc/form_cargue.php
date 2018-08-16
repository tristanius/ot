<section id="formUploadItems"  class="modal modal-fixed-footer" ng-init="initModals('#formUploadItems.modal'); initAdjunto('<?= site_url('item/import') ?>')">

  <div class="modal-content">
    <h4> Cargue de items al contrato <span ng-bind="contrato.no_contrato"></span> </h4>

    <div class="row">
      <div class="col s12 m12 l6 padding1ex">
        <div class="card-panel">
          <h6>Cargue de plantilla de items:</h6>
          <div id="fileuploader">Seleccionar archivo</div>
          <button type="button" class="btn mini-btn" ng-click="IniciarUploadAdjunto()" ng-if="isSelectedFile">Subir archivo</button>
        </div>
      </div>

      <div class="col s12 m12 l6 padding1ex">
        <div class="card-panel">
          <h6>Descargar Plantilla de cargue de items</h6>
          <a href="#" class="btn btn-small green">Descargar plantilla</a>
        </div>
      </div>
      <p></p>
    </div>

    <div>
      <p></p>
      <table class="striped">
        <thead class="brown lighten-5">
          <th>Resultado</th>
          <th>Item</th>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Descripcion interna</th>
          <th>Unidad</th>
        </thead>
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
    <button type="button" class="btn btn-small red" ng-click="closeForm('#formUploadItems')"> Salir</button>
  </div>

</section>
