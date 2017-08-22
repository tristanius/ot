<section ng-controller="migracion_recursos">

  <div class="">

    <h5 style="text-align:center">Transferir recursos reportados a nuevo centro de costos</h5>

    <div style="border:1px solid #999; padding:1ex;" ng-show="!cargaTraslado">
      <button type="button" class="btn mini-btn" ng-click="cargaTraslado=true">
        <span data-icon="&#xe030;"></span> Cargue vía xlsx
      </button>
    </div>

    <div class="" ng-show="cargaTraslado">
      <?php $this->load->view('asociaciones/transferencia_recursos/cargueMigracionRecursos'); ?>
    </div>

    <div ng-show="!cargaTraslado" style="box-shadow: 0 0 10px inset; min-height:200px; padding: 5px">
      <table class="mytabla font10">
          <thead>
            <tr>
              <th>Origen</th>
              <th>Destino</th>
              <th>fecha r.</th>
              <th>tipo</th>
              <th>Item</th>
              <th>C.C.</th>
              <th>Cod. siesa</th>
              <th>resultado</th>

            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="d in resultadosTraslado">
              <td ng-bind="d.A"></td>
              <td ng-bind="d.B"></td>
              <td ng-bind="d.C"></td>
              <td ng-bind="d.D"></td>
              <td ng-bind="d.E"></td>
              <td ng-bind="d.F"></td>
              <td ng-bind="d.H"></td>
              <td ng-bind="d.J"></td>
            </tr>
          </tbody>
      </table>
    </div>

    <fieldset class="nodisplay">
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
