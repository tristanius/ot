<section ng-controller="frentes">

  <button  ng-if="myfrente" type="button" ng-click="getFrentes('<?= site_url('reporte/get_fecha_frentes/'); ?>', rd.idOT, myfrente);" class="btn mini-btn4 indigo accent-2" ng-disabled="!validPriv(45) && validPriv(46)">
    Duplicar frente
  </button>


  <div ng-show="duplicar_frente" style="position:absolute; z-index: 20; width: 90%; text-align:center; padding 2ex; background: #FFF; border: 1px solid #000; border-radius: 10px;">
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
      <button type="button" ng-click="duplicar_frente = false" class="btn mini-btn2 red darken-2" >Salir</button>
  </div>
</section>
