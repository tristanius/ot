<section id="formItem"  class="modal modal-fixed-footer" ng-init="initModals('#formItem.modal')">

  <div class="modal-content noMaterialStyles">
    <h4 class="grey lighten-5"> <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" style="max-width:100px;" /> Formulario de items de contrato</h4>

    <hr class="hr-termo">

    <div class="row">
      <div class="card-panel col s12 m12 l6">

        <h5 class="col l12">Información del item de contrato</h5>

        <div class="row">
          <div class="col m12 l6">
            <label class="black-text">No. Item: </label>
            <div>
              <input type="text" ng-model="myitem.item" ng-disabled="myitem.iditemc" placeholder="Ej: 1.1" style="display:inline"/>
              <button type="button" class="btn btn-small" data-icon=","> <span>Validar</span> </button>
            </div>
          </div>

          <div class="col m12 l12">
            <label class="black-text">Descripción: </label>
            <textarea ng-model="myitem.descripcion" ng-disabled="myitem.iditemc && validateItem" class="padding1ex" placeholder="Descripcion del item de contrato"></textarea>
          </div>

          <div class="col m12 l3">
            <label class="black-text">Unidad:</label>
            <select class="" ng-model="myitem.unidad">
              <option value="m3">m3</option>
              <option value="m2">m2</option>
              <option value="metro">Metro</option>
              <option value="km">Km</option>
              <option value="Ha">Ha</option>
              <option value="hr">hr</option>
              <option value="dia/m3">dia/m3</option>
              <option value="día">día</option>
              <option value="mes">mes</option>
              <option value="und">und</option>
              <option value="ton">ton</option>
              <option value="kg">Kg</option>
              <option value="Lb">Lb</option>
              <option value="turno">Turno</option>
              <option value="gal">Gal</option>
              <option value="Litro">Litro (L)</option>
              <option value="LT">Litro (LT)</option>
              <option value="rollo">Rollo</option>
              <option value="kit">Kit</option>
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
            <select style="max-width:35ex;" ng-model="myitem.idtipo_itemc">
              <?php foreach ($tipos_itemc as $key => $tp): ?>
                <option value="<?= $tp->idtipo_itemc ?>"> <?= $tp->item.' '.$tp->descripcion." - ".$tp->grupo_mayor  ?> </option>
              <?php endforeach; ?>
            </select>
            <p></p>
          </div>
        </div>

      </div>

      <div class="card-panel col s12 m12 l6">

        <h5>Información interna</h5>

        <div class="row">
          <div class="col m12 l4">
            <label class="black-text">Codigo:</label>
            <input type="text" ng-model="myitem.codigo" ng-disabled="myitem.iditemf" placeholder="Ej: 10101"/>
          </div>

          <div class="col m12 l4">
            <label class="black-text">Descripción interna:</label>
            <input type="text" ng-model="myitem.descripcion_interna" placeholder="Ej: Excavación"/>
          </div>

          <div class="col m12 l3">
            <label class="black-text">Base incidencia salarial:</label>
            <input type="text" ng-model="myitem.incidencia" placeholder="Ej: Excavación"/>
          </div>


          <div class="col m12 l12">
            <label class="black-text">Calculo de disponibilidad ( hr/base: 4/25  ó proporcion: 0.25 ):</label>
            <input type="text" ng-model="myitem.calculo_disp" placeholder="Ej: 1/1"/>
          </div>

          <div class="col m12 l12">
            <label class="black-text">UND minima para disponibilidad (  {{ myitem.unidad }} ):</label>
            <input type="text" ng-model="myitem.und_minima" placeholder="Ej: 4"/>
            <p></p>
          </div>
        </div>

      </div>

    </div>

    <div class="card-panel">
      <table class="mytabla">
        <caption>Items internos relacionados</caption>
        <thead class="blue-grey lighten-4">
          <tr>
            <th>Item</th>
            <th>Cod. Interno</th>
            <th>Descripción Interna</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>


  <div class="modal-footer">
    <button type="button" class="btn btn-small green" ng-disabled="!myitem.item || !myitem.descripcion || !myitem.codigo || !myitem.descripcion_interna"
      ng-click="save('<?= site_url('item/save') ?>', myitem, '<?= site_url('item/get_itemc') ?>')">
      Guardar
    </button>
    <button type="button" class="btn btn-small red" ng-click="closeForm()"> Salir</button>
  </div>

</section>
