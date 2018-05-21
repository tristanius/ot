<div class="">
  <b> Tipo de acta: </b>
  <select ng-model="factura.tipo_acta" ng-init="factura.tipo_acta = (factura.tipo_acta?factura.tipo_acta:'FACTURA')">
    <option value="FACTURA">FACTURA</option>
    <option value="REAJUSTE">REAJUSTE</option>
    <option value="COBRO OTRO">COBRO OTRO</option>
  </select>
</div>

<div class="">
  <p> Notas:</p>
  <textarea id="notas" ng-model="factura.descripcion" style="border:1px solid #555; box-shadow: 0px 0px 3px #999 inset; min-height:90px"></textarea>
</div>
