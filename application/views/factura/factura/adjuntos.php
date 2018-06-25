<section class="padding1ex" >
  <h5>Archivos adjuntos</h5>
  <div class="row" ng-if="factura.idfactura">
    <div class="col s12 m8 l5" ng-init="initAdjunto('<?= site_url("adjunto/upload") ?>')">
      <div id="fileuploader">Adjuntar archivo</div>
      <button type="button" class="btn mini-btn" ng-click="IniciarUploadAdjunto()" ng-if="isSelectedFile">Subir archivo</button>
    </div>
  </div>

  <p class="orange" ng-if="!factura.idfactura">
    Para adicionar nuevos adjuntos debes darle click a guardar la factura para que podamos relacionar el archivo en cuestión a esta factura.
  </p>

  <br>

  <table class="mytabla">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre del archivo</th>
        <th>fecha de subida</th>
        <th>Por</th>
        <th>Descargar</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</section>
