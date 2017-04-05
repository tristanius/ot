<section ng-init="">
  <div class="">
    <h5>Responsables de la tarea:</h5>
    <fieldset>
      <div class="row">
        <div class="col s12 m6 l4">
          <label for=""> RESP. PYCO:  </label> <small ng-bind="tr.responsables.pyco"></small>
          <select class="noMaterialStyles"  ng-model="tr.responsables.pyco">
            <option value="FABIO ARIAS"> FABIO ARIAS </option>
            <option value="WILLIAM CHAVEZ"> WILLIAM CHAVEZ </option>
            <option value="MARCELA DIAZ"> MARCELA DIAZ </option>
            <option value="KAROL ORDOÑEZ"> KAROL ORDOÑEZ </option>
            <option value="JULIETH RAMIREZ"> JULIETH RAMIREZ </option>
            <option value="ANGEL ROPERO"> ANGEL ROPERO </option>
            <option value="OLGA MEJIA"> OLGA MEJIA </option>
            <option value="MEIRA RUIDIAZ"> MEIRA RUIDIAZ </option>
            <option value="NADIA NAVAS"> NADIA NAVAS </option>
          </select>
        </div>
        <div class="col s12 m6 l4">
          <label for=""> ING. RESIDENTE:  </label> <input type="text" ng-model="tr.responsables.ing_residente">
        </div>
        <div class="col s12 m6 l4">
          <label for=""> GESTOR TECNICO (ECP):  </label> <input type="text" ng-model="tr.responsables.gestor_tecnico_ecp">
        </div>
        <div class="col s12 m6 l4">
          <label for=""> CARGO GESTOR TECNICO:  </label> <input type="text" ng-model="tr.responsables.cargo_gestor_tecnico">
        </div>
        <div class="col s12 m6 l4">
          <label for=""> REGISTRO GESTOR TECNICO:  </label> <input type="text" ng-model="tr.responsables.registro_gestor_tecnico">
        </div>
        <br>
        <div class="col s12 m6 l4">
          <label for=""> FACTURADOR:  </label> <input type="text" ng-model="tr.responsables.facturador">
        </div>
      </div>
    </fieldset>
  </div>
  <hr>
  <div class="row">
    <fieldset>
    <div class="row">
      <h5>Verificación de requisitos_documentales:</h5>

        <div class="col s12  m6 l6 row">
          <label class="col s5">OT FIRMADA: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.OT_firmada">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">OT SAP LIBERADA: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.OT_SAP_liberada">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">ACTA ACLARATORIA: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.acta_aclaratoria">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">ACTA DE INICIO: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.acta_inicio">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">MATRIZ RAM: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.matriz_ram">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">AR: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.ar">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">MEMORANDO REEEMBOLSABLES FIRMADO: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.memorando_reembolsables">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">CRONOGRAMA: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.cronograma">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">PDT: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.pdt">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">DISEÑOS: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.disenos">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">PERMISOS INMOBILIARIOS: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.permisos_inmobiliarios">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">PERMISOS AMBIENTALES: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.permisos_ambientales">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12  m6 l6 row">
          <label class="col s5">SOCIALIZACION: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.socializacion">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>

        <div class="col s12 m6 l6 row">
          <label class="col s5">VISITA PRELIMINAR: </label>
          <select class="col s5" ng-model="tr.requisitos_documentales.vista_preliminar">
            <option value="OK">FIRMADO Y LEGALIZADO</option>
            <option value="NA">NO SE REQUIERE</option>
            <option value="P">PENDIENTE POR LEGALIZAR</option>
          </select>
        </div>
      </div>
    </fieldset>
  </div>
</section>
