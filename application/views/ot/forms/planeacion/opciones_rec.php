<p ng-show=" (tr.idtarea_ot == undefined || tr.idtarea_ot == '') || true">
  <div ng-if="!tr.idvigencia_tarifas">
    <label>Selecione una vigencia de tarifas: </label>
    <select ng-model="vg" ng-options="vg as vg.descripcion_vigencia for vg in (vigencias | filter: {idcontrato:ot.idcontrato}) track by vg.idvigencia_tarifas"></select>
    <button type="button" ng-if="vg"
      ng-click="getItemsVg('<?= site_url('vigencia/get_tarifas') ?>/'+vg.idvigencia_tarifas); setValorProp( vg.idvigencia_tarifas, tr, 'idvigencia_tarifas' ); setValorProp( true, ot, 'vigencias' )" class="btn blue mini-btn">
      Seleccionar
    </button>
    {{tr.idvigencia_tarifas}}
    <span ng-if="!tr" class="red-text">Debes crear una Tarea para continuar. </span>
    <span ng-if="!tr.idcontrato"> Seleciona un contrato. </span>
  </div>
  <div ng-if="tr.idvigencia_tarifas" ng-init="getItemsVg('<?= site_url('vigencia/get_tarifas') ?>/'+tr.idvigencia_tarifas);">
        <h5 ng-bind="findObjByProp(tr.idvigencia_tarifas, 'idvigencia_tarifas', vigencias).descripcion_vigencia"></h5>
        <button type="button" ng-click="VwITems('actividad');" class="btn green mini-btn" data-icon="&#xe052;"> Actividades</button>
        <button type="button" ng-click="VwITems('personal');" class="btn green mini-btn" data-icon="&#xe052;"> Personal</button>
        <button type="button" ng-click="VwITems('equipo');" class="btn green mini-btn" data-icon="&#xe052;"> Equipo</button>
        <button type="button" ng-click="VwITems('material');" class="btn green mini-btn" data-icon="&#xe052;"> Material</button>
        <button type="button" ng-click="VwITems('otros');" class="btn green mini-btn" data-icon="&#xe052;"> Otros</button>
        <button type="button" ng-click="VwITems('subcontrato');" class="btn green mini-btn" data-icon="&#xe052;"> Subcontrato</button>
  </div>

</p>
