<?php $idtag = 'formSelectContrato'.rand(); ?>
<section ng-controller="contrato">

  <div ng-controller="cargues_historicos">

    <div class="card-panel noMaterialStyles" ng-init="getContratos('<?= site_url('contrato/get_contratos') ?>')">
      <h4>Fomulario de cargue de historicos de reportes diarios: </h4>
      <div>
        <p>Selecione un contrato, adjunte la plantilla diligenciada de cargue, monte el archivo y importe los datos.</p>

        <p>
          <big> <label>Contrato:</label> </big>
          <b ng-bind="contrato.no_contrato"></b>
          <button type="button" class="btn btn-small blue-grey darken-4 modal-trigger"  data-target="<?= $idtag ?>">Seleccionar</button>
        </p>

        <p ng-show="!contrato.idcontrato">
          <div class="" ng-init="initAdjunto('<?= site_url("historicoreportes/upload_file") ?>', '#fileuploader')">
            <big><label>Archivo:</label></big>
            <div id="fileuploader" style="display:inline">Seleccionar</div>
          </div>
        </p>

        <hr>
        <button type="button" class="btn blue" ng-disabled="selected_file" ng-click="IniciarUploadAdjunto()">Montar archivo</button>
        <button type="button" class="btn green" ng-disabled="selected_file" ng-click="leerArchivo( '<?= site_url('historicoreportes/leer_archivo') ?>', file_path )">Importar datos</button>

      </div>

    </div>

    <div class="card-panel">
      <p>
        <ul>
          <li>Resultados exitosos: <span ng-bind="respuesta_cargue.exitosos"></span> </li>
          <li>Resultados fallidos: <span ng-bind="respuesta_cargue.fallidos"></span> </li>
        </ul>
      </p>

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

    <?php  $this->load->view('contrato/select_contrato', array( 'idtag'=>$idtag )); ?>

  </div>


</section>


<style media="screen">
  .ajax-upload-dragdrop{
    display: inline-block;
  }
</style>
