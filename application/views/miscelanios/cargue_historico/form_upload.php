<section ng-controller="cargue_historico">

  <h4>Interfaz de cargue de archivos historicos de facturación:</h4>

  <b>
    Tips para realizar el cargue:
  </b>
  <ul>
    <ol> 1. El formato debe ser un libro de excel xlsx o libro excel 2007 o superior</ol>
    <ol> 2. Trata que carga archivo no tenga mas de 50mil registros</ol>
    <ol> 3. Evita completamente tener mas de dos hojas en el mismo archivo de excel </ol>
  </ul>

  <fieldset class="" ng-init="initAdjunto('<?= site_url("Facturacion/upload_cague_historico") ?>')">
    <div id="fileHistorico"> Archivo </div>
    <br>
    <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="IniciarUploadAdjunto()">1. Subir archivo</button>
  </fieldset>
  <fieldset class="">
    <legend>Datos y Validaciones</legend>
    <button type="button" class="waves-effect waves-light btn padding1ex" ng-click="leerData('<?= site_url("facturacion/read_data_from") ?>')">2. leer informació carga</button>
  </fieldset>

</section>
