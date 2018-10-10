<section ng-if="vg.idvigencia_tarifas">
  <?php $i = rand(); ?>

  <div id="myTabsVigencias<?= $i ?>">

    <div class="row card ">

      <div class="col s12 m8 regularForm">
        <b>Seleccionar vigencia</b>
        <select class="" ng-model="vg" ng-options="v as ( v.descripcion_vigencia ) for v in vigencias"></select>
        <button type="button" class="btn btn-small blue" ng-if="vg.idvigencia_tarifas" ng-click="getTarifas('<?= site_url('tarifa/get_by_vigencia/') ?>', vg.idvigencia_tarifas)">
          Consultar tarifas
        </button>
      </div>

      <div class="col m8">
        <img ng-show="loader" src="<?= base_url('assets/img/loader.gif') ?>" style="width: 40px; height: 40px">
        <table class="mytabla font11">
          <thead>
            <tr class="indigo lighten-5">
              <th colspan="9">Informacion de la vigencia selecionada</th>
            </tr>
            <tr>
              <th> Contratista: </th>
              <th> Cliente: </th>
              <th> Contratista: </th>
              <th> Descripción vigencia </th>
              <th> F. inicio </th>
              <th> F. Final </th>
              <th> A </th>
              <th> I </th>
              <th> U </th>
            </tr>
          </thead>
          <tbody>
            <tr><td ng-bind="contrato.contratista"></td>
              <td ng-bind="contrato.cliente"></td>
              <td ng-bind="contrato.contratista"></td>
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

      <div class="col s12">
        <hr>
        <?php $this->load->view('contrato/tarifas/lista'); ?>
      </div>

    </div>

  </div>

</section>
