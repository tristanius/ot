<section ng-controller="migracion_recursos">

  <div id="VantanaSelecionMigracion" class="VentanaContainer nodisplay row">
    <fieldset class="windowCentered row">
      <div class="regularForm noMaterialStyles">
        <label>Buscar:</label>
        <input type="text" ng-model="buscarOT">
        <button type="button" class="btn  mini-btn" data-icon=","></button>
      </div>

      <table class="mytabla">
        <caption>Resultados, por favor seleccione uno</caption>
        <thead>
          <tr>
            <th>Orden</th>
            <th>C.O.</th>
            <th>Selecc.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </fieldset>
  </div>

  <div class="">

    <h5 style="text-align:center">Trenferir recursos reportados a nuevo centro de costos</h5>

    <fieldset>
      <div class="noMaterialStyles regularForm row">
          <div class="col m3">
            <label>Orden origen:</label>
            <input type="text" ng-model="ot_origen.nombre_ot" disabled>
            <button type="button" class="btn mini-btn" style="margin:0px" data-icon=","
              ng-click="ventanaMigrarSeleccionOT(ot_origen,'VantanaSelecionMigracion')">
            </button>
          </div>

          <div class="col m3">
            <label>Orden Destino:</label>
            <input type="text" ng-model="ot_destino.nombre_ot" disabled>
            <button type="button" class="btn mini-btn" style="margin:0px" data-icon=","
              ng-click="ventanaMigrarSeleccionOT(ot_origen,'VantanaSelecionMigracion')">
            </button>
          </div>
      </div>
      <br>
      <div class="noMaterialStyles regularForm row">
          <div class="col m3">
            <label>Fecha inicio:</label>
            <input type="text" ng-model="f_inicio" disabled>
          </div>

          <div class="col m3">
            <label>Fecha final:</label>
            <input type="text" ng-model="f_final" disabled>
          </div>
      </div>
    </fieldset>

  </div>
</section>
