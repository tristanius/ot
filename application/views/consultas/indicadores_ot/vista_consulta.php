<div class="" style="padding: 1ex; border: 1ex solid #999;" ng-controller="vistaCantidadesMesRD">
  <style media="screen">
    .vista_consulta .togglable .titulo{
      border-radius: 10px;
      background: #5C92EA;
      color: #FFF;
      text-shadow: 0px 0px 3px #444;
      padding: 3px;
      border: 1px solid #000;
    }
    .vista_consulta{
      border: 1px solid #aaa;
      padding: 4px;
    }
    .vista_consulta .row-container{
      border: 1px solid #000;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 2px;
    }
    .vista_consulta .title-container{
      background: #FAFAFA;
      font-size: 13px;
    }
    .vista_consulta .subquery-container{
      overflow: auto;
      margin-top: 2px;
      margin: 5px;
      border: 1px solid #2196F3;
      min-width: 1100px;
    }
    .vista_consulta .subquery-container table td, .vista_consulta .subquery-container table th{
      min-width: 10px;
      font-size: 10px;
    }
  </style>

  <div class="vista_consulta" >

    <div class="row-container"  ng-repeat="ot in ots">

      <div class="title-container row">
        <div class="col l1 m2 s3">
          <button type="button" ng-click="verCantidadesDia( '<?= site_url('consulta/get_indicadores_ot'); ?>', ot )" class="btn mini-btn" style="background:#1066A8" data-icon="&#xe02d;"></button>
        </div>
        <div class="col l2 m3 s4" ng-bind="ot.idbase"></div>
        <div class="col l9 m6 s5" ng-bind="ot.nombre_ot"></div>
      </div>

      <div class="subquery-container row" ng-show="ot.show" ng-init="ot.show = initBoolean(ot.show)">
        <table class="mytabla">
          <thead>
            <tr>
              <th ng-repeat="row in ot.infoCantidadesRd.cabeceras track by $index" ng-style="getStyleByHeader()" ng-bind="row" ng-if="$index != 0"></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="row in ot.infoCantidadesRd.cuerpo track by $index">
              <td ng-repeat="cell in row" ng-if="$index != 0">
                <span ng-style="validarCeldaNum(cell,row)" ng-bind="cell"></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
