<section ng-controller="listOTReportes">
  <h4>Informe consolidado de actividades de OT</h4>
  <fieldset>
    <legend> <strong>Filtro:</strong> </legend>
    <div class="col l12 regularForm row">

      <fieldset style="padding:1ex;" >
        <div class="noMaterialStyles row col l3 m4 s12">
          <b class="col l3 m4 s4">No. OT:</b>
          <input class="col l8 m8 s8" type="text" ng-model="consulta.indicio_nombre_ot" style="padding: 5px;" placeholder="Ej: 350-16">
        </div>

        <div class="noMaterialStyles row col l3 m4 s12">
          <b class="col l3 m4 s4">Base:</b>
          <select ng-model="consulta.base" class="col l8 m8 s8" style="height:4ex;">
            <option value="">No Seleccionado</option>
            <option ng-repeat="b in log.bases" value="{{b.idbase}}"> {{b.idbase + " - " + b.nombre_base }} </option>
          </select>
        </div>

        <div class="noMaterialStyles row col l3 m4 s12">
          <b class="col l3 m4 s4">Estado:</b>
          <select ng-model="consulta.estado" class="col l8 m8 s8" style="height:4ex;">
            <option value="">No Seleccionado</option>
            <option value="POR EJECUTAR">POR EJECUTAR</option>
            <option value="ACTIVA">ACTIVA</option>
            <option value="FINALIZÓ">FINALIZÓ</option>
          </select>
        </div>

        <div class="row col l1 m2 s12">
          <button type="button" class="btn" data-icon="," ng-click="getOTs('<?= site_url('ot/getBy') ?>')"></button>
        </div>

      </fieldset>
      <hr>

      <div id="seleccionar_ot" ng-show="seleccionar_ot" class="col s12 m12 l12" style="background:#FAFAFA; max-heigth: 230px; overflow: auto">

        <h6>Seleciona la OT buscada:</h6>
        <hr>

        <div class="">
          <table class="mytabla" style="background:#FFF; width: auto;">
            <thead>
              <tr>
                <th>Seleccionar</th>
                <th>Base</th>
                <th>Nombre de OT</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="ot in myOts">
                <td>
                  <button type="button" class="btn mini-btn2" ng-click="consulta.ot = ot" data-icon="w"> Sel.</button>
                </td>
                <td ng-bind="ot.base_idbase"></td>
                <td ng-bind="ot.nombre_ot"></td>
                <td ng-bind="ot.estado_doc"></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </fieldset>

  <p>
    Los informes consolidados de actividades reportadas no es un informe autogenerado, es un informe que se diligencia en los reportes diarios con actividades. esta consulta los une en un solo informe por orden de trabajo.
  </p>

  <div class="" ng-if="consulta.ot.idOT">
    <a target="_blank" ng-href="<?= site_url('export/getConsolidados') ?>/{{consulta.ot.idOT}}" class="btn mini-btn2 blue" >Descargar consolidado diligenciados <span data-icon="&#xe041;"></span> </a>
  </div>

  <hr>
  <br>
</section>
