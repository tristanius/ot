<?php
  $rand = rand();
  $idtag = 'formSelectContrato'.$rand;
?>
<section ng-controller="contrato">

  <div ng-controller="cargues_historicos">

    <div class="card-panel noMaterialStyles" ng-init="getContratos('<?= site_url('contrato/get_contratos') ?>')">
      <h4>Fomulario de cargue de historicos de reportes diarios: </h4>
      <div>
        <p>Selecione un contrato, adjunte la plantilla diligenciada de cargue, monte el archivo y importe los datos.</p>

        <p>
          <big> <label>Contrato:</label> </big>
          <b ng-bind="contrato.no_contrato"></b>
          <button type="button" class="btn btn-small blue-grey darken-4 modal-trigger" ng-disabled="selected_file" data-target="<?= $idtag ?>">Seleccionar</button>
        </p>

        <p ng-show="!contrato.idcontrato">
          <div ng-show="file_path?false:true" ng-init="initAdjunto('<?= site_url("historicoreportes/upload_file") ?>', '#fileuploader')">
            <big><label>Archivo:</label></big>
            <div id="fileuploader" style="display:inline">Seleccionar</div>
          </div>
        </p>
        <p ng-show="file_path?true:false"> <strong>Ruta: </strong> <span ng-bind="file_path"></span> </p>

        <hr>
        <button type="button" class="btn blue" ng-disabled="!selected_file || loader || (file_path?true:false)" ng-click="IniciarUploadAdjunto()">Montar archivo</button>
        <button type="button" class="btn green" ng-disabled="!selected_file || loader" ng-click="leerArchivo( '<?= site_url('historicoreportes/leer_archivo') ?>', file_path )">Importar datos</button>

      </div>

      <img src="<?= base_url('assets/img/ajax-loader.gif') ?>" style="width: 50px" ng-show="loader" ng-init="loader = false">

    </div>

    <div class="card-panel">
      <p>
        <ul>
          <li>Resultados exitosos: <span ng-bind="respuesta_cargue.exitosos"></span> </li>
          <li>Resultados fallidos: <span ng-bind="respuesta_cargue.fallidos"></span> </li>
        </ul>
      </p>

      <a class="btn btn-small green" ng-href="<?= base_url() ?>{{ respuesta_cargue.download }}" target="_blank">Exportar resultados</a>
      <table id="tableCargueHistorico<?= $rand ?>" class="mytabla" ng-init="table_tag = '#tableCargueHistorico<?= $rand ?>';">
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
          <tr ng-repeat="r in respuesta_cargue.resultados">
            <td ng-bind="r.resultado"></td>
            <td ng-bind="r[2]"></td>
            <td ng-bind="r[1]"></td>
            <td ng-bind="r[4]"></td>
            <td ng-bind="r[21]"></td>
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
