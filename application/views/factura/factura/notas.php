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

    <table>
      <thead>
        <tr>
          <th>Concepto</th>
          <th>Valor</th>
        </tr>
      </thead>
      <body>
        <tr>
          <td>% de administración</td>
          <td>{{factura.vigencia_tarifas.a }}</td>
        </tr>
        <tr>
          <td>% de utilidad</td>
          <td>{{factura.vigencia_tarifas.i }}</td>
        </tr>
        <tr>
          <td>% de imprevistos</td>
          <td>{{factura.vigencia_tarifas.u }}</td>
        </tr>
        <tr>
          <td>Subtotal recursos</td>
          <td>{{ factura.subtotal | currency }}</td>
        </tr>
        <tr>
          <td>Total</td>
          <td> <h5>{{ factura.total | currency }}</h5> </td>
        </tr>
      </body>
    </table>

    <div class="grey lighten-3 padding1ex" style="border-radius: 10px">
      <div ng-init="factura.total = factura.total? factura.total: 0;">
        <h5>Total: {{ factura.total | currency }}</h5>
      </div>
    </div>
  </div>

  <div class="col l8 m8 s12 ">
    <p> Notas:</p>
    <textarea id="notas" ng-model="factura.descripcion" ng-init="tinymce('#notas')" ng-disabled="factura.estado != 'CERRADO'"
        style="border:1px solid #555; box-shadow: 0px 0px 3px #999 inset; min-height:90px; width: 100%">
    </textarea>
  </div>

</div>
<br>


<script>tinymce.init({ selector:'#notas' });</script>
