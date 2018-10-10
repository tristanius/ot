<section id="tabVigencias">
  <div class="">
    <button type="button" class="btn btn-small green">+ Agregar Vigencia</button>
  </div>

  <div id="listado" class="card-panel">
    <table>
      <thead>
        <tr>
          <th> Vigencia </th>
          <th> Contratista: </th>
          <th> Cliente: </th>
          <th> F. Inicio </th>
          <th> F. Final </th>
          <th> A </th>
          <th> I </th>
          <th> U </th>
          <th>Mod. </th>
          <th>Del. </th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="v in vigencias">
          <td ng-bind="contrato.contratista"></td>
          <td ng-bind="contrato.cliente"></td>
          <td ng-bind="contrato.contratista"></td>
          <td ng-bind="v.descripcion_vigencia"></td>
          <td ng-bind="v.fecha_inicio_vigencia"></td>
          <td ng-bind="v.fecha_fin_vigencia"></td>
          <td ng-bind="( v.a * 1 )"></td>
          <td ng-bind="( v.i * 1 )"></td>
          <td ng-bind="( v.u * 1 )"></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
