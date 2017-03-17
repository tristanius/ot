<div class="" style="padding: 1ex; border: 1ex solid #999;">
  <style media="screen">
    .vista_consulta_repo .togglable .titulo{
      border-radius: 10px;
      background: #5C92EA;
      color: #FFF;
      text-shadow: 0px 0px 3px #444;
      padding: 3px;
      border: 1px solid #000;
    }
    .vista_consulta_repo{
      border: 1px solid #aaa;
      padding: 4px;
    }
    .vista_consulta_repo .row-container{
      overflow: hidden;
      margin-bottom: 1ex;
      background: #F1F1F1;
      font-size: 13px;
    }
    .vista_consulta_repo .subquery-container{
      overflow: auto;
      margin-top: 2px;
      margin: 5px;
      border: 1px solid #2196F3;
      min-width: 1100px;
    }
    .vista_consulta_repo .subquery-container table td, vista_consulta_repo .subquery-container table th{
      min-width: 5ex;
      font-size: 11px;
    }
    .vista_consulta_repo .subquery-container table th.myNoOrden{
      min-width:18ex;
    }
  </style>

  <small class="">
    <b>ESTADOS</b>

    <span data-icon="+"></span> Pendiente,
    <span data-icon="R"></span> Elaborado,
    <span data-icon="f"></span> Corregir,
    <span data-icon="&#xe049;"></span> Corregido,
    <span data-icon="&#xe04c;"></span> Valido
  </small>

  <div class="vista_consulta_repo" ng-controller="reportes">

    <div class="row-container"  ng-repeat="ot in ots.cuerpo | orderBy: 'CO' ">
      <div class="title-container row">
        <h6 ng-bind="ot.CO+' - '+ot.NoOrden"></h6>
      </div>
      <div class="subquery-container row">
        <table class="mytabla">
          <thead style="color:#FFF; font-weight:bold; background: #4D89B7">
            <tr>
              <th ng-repeat="header in getCabeceras(ot)" class="my{{header}}" ng-bind="header"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td  ng-repeat="cell in ot" ng-style="getStyleByValidacion(cell)">
                <span ng-if="cell == 'PENDIENTE'" data-icon="+"></span>
                <span ng-if="cell == 'ELABORADO'" data-icon="R"></span>
                <span ng-if="cell == 'CORREGIR'" data-icon="f"></span>
                <span ng-if="cell == 'CORREGIDO'" data-icon="&#xe049;"></span>
                <span ng-if="cell == 'VALIDO'" data-icon="&#xe04c;"></span>
                <span ng-if="cell == 'VALIDO (FACT)'" data-icon="&#xe04c;"></span>
                <span ng-bind="cell" ng-if="cell == getIconStatus(cell)" ></span> </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
