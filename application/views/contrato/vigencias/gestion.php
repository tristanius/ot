<section ng-controller="vigencias">
  <h4>Vigencias de tarifas por contrato</h4>

  <div class="card-panel row">
    <div class="col s12 m5">
      <label>No. Contrato: </label>
      <b ng-bind="contrato.no_contrato"></b>
      <button type="button" class="btn btn-small blue-grey darken-4">Seleccionar</button>
    </div>

    <div class="col s12 m7">
      <table class="mytabla">
        <thead class=" indigo lighten-5">
          <tr>
            <th colspan="4">Informacion contrato No. <span ng-bind="contrato.no_contrato"></span> </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Contratista:</th>
            <td ng-bind="contrato.contratista"></td>

            <th>Objeto del contrato:</th>
            <td ng-bind="contrato.objeto"></td>
          </tr>
          <tr>
            <th>Cliente:</th>
            <td ng-bind="contrato.cliente"></td>

            <th>Estado:</th>
            <td ng-bind="contrato.estado?'Activo':'No activo'"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <br>

  <div class="card-panel">
    
  </div>
</section>
