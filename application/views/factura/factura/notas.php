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

    <table class="highlight striped">
      <thead>
        <tr>
          <th colspan="2" class="center-align"> Valores de la vigencias</th>
        </tr>
        <tr>
          <th>Vigencia</th>
          <th>A</th>
          <th>I</th>
          <th>U</th>
        </tr>
      </thead>
      <body>
        <tr ng-repeat="vg in contrato.vigencias" ng-if="vg.fecha_inicio_vigencia >= factura.fecha_inicio">
          <td> <span ng-bind="vg.descripcion_vigencia"></span> <small ng-bind="vg.fecha_inicio_vigencia"></small> </td>
          <td ng-bind="vg.a"></td>
          <td ng-bind="vg.i"></td>
          <td ng-bind="vg.u"></td>
        </tr>
      </body>
      <thead>
        <tr>
          <th colspan="4" class="center-align"> Resumen de valores </th>
        </tr>
        <tr>
          <th colspan="2">Concepto</th>
          <th colspan="2">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="2">Subtotal recursos</td>
          <td colspan="2" ng-init="factura.subtotal = (factura.subtotal?factura.subtotal:0)">{{ factura.subtotal | currency }}</td>
        </tr>
        <tr>
          <td colspan="2">Subtotal otros</td>
          <td colspan="2" ng-init="factura.otros = (factura.otros?factura.otros:0)">{{ factura.otros | currency }}</td>
        </tr>
        <tr>
          <td colspan="2">Total</td>
          <td colspan="2"> <h5 ng-init="factura.total = (factura.total?factura.total:0)">{{ factura.total | currency }}</h5> </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="col l8 m8 s12 ">
    <p> Comentario / Descripción:</p>
    <textarea id="notas" ng-model="factura.descripcion" ng-init="tinyMCE('#notas')" ng-disabled="factura.estado != 'CERRADO'"
        style="border:1px solid #555; box-shadow: 0px 0px 3px #999 inset; min-height:90px; width: 100%">
    </textarea>
  </div>

</div>
<br>


<script>tinymce.init({ selector:'#notas' });</script>
