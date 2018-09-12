<section ng-controller="cargues_historicos">
  <div class="card-panel">
    <h4>Fomulario de cargue de historicos de reportes diarios: </h4>
    <div>
      <p>Selecione un contrato, adjunte la plantilla diligenciada de cargue, monte el archivo y importe los datos.</p>

      <p>
        Contrato:
        <span ng-bind="formData.contrato.idcontrato"></span>
        <button type="button" class="btn btn-small">Seleccionar</button>
      </p>

      <p>
        <div class="" ng-init="initAdjunto('<?= site_url("recurso/uploadFile/personal") ?>', '#fileuploader')">
          Archivo:
          <div id="fileuploader" style="display:inline">Seleccionar</div>
        </div>
      </p>

      <hr>
      <button type="button" class="btn blue" ng-disabled="true">Montar archivo</button>
      <button type="button" class="btn green" ng-disabled="true">Importar datos</button>

    </div>

  </div>

  <div class="card-panel">
    Respuesta resumen: <span></span>

    <table>
      <thead>
        <tr>
          <th>Resultado</th>
          <th>Fecha</th>
          <th>OT</th>
          <th>Item</th>
          <th>cantidad</th>
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
  </div>

</section>


<style media="screen">
  .ajax-upload-dragdrop{
    display: inline-block;
  }
</style>
