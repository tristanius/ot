<section>
  <fieldset>
    <h5>Reporte de control de producción por periodos</h5>
    <hr>

    <p>Vista de consulta del informe de excel de producción, por favor selecciona el rango de fechas que deseas generar en formato xlxs.</p>
    <div class="row noMaterialStyles">
      <div class="col s12 m6 l5">
        <div class="clear-left">
            <span >F. inicial: </span>
            <input type="text" class="datepicker" style="display:inline; border-radius: 7px;" ng-init="datepicker_init()" ng-model="fecha_ini" readonly="readonly" placeholder="Ingresa una fecha">
            <br>
        </div>
        <br>
        <div class="clear-left">
          <span >F. final: </span>
          <input type="text" class="datepicker" style="display:inline; border-radius: 7px;" ng-init="datepicker_init()" ng-model="fecha_fin" readonly="readonly" placeholder="Ingresa una fecha">
          <br>
        </div>
        <div class="regularForm">

          <span for=""> Selecciona informe:</span>
          <select class="" ng-model="tipo_informe" ng-init="tipo_informe = '2'">
            <option value="1">Sabana de control de MTTO (ECP)</option>
            <option value="2">Sabana de control Obras</option>
            <option value="3">Sabana de obras Anomalias</option>
          </select>

        </div>
      </div>
      <div class="col s12 m12 l4 noMaterialStyles" ng-init="lasbases = []" style="max-heigth: 25ex">
        <div ng-repeat="b in log.bases">
          <label class="regularForm" style="width: 100%; display: block">
            <input class=""
              type="checkbox"
              ng-model="b.inf_produccion"
              ng-change="delAddFromList( lasbases , b.idbase )"
              ng-init="b.inf_produccion = false"
            >
            <b class="black-text">{{ b.idbase+' - '+b.nombre_base }}</b>
          </label>
        </div>
      </div>
    </div>
    <form ng-if="(fecha_ini != undefined && fecha_fin != undefined  )" action='<?= site_url('export/informeProduccion') ?>' method="post">
    <!--<form ng-if="(fecha_ini != undefined && fecha_fin != undefined  )" action='http://localhost:8084/testInformeProduccion/controlapp/Exportable.jsp' method="post">-->
      <input type="hidden" name="bases" value="{{ lasbases | json }}">
      <input type="hidden" name="fecha_ini" value="{{fecha_ini}}">
      <input type="hidden" name="fecha_fin" value="{{fecha_fin}}">
      <input type="hidden" name="tipo_informe" value="{{tipo_informe}}">
      <button type="submit" target="_blank" class="btn mini-btn" ng-disabled="lasbases.length == 0"> Exportar <span data-icon="&#xe03b;"></span> </button>
    </form>

  </fieldset>
</section>
