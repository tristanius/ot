<section ng-controller="historico_fact">

  <h4 class="center-align">Interfaz de cargue de archivos historicos de facturación:</h4>

  <h5>
    Tips para realizar el cargue:
  </h5>
  <ul>
    <ol> 1. El formato debe ser un libro de excel xlsx o libro excel 2007 o superior</ol>
    <ol> 2. Trata que el archivo cargado no tenga mas de 100mil registros</ol>
    <ol> 3. Evita completamente tener dos o más hojas en el mismo archivo de excel </ol>
  </ul>
  <hr>

  <fieldset class="{{ (uploadView?'aparecerDiv':'ocultarDiv') }}" ng-init="initAdjunto('<?= site_url("historicoFacturacion/upload_cague_historico") ?>')">
    <h5>Paso 1: cargar el archivo de datos</h5>
    <div class="left">
      <div id="fileHistorico"> Archivo </div>
    </div>
    <div class="left">
      <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="IniciarUploadAdjunto()"> <span data-icon="&#xe030;"></span> </button> Subir archivo:
    </div>

  </fieldset>

  <fieldset class="{{ (validacionView?'aparecerDiv':'ocultarDiv') }}">
    <h5>Paso 2: Datos del archivo cargado</h5>
    <legend>Datos y Validaciones</legend>

    <div ng-if="spinner" >
      <h6>Estamos trabajando en el archivo, por favor espere.</h6>
      <label>Cargando...</label>
      <img src="<?= base_url('assets/img/cargando.gif') ?>" alt="" width="300">
    </div>

    <button type="button" class="waves-effect waves-light blue btn padding1ex" ng-click="leerData('<?= site_url("historicoFacturacion/read_data_from2/validacion") ?>')">Validar información</button>

    <button type="button" class="waves-effect waves-light green btn padding1ex" ng-click="leerData('<?= site_url("historicoFacturacion/read_data_from2/registro") ?>')">Cargar información</button>

  </fieldset>

  <div class="{{ (resultsView?'aparecerDiv':'ocultarDiv') }}">
    <h5>Paso 3: Resultados del proceso: {{ 'variable del proceso' }}</h5>
    <div style="font-size: 9px; overflow: auto;">

      <p>
        <big>Resultados exitosos: </big> <big><strong ng-bind="(rows.success.length-1)"></strong></big>
        <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="genDownloadFile('<?= site_url('historicoFacturacion/generarXlsx') ?>', rows.success)">Download resultados</button>
      </p>

      <p>
        <big>Resultados exitosos: </big> <big><strong ng-bind="(rows.failed.length-1)"></strong></big>
        <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="genDownloadFile('<?= site_url('historicoFacturacion/generarXlsx') ?>', rows.failed)">Download resultados</button>
      </p>

    </div>
  </div>

</section>
