<section class="noMaterialStyles" ng-if="contrato.idcontrato">
  <?php $i = rand(); ?>

  <div id="myTabsVigencias<?= $i ?>">
    <div class="mytabs">
      <a ng-repeat="vig in vigencias" ng-click="setVigencia(vig)" ng-bind="($index+1)+'. '+vig.descripcion_vigencia" class="mytab {{ (vg == vig)?'active':'' }}"> </a>
    </div>

    <div ng-if="vg.idvigencia_tarifas">
      <img ng-show="loader" src="<?= base_url('assets/img/loader.gif') ?>" style="width: 50px; height: 50px">

      <div class="row">

        <img ng-show="loader" src="<?= base_url('assets/img/loader.gif') ?>" style="width: 50px; height: 50px">

        <div class="col m7">
          <br>
          <table class="mytabla font11">
            <thead>
              <tr>
                <th colspan="6">Informacion de la vigencia</th>
              </tr>
              <tr>
                <th> Descripción vigencia </th>
                <th> F. inicio </th>
                <th> F. Final </th>
                <th> A </th>
                <th> I </th>
                <th> U </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td ng-bind="vg.descripcion_vigencia"></td>
                <td ng-bind="vg.fecha_inicio_vigencia"></td>
                <td ng-bind="vg.fecha_fin_vigencia"></td>
                <td ng-bind="( vg.a * 1 )"></td>
                <td ng-bind="( vg.i * 1 )"></td>
                <td ng-bind="( vg.u * 1 )"></span>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col m5">
          <h5>Opciones de tarifas: </h5>
          <button type="button" class="btn btn-small blue" ng-click="getTarifas('<?= site_url('tarifa/get_by_vigencia/') ?>', vg.idvigencia_tarifas)">Consultar tarifas</button>
        </div>

        <div class="card-panel col m12" >
          <?php $this->load->view('contrato/vigencias/lista'); ?>
        </div>

      </div>

    </div>

  </div>

</section>
