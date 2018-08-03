<fieldset class="row">
  <div class="col s12 m5">
    <div class="selectEnabled" style="margin:1ex;">
        <label class="right-align"><b style="color:#0D47A1">FECHA INICIO: </b>
        <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_inicio"  value="<?= date('Y-m-d') ?>" placeholder=" fecha" style="cursor: pointer" readonly/>
      </label>
    </div>
    <div class="selectEnabled" style="margin-right:1ex;">
        <label class="right-align"><b style="color:#0D47A1">FECHA FINAL: </b>
        <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_fin"  value="<?= date('Y-m-d') ?>" placeholder=" fecha" style="cursor: pointer"  readonly/>
      </label>
    </div>

    <div class="noMaterialStyles regularForm" ng-if="validPriv(49)" style="display: inline-block; margin:1ex;">
      <label for="" style="color:#0D47A1"> <b>Editar tarea:</b> </label>
      <input type="checkbox" ng-model="tr.editable">
    </div>
  </div>

  <div class="col s12 m6">
    <p class="selectEnabled">
      <label class="right-align"><b style="color:#0D47A1">SAP/Control: </b>
        <input type="text"  ng-model="tr.sap" placeholder=" No. control cambio/ Tarea" />
      </label>
      <label class="right-align"><b style="color:#0D47A1">Clase: </b>
        <select ng-model="tr.clase_sap">
          <option value="Z1 PM">Z1 PM</option>
          <option value="Z1 PM">Z1 PM</option>
          <option value="Z2 PM">Z2 PM</option>
          <option value="Z3 PM">Z3 PM</option>
          <option value="Z4 PC">Z4 PC</option>
          <option value="Z4 PM">Z4 PM</option>
          <option value="Z5 QM">Z5 QM</option>
          <option value="Z6 OM">Z6 OM</option>
          <option value="Z6 PC">Z6 PC</option>
          <option value="Z6 PM">Z6 PM</option>
          <option value="">N/A</option>
        </select>
      </label>
      <label class="right-align"><b style="color:#0D47A1">Tipo: </b>
        <select ng-model="tr.tipo_sap" >
          <option value="SUPERIOR">SUPERIOR</option>
          <option value="DERIVADA">DERIVADA</option>
          <option value="">N/A</option>
        </select>
      </label>
    </p>

    <p class="selectEnabled">
      <label class="right-align"><b style="color:#0D47A1">SAP para pago: </b>
        <input type="text"  ng-model="tr.sap_pago" placeholder=" # SAP para pago" />
      </label>
      <label class="right-align"><b style="color:#0D47A1">Clase: </b>
        <select ng-model="tr.clase_sap_pago">
          <option value="Z1 PM">Z1 PM</option>
          <option value="Z1 PM">Z1 PM</option>
          <option value="Z2 PM">Z2 PM</option>
          <option value="Z3 PM">Z3 PM</option>
          <option value="Z4 PC">Z4 PC</option>
          <option value="Z4 PM">Z4 PM</option>
          <option value="Z5 QM">Z5 QM</option>
          <option value="Z6 OM">Z6 OM</option>
          <option value="Z6 PC">Z6 PC</option>
          <option value="Z6 PM">Z6 PM</option>
          <option value="">N/A</option>
        </select>
      </label>
      <label class="right-align"><b style="color:#0D47A1">Tipo: </b>
        <select ng-model="tr.tipo_sap_pago" >
          <option value="SUPERIOR">SUPERIOR</option>
          <option value="DERIVADA">DERIVADA</option>
          <option value="">N/A</option>
        </select>
      </label>
    </p>
  </div>

</fieldset>
