<section>
  <div class="">
    <h5>Información general de OT</h5>

    <br>

    <div style="padding:3px;" class="row">
      <div class="col s12 m12 l12">
        Fecha real inicio: <input type="text" class="datepicker" ng-model="ot.fecha_inicio" ng-init="datepicker_init()" placeholder="fecha inicio real">
      </div>
      <div class="col s12 m12 l12">
        Fecha real final: <input type="text" class="datepicker" ng-model="ot.fecha_fin" ng-init="datepicker_init()" placeholder="fecha fin real">
      </div>
    </div>

    <br>

    <div class="row" style="background:#F1F1F1; padding:3px;">
      O.T. Legalizada: <input type="text" ng-model="ot.ot_legalizada" placeholder="Orden legalizada" ng-readonly="!validPriv(54)">
    </div>

    <div class="row" style="background:#F1F1F1; padding:3px;">
      F. creación C.C.: <input type="text" class="datepicker" ng-model="ot.fecha_creacion_cc" placeholder="Orden legalizada" ng-disabled="!validPriv(54)">
    </div>

    <br>

    <div style="background:#F1F1F1; padding:3px;" class="row">
      <div class="col s12 m12 l12">
        Presupuesto Interno inicial:
        <input type="text" class="datepicker" ng-model="ot.presupuesto_fecha_ini" ng-init="datepicker_init()" placeholder="P Interno fecha inicial" ng-disabled="!validPriv(54)">
        <input type="text" ng-model="ot.presupuesto_porcent_ini" placeholder="%" ng-readonly="!validPriv(54)">
      </div>
      <div class="col s12 m12 l12">
        Presupuesto Interno Final:
        <input type="text" class="datepicker" ng-model="ot.presupuesto_fecha_fin" ng-init="datepicker_init()" placeholder="P. interno fecha Final" ng-disabled="!validPriv(54)">
        <input type="text" ng-model="ot.presupuesto_porcent_fin" placeholder="%" ng-readonly="!validPriv(54)">
      </div>
    </div>

    <br>
    <section ng-if="0 && validPriv(37)">

        <div class="">
          <button type="button" class="btn mini-btn" ng-click="add_new_costo_mes_ot = true">+</button> Add. año de costos
          <div ng-show="add_new_costo_mes_ot" ng-init="add_new_costo_mes_ot = false">
            <label for="">Año de control de costo:</label>
            <input type="text" ng-model="costo_year" />
            <button type="button" name="btn mini-btn2"
                ng-click="ot.allMeses.push(
                  {OT_idOT: ot.idOT,year: costo_year, enero:0,febrero:0,marzo:0,abril:0,mayo:0,junio:0,julio:0,agosto:0,septiembre:0,octubre:0,noviembre:0,diciembre:0 }
                  )">
                Agregar
            </button>
          </div>
        </div>

        <div ng-repeat="meses in ot.allMeses">
          <hr>
          <b>Costo mes a mes: <span ng-bind="meses.year"></span> </b>
          <div class="row">
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                enero: <span ng-bind="meses.enero | currency"></span>
              </label>
              <input type="text" ng-model="meses.enero" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                febrero: <span ng-bind="meses.febrero | currency"></span>
              </label>
              <input type="text" ng-model="meses.febrero" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                marzo: <span ng-bind="meses.marzo | currency"></span>
              </label>
              <input type="text" ng-model="meses.marzo" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                abril: <span ng-bind="meses.abril | currency"></span>
              </label>
              <input type="text" ng-model="meses.abril" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                mayo: <span ng-bind="meses.mayo | currency"></span>
              </label>
              <input type="text" ng-model="meses.mayo" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                junio: <span ng-bind="meses.junio | currency"></span>
              </label>
              <input type="text" ng-model="meses.junio" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                julio: <span ng-bind="meses.julio | currency"></span>
              </label>
              <input type="text" ng-model="meses.julio" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                agosto <span ng-bind="meses.agosto | currency"></span>
              </label>
              <input type="text" ng-model="meses.agosto" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                septiembre: <span ng-bind="meses.septiembre | currency"></span>
              </label>
              <input type="text" ng-model="meses.septiembre" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                octubre <span ng-bind="meses.octubre | currency"></span>
              </label>
              <input type="text" ng-model="meses.octubre" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                noviembre: <span ng-bind="meses.noviembre | currency"></span>
              </label>
              <input type="text" ng-model="meses.noviembre" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>
            <div class="col l2 m4 s6">
              <label style="display:block" for="">
                diciembre: <span ng-bind="meses.diciembre | currency"></span>
              </label>
              <input type="text" ng-model="meses.diciembre" ng-change="acumularMeses(meses)" ng-init="acumularMeses(meses)">
            </div>

            <b>Total: <span ng-bind="meses.total | currency"></span></b>

          </div>
        </div>
    </section>

  </div>
</section>
