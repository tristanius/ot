<section id="formContrato" class="windowCentered2" ng-controller="form_contrato">
  <fieldset class="padding1ex">
    <h4>Formulario de contrato</h4>
  </fieldset>
  <div class="grid-x">
    <div class="col m12 m5 padding1ex">
      <label>No. del contrato: </label>
      <input type="text" ng-model="cont.no_contrato">
    </div>

    <div class="col m12 m5 padding1ex">
      <label>Contratista: </label>
      <input type="text" ng-model="cont.contratista">
    </div>


    <div class="col m12 m5 padding1ex">
      <label>Cliente: </label>
      <input type="text" ng-model="cont.cliente">
    </div>

    <div class="col m12 m5 padding1ex">
      <label>Cliente: </label>
      <textarea name="name" rows="8" cols="80" ng-model="cont.objeto"></textarea>
    </div>

    <div class="col m12 m5 padding1ex">
      <label>Estado: </label>
      <input type="checkbox" ng-model="cont.estado" value="">
    </div>


    <div class="col m12 m5 padding1ex">
      <label>Inicio estimado: </label>
      <input type="text" ng-model="cont.fecha_inicio_estimado">
    </div>

    <div class="col m12 m5 padding1ex">
      <label>Fin estimado: </label>
      <input type="text" ng-model="cont.fecha_final_estimado">
    </div>
  </div>
  <hr>
  <div class="right">
    <button type="button" class="btn btn-small green"> Guardar</button>
    <button type="button" class="btn btn-small red" ng-click="confirmarCerrar('¿Estas seguro de cerrar el formulario de factura?','#ventanaFactura', enlaceGetFactura)"> Cancelar</button>
  </div>
</section>
