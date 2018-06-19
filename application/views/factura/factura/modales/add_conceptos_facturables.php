<div id="add_conceptos_facturables" class="modal" >
  <fieldset class="padding1ex noMaterialStyles" ng-init="otro_concepto={}">
    <legend>Agregar un concepto facturable:</legend>
    <div class="grid-x">
      <div class="col m4 l3 s6">
        <label for="">
          Item:
          <input type="text" ng-model="otro_concepto.item" value="">
        </label>
      </div>
      <div class="col m4 l3 s6">
        <label for="">
          Concepto:
          <input type="text" ng-model="otro_concepto.concepto" value="">
        </label>
      </div>
      <div class="col m4 l3 s6">
        <label for="">
          Tipo:
          <select class="" ng-model="otro_concepto.tipo" >
            <option value="descuento">descuento</option>
            <option value="adicional">adicional</option>
          </select>
        </label>
      </div>
      <div class="col m4 l3 s6">
        <label for="">
          Valor:
          <input type="number" ng-model="otro_concepto.valor" value="">
        </label>
      </div>
    </div>
    <button type="button" class="btn btn-floating" ng-click="addConceptoFactura(otro_concepto); otro_concepto={}"> <i data-icon="&#xe04c;"></i> </button>
  </fieldset>
</div>
