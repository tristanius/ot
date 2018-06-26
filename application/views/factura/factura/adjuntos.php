<section class="padding1ex" >
  <h5>Archivos adjuntos</h5>
  <div class="row" ng-if="factura.idfactura">
    <div class="col s12 m8 l5" ng-init="initAdjunto('<?= site_url("adjunto/upload") ?>')">
      <div id="fileuploader">Adjuntar archivo</div>
    </div>
    <div class="col m12 l12 s12">
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
      <tr ng-repeat="a in factura.factura_adjuntos">
        <td ng-bind="a.idadjunto"></td>
        <td ng-bind="a.nombre_adjunto"></td>
        <td ng-bind="a.fecha_subida"></td>
        <td ng-bind="a.usuario"></td>
        <td >
          <a ng-href="<?= base_url('adjunto/download') ?>+'/'+a.idadjunto" target="_blank" class="btn green btn-small" data-icon="&#xe031;"></a> &nbsp;
          <button type="button" class="btn red btn-small" ng-click="deleteAdjunto()">X</button>
        </td>
      </tr>
    </tbody>
  </table>
</section>
