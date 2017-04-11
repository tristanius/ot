<div ng-controller="consulta">
  <h5>Aseguramiento externo de personal reportado</h5>
  <div class="row" ng-controller="consulta_nom">

    <fieldset>
      <legend>Busqueda de personal: </legend>
      <div class="noMaterialStyles regularForm">
        <label for="">Orden:</label> <input type="text" ng-model="consulta_nom.orden" placeholder="Ejemplo: OTATMTPA555-17-18">
        <label for="">C.O.:</label> <input type="text" ng-model="consulta_nom.CO" placeholder="Ejemplo: 168">
        <label for="">Identificacion::</label> <input type="text" ng-model="consulta_nom.orden" placeholder="Ejemplo: 123456789">
      </div>
      <br>
      <div class="noMaterialStyles regularForm">
        <label for="">Desde:</label> <input type="text" class="datepicker" ng-init="datepicker_init()" name="fecha_inicio" ng-model="consulta_nom.fecha_inicio">
        <label for="">Hasta:</label> <input type="text" class="datepicker" ng-init="datepicker_init()" name="fecha_hasta" ng-model="consulta_nom.fecha_hasta">
        <button type="button"class="btn mini-btn" ng-click="obtenerPersonal('<?= site_url('personal/getReportadosBy'); ?>')" data-icon=","></button>
      </div>
    </fieldset>

    <br><br>

    <div class="font9">
      <table class="mytabla">
        <thead>
          <tr>
            <th>Orden</th>
            <th>CO</th>
            <th>Fecha reporte</th>
            <th>Identificación</th>
            <th>Nombre completo</th>
            <th>Cargo</th>
            <th>Codigo</th>
            <th>Tipo cargo</th>
            <th>Fact.</th>
            <th>T1 inicio</th>
            <th>T1 fin</th>
            <th>T2 inicio</th>
            <th>T2 fin</th>
            <th>HO</th>
            <th>HED.</th>
            <th>HEN</th>
            <th>RN</th>
            <th>HOF</th>
            <th>HEDF</th>
            <th>HENF</th>
            <th>RNF</th>
            <th>Ración</th>
            <th>Pernocto</th>
            <th>Lugar</th>
            <th>estado</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="per in paginaPersonal">
            <td ng-bind="field in per"></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>
