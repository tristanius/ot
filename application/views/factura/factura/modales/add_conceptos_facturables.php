<div id="add_conceptos_facturables" class="modal padding1ex large" >
  <fieldset class="padding1ex noMaterialStyles" ng-init="otro_concepto={}">
    <legend>Agregar un concepto facturable:</legend>
    <div class="grid-x">
      <div class="col m12 l12 s12">
        <label for="">
          Item:
          <input type="text" ng-model="otro_concepto.item" placeholder="item para concepto de factura">
        </label>
      </div>
      <div class="col m12 l12 s12">
        <label for="">
          Concepto:
          <input type="text" ng-model="otro_concepto.concepto" placeholder="descripción concepto de factura">
        </label>
      </div>
      <div class="col m12 l12 s12">
        <label for="">
          Tipo:
          <select class="" ng-model="otro_concepto.tipo" >
            <option value="descuento">descuento</option>
            <option value="adicional">adicional</option>
          </select>
        </label>
      </div>
      <div class="col m12 l12 s12">
        <label for="">
          Valor:
          <input type="number" ng-model="otro_concepto.valor" placeholder="valor de concepto ej:100000">
        </label>
      </div>
    </div>

  </fieldset>
  <div class="modal-footer">
    <button type="button" class="btn btn-floating green modal-close" ng-click="addConceptoFactura(otro_concepto); otro_concepto={}"> <i data-icon="&#xe04c;"></i> </button>
    <button type="button" class="btn btn-floating red modal-close" ng-click="addConceptoFactura(otro_concepto); otro_concepto={}"> <i data-icon="&#xe04d;"></i> </button>
  </div>
</div>
