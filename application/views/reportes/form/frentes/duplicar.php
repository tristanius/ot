<section ng-controller="frentes">

  <button  ng-show="!duplicar_frente" type="button" ng-click="getFrentes('<?= site_url('reporte/get_fecha_frentes/'); ?>', rd.idOT, myfrente);" class="btn mini-btn indigo lighten-4 black-text" ng-disabled="!validPriv(45) && validPriv(46)">
    Duplicar frente
  </button>


  <div ng-show="duplicar_frente" style="position:fixed; z-index: 20; width: 90%; text-align:center; padding 2ex;">
      <table>
        <thead>
          <tr>
            <th>Orden</th>
            <th>Fecha reporte</th>
            <th>Frente</th>
            <th>selecionar</th>
          </tr>
          <tr>
            <th></th>
            <th> <input type="text" ng-model="filDuplicarFrente.fecha"> </th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="r in  frentes_dupe">
            <td ng-bind="r.nombre_ot"></td>
            <td ng-bind="r.fecha_reporte"></td>
            <td ng-bind="r.nombre_frente"></td>
            <td>
              <button type="button" ng-click="" class="btn mini-btn2"
                ng-click="get_recursos_frente('<?= site_url('reporte/get_recursos_reporte_by'); ?>', r.idOT, r.idfrente_ot, r.idreporte_diario)">
                Duplicar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  </div>
</section>
