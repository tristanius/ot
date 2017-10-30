<section ng-controller="cargue_historico">

  <h4>Interfaz de cargue de archivos historicos de facturación:</h4>

  <b>
    Tips para realizar el cargue:
  </b>
  <ul>
    <ol> 1. El formato debe ser un libro de excel xlsx o libro excel 2007 o superior</ol>
    <ol> 2. Trata que el archivo cargado no tenga mas de 100mil registros</ol>
    <ol> 3. Evita completamente tener dos o más hojas en el mismo archivo de excel </ol>
  </ul>

  <fieldset class="" ng-init="initAdjunto('<?= site_url("historicoFacturacion/upload_cague_historico") ?>')">
    <div id="fileHistorico"> Archivo </div>
    <br>
    <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="IniciarUploadAdjunto()">1. Subir archivo</button>
  </fieldset>
  <fieldset class="">
    <legend>Datos y Validaciones</legend>
    <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="leerData('<?= site_url("historicoFacturacion/read_data_from2") ?>')">2. leer informació carga</button>
  </fieldset>

  <div >
    <button type="button" clas="waves-effect waves-light btn padding1ex" ng-click="asinateResults(rows.success, 'Exitosos')">Exitosos</button>
    <button type="button" clas="waves-effect waves-light btn padding1ex" ng-click="asinateResults(rows.failed, 'Fallidos')">Fallidos</button>
    <div style="font-size: 9px; overflow: auto;">

      <button type="button" class="waves-effect waves-light btn" ng-click="genDownloadFile('<?= site_url('HistoricoFacturacion/generarXlsx') ?>', resultados)">Download resultados</button>
      <h4>Resultados del cargue {{ view + ': ' + (resultados.length-1) }}</h4>

    </div>
  </div>

</section>
