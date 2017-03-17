<div class="">
  <table class="mytabla centered noMaterialStyles">
    <thead>
      <tr>
        <th><b style="color: #C9302C">PK<b></th>
        <th>Coordenadas</th>
        <th>Planta/estacion</th>
		    <th><b style="color: #C9302C">Linea</b></th>
        <th><b style="color: #C9302C">Muncipio</b></th>
        <th>Sistema (ecp)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td> <input type="text" ng-model="rd.info.pk"></td>
        <td> <input type="text" ng-model="rd.info.coordenadas"></td>
        <td> <input type="text" ng-model="rd.info.planta"></td>
		    <td> <input type="text" ng-model="rd.info.Linea"></td>
        <td> <input type="text" ng-model="rd.info.municipio" value=""> </td>
        <td> <input type="text" ng-model="rd.info.sistema_ecp" value=""> </td>
      </tr>
    </tbody>
  </table>


  <table class="mytabla centered">
    <thead>
      <tr class="noHoverColor">
        <th style="width:15%">Terreno</th>
        <th>Seguridad ambiental</th>
        <th>Noche Ant.</th>
        <th colspan="3">Condiciones Climaticas</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noMaterialStyles left-align font10 noHoverColor">
        <td>
          <label for="">
            Terreno:
            <select ng-model="rd.info.terreno">
              <option value="Seco">Seco</option>
              <option value="Humedo">Humedo</option>
              <option value="Estable">Estable</option>
              <option value="Inestable">Inestable</option>
            </select>
          </label>
        </td>
        <td>
          <div class="noMaterialStyles left-align font10">
            <label >
              Clima:
              <select class="" ng-model="rd.info.seguridad_ambiental">
                <option value="Excelente">Excelente</option>
                <option value="Normal">Normal</option>
                <option value="Deficiente">Deficiente</option>
              </select>
            </label>
          </div>
        </td>
        <td>
          <input type="text" ng-model="rd.info.noche_anterior">
        </td>
        <td class="inputsSmall">
            Hr. inicio lluvia: <input type="text" ng-model="rd.info.hr_inicio_lluvia" >
        </td>
        <td class="inputsSmall">
            Hr. fin lluvia: <input type="text" ng-model="rd.info.hr_fin_lluvia" >
        </td>
        <td>
          Total horas: <input type="text" ng-model="rd.info.total_hr_clima">
        </td>
      </tr>
    </tbody>
  </table>

  <table class="mytabla inputsSmall">
    <thead>
      <tr class="noHoverColor">
        <th colspan="2"> ACTIVIDADES </th>
      </tr>
    </thead>
    <tbody>
      <tr class="noHoverColor">
        <td>
          <div class="font10 row">
              <big class="col s12 center-align"><b>ILICITAS</b></big>
              <label class="col m4 noMaterialStyles">
                EXTENSION:
                <select ng-model="rd.info.actividades.extension" >
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>
                </select>
              </label>

              <label class="col m4" for="">
                DIAMETRO: <input type="text" ng-model="rd.info.actividades.diametro">
              </label>
              <label class="col m4" for="">
                LONGITUD: <input type="text" ng-model="rd.info.actividades.longitud">
              </label>
              <label class="col m4" for="">
                METERIAL: <input type="text" ng-model="rd.info.actividades.material">
              </label>
          </div>
        </td>
        <td>
          <div class="row font10">
              <big class="col s12 center-align"><b>REPARACION</b></big>
              <label class="col m4" for="">
                INST. CAPUCHON: <input type="text" ng-model="rd.info.actividades.capuchon">
              </label>
              <label class="col m4 " for="">
                INST. CASCOTA: <input type="text" ng-model="rd.info.actividades.cascota">
              </label>
              <label class="col m4 " for="">
                COMBIO TRAMO: <input type="text" ng-model="rd.info.actividades.tramo">
              </label>
              <label class="col m4 " for="">
                INST. DE CAMISA: <input type="text" ng-model="rd.info.actividades.camisa">
              </label>
              <label class="col m4 " for="">
                RETIDO DE GRAPA: <input type="text" ng-model="rd.info.actividades.grapa">
              </label>
              <label class="col m4 " for="">
                ANILLO CIRCUNFERENCIAL: <input type="text" ng-model="rd.info.actividades.anillo_circunferencial">
              </label>
          </div>
        </td>
        <td>
          <label for="">Otros: <input type="text" ng-model="rd.info.actividad.otros"></label>
        </td>
      </tr>
    </tbody>
  </table>
</div>
