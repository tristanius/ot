<div class="">
  <b> Tipo de acta: </b>
  <select ng-model="factura.tipo_acta" ng-init="factura.tipo_acta = (factura.tipo_acta?factura.tipo_acta:'FACTURA')">
    <option value="FACTURA">FACTURA</option>
    <option value="REAJUSTE">REAJUSTE</option>
    <option value="COBRO OTRO">COBRO OTRO</option>
  </select>
</div>

<div class="row">
  <div class="col l4 m4 s12">
    <br>

    <table class="highlight striped cooltable">
      <thead>
        <tr>
          <th colspan="6" class="center-align"> Valores de la vigencias</th>
        </tr>
        <tr>
          <th>Vigencia</th>
          <th>F. Inicio</th>
          <th>F. fin</th>
          <th>A</th>
          <th>I</th>
          <th>U</th>
        </tr>
      </thead>
      <body>
        <tr ng-repeat="vg in contrato.vigencias" ng-if="vg.fecha_inicio_vigencia >= factura.fecha_inicio">
          <td> <span ng-bind="vg.descripcion_vigencia"></span> </td>
          <td><small ng-bind="vg.fecha_inicio_vigencia"></small></td>
          <td><small ng-bind="vg.fecha_fin_vigencia"></small></td>
          <td ng-bind="vg.a"></td>
          <td ng-bind="vg.i"></td>
          <td ng-bind="vg.u"></td>
        </tr>
      </body>
      <thead>
        <tr>
          <th colspan="6" class="center-align"> Resumen de valores </th>
        </tr>
        <tr>
          <th colspan="3">Concepto</th>
          <th colspan="3">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="3">Subtotal recursos</td>
          <td colspan="3" ng-init="factura.subtotal = (factura.subtotal?factura.subtotal:0)">{{ factura.subtotal | currency }}</td>
        </tr>
        <tr>
          <td colspan="3">Subtotal otros</td>
          <td colspan="3" ng-init="factura.otros = (factura.otros?factura.otros:0)">{{ factura.otros | currency }}</td>
        </tr>
        <tr>
          <td colspan="3">Total</td>
          <td colspan="3" ng-init="factura.total = (factura.total?factura.total:0)"> <b ng-bind="factura.total | currency"></b> </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="col l8 m8 s12 ">
    <p> Comentario / Descripción:</p>
    <textarea id="notas" ng-model="factura.descripcion" ng-disabled="factura.validado"
        style="border:1px solid #555; box-shadow: 0px 0px 3px #999 inset; min-height:90px; max-width: 100%; max-height: 500px;">
    </textarea>
  </div>

</div>
<br>

<style media="screen">
  table.cooltable th, table.cooltable td{
    padding: 5px;
    border: 1px solid #AAA;
    border-collapse: collapse;
  }
</style>
