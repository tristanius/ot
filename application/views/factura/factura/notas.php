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
    <p>Valores generales</p>

    <table class="mytabla">
      <thead>
        <tr>
          <th>Concepto</th>
          <th>Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Actividad $</th>
          <td></td>
        </tr>
        <tr class="grey lighten-3">
          <th>Personal $</th>
          <td></td>
        </tr>
        <tr>
          <th>Equipo $</th>
          <td></td>
        </tr>
        <tr class="grey lighten-3">
          <th>Material $</th>
          <td></td>
        </tr>
        <tr>
          <th>Otros $</th>
          <td></td>
        </tr>
        <tr class="grey lighten-3">
          <th>Subtotal $</th>
          <td ng-bind="factura.subtotal | currency"></td>
        </tr>
      </tbody>
    </table>

  </div>

  <div class="col l8 m8 s12 ">
    <p> Notas:</p>
    <textarea id="notas" ng-model="factura.descripcion" ng-init="tinymce('#notas')" style="border:1px solid #555; box-shadow: 0px 0px 3px #999 inset; min-height:90px"></textarea>
  </div>

</div>
<br>

<div class="grey lighten-3 padding1ex" style="border-radius: 10px">
  <div ng-init="factura.total = factura.total? factura.total: 0;">
    <h5>Total: {{ factura.total | currency }}</h5>
  </div>
</div>


<script>tinymce.init({ selector:'#notas' });</script>
