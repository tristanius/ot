<section id="formItem"  class="modal modal-fixed-footer font12" ng-init="initModals('#formItem.modal')">

  <fieldset class="modal-content noMaterialStyles">
    <h4 class="grey lighten-5"> <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" style="max-width:100px;" /> Formulario de items de contrato</h4>

    <hr class="hr-termo">

    <div class="card-panel row">

      <h5 class="col l12">Información del item de contrato</h5>

      <div class="col m12 l3">
        <label class="black-text">No. Item: </label>
        <input type="text" ng-model="myitem.item" placeholder="Ej: 1.1"/>
      </div>

      <div class="col m12 l3">
        <label class="black-text">Descripción: </label>
        <input type="text" ng-model="myitem.descripcion" placeholder="Ej: Excavación"/>
      </div>

      <div class="col m12 l3">
        <label class="black-text">Unidad:</label>
        <select class="" ng-model="myitem.unidad">
          <option value="m3">m3</option>
          <option value="m2">m2</option>
          <option value="m">m (metro)</option>
          <option value="km">Km</option>
          <option value="Ha">Ha</option>
          <option value="hr">hr</option>
          <option value="dia/m3">dia/m3</option>
          <option value="día">día</option>
          <option value="mes">mes</option>
          <option value="und">und</option>
          <option value="ton">ton</option>
          <option value="kg">kg</option>
          <option value="Lb">Lb</option>
          <option value="turno">turno</option>
          <option value="gal">gal</option>
          <option value="Litro">Litro (L)</option>
          <option value="rollo">Rollo</option>
          <option value="kit">kit</option>
        </select>
        <p></p>
      </div>

      <div class="col m12 l3">
        <label class="black-text">Tipo item:</label>
        <select class="" ng-model="myitem.tipo">
          <option value="1">Actividad</option>
          <option value="2">Personal</option>
          <option value="3">Equipo</option>
          <option value="material">Material</option>
          <option value="otros">Otros</option>
        </select>
        <p></p>
      </div>

      <div class="col m12 l3">
        <label class="black-text">Especificacion de tipo:</label>
        <select class="" ng-model="myitem.idtipo_itemc">
          <option value="1">Actividad</option>
          <option value="2">Personal</option>
          <option value="3">Equipo</option>
          <option value="material">Material</option>
          <option value="otros">Otros</option>
        </select>
        <p></p>
      </div>

    </div>


    <div class="card-panel row">

      <h5 class="m12">Información interna</h5>

      <div class="col m12 l3">
        <label class="black-text">Codigo:</label>
        <input type="text" ng-model="myitem.codigo" placeholder="Ej: 10101"/>
      </div>

      <div class="col m12 l3">
        <label class="black-text">Descripción interna:</label>
        <input type="text" ng-model="myitem.descripcion_itemf" placeholder="Ej: Excavación"/>
      </div>

      <div class="col m12 l3">
        <label class="black-text">Base incidencia salarial:</label>
        <input type="text" ng-model="myitem.incidencia" placeholder="Ej: Excavación"/>
      </div>


      <div class="col m12 l12">
        <p>
          <label class="black-text">Calculo de disponibilidad ( hr/base: 4/25  ó proporcion: 0.25 ):</label>
          <input type="text" ng-model="myitem.calculo_disp" placeholder="Ej: 1/1"/>
        </p>
      </div>

      <div class="col m12 l12">
        <p>
          <label class="black-text">UND minima para disponibilidad (  {{ myitem.unidad }} ):</label>
          <input type="text" ng-model="myitem.und_minima" placeholder="Ej: 4"/>
        </p>
      </div>

    </div>

  </fieldset>


  <div class="modal-footer">
    <button type="button" class="btn btn-small green" ng-disabled="true" ng-click="save('<?= site_url('item/save') ?>', cont, '<?= site_url('item/get_itemc') ?>')">
      Guardar
    </button>
    <button type="button" class="btn btn-small red modal-close"> Salir</button>
  </div>

</section>
