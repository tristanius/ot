<div ng-controller="consulta">
  <h5>Cargue de personal reportado en nomina</h5>
  <div class="row" ng-controller="consulta_nom">
    <fieldset>
    <button type="button" class="btn mini-btn" > <span data-icon="i"></span></button>
      Add. nuevo cargue de asiciación de nomina  <span data-icon="&#xe037;"></span>
    </fieldset>

    <br>

    <fieldset>
      <legend>Busqueda de asociones de personal previas o pendientes: </legend>
      <div class="noMaterialStyles regularForm">
        <label for="">Orden:</label> <input type="text" name="consulta_nom.orden" ng-model="consulta_nom.orden">
        <label for="">C.O.:</label> <input type="text" name="consulta_nom.CO" ng-model="consulta_nom.CO">
        <label for="">Identificacion</label> <input type="text" name="consulta_nom.orden" ng-model="consulta_nom.orden">
      </div>
      <hr>
      <div class="noMaterialStyles regularForm">
        <label for="">Desde:</label> <input type="text" class="datepicker" ng-init="datepicker_init()" name="fecha_inicio" ng-model="consulta_nom.fecha_inicio">
        <label for="">Hasta:</label> <input type="text" class="datepicker" ng-init="datepicker_init()" name="fecha_hasta" ng-model="consulta_nom.fecha_hasta">
        <button type="button"class="btn mini-btn" data-icon=","></button>
      </div>
    </fieldset>

  </div>
</div>
