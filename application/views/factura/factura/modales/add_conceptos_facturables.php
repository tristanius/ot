<div id="add_conceptos_facturables" class="modal" >
  <fieldset class="padding1ex noMaterialStyles">
    <legend>Agregar un concepto facturable:</legend>
    <div class="grid-x">
      <div class="col m4 l3 s6">
        <label for="">
          Item:
          <input type="text" ng-model="otro.item" value="">
        </label>
      </div>
      <div class="col m4 l3 s6">
        <label for="">
          Concepto:
          <input type="text" ng-model="otro.concepto" value="">
        </label>
      </div>
      <div class="col m4 l3 s6">
        <label for="">
          Tipo:
          <input type="text" ng-model="otro.tipo" value="">
        </label>
      </div>
      <div class="col m4 l3 s6">
        <label for="">
          Valor:
          <input type="number" ng-model="otro.total" value="">
        </label>
      </div>
    </div>
    <button type="button" class="btn btn-floating"> <i data-icon="&#xe04c;"></i> </button>
  </fieldset>
</div>
