<div class="" ng-if="!ot.frentes">
  Parece que esta OT no tiene frentes de trabajo, debes activar la opción aquí: <button type="button" class="btn mini-btn2" ng-click="ot.frentes = []">activar</button>
</div>
<section ng-if="ot.frentes">

  <h5>Frentes de labores de la orden de trabajo:</h5>

  <div class="card-panel regularForm noMaterialStyles">
    <strong>AGREGAR UN FRENTE</strong>
    <div class="">
      <label>
        Nombre del frente:
        <input type="text" ng-model="frente.nombre" ng-init="frente.nombre = 'frente'+(ot.frentes.length+1)" ng-disabled="true">
      </label>

      <label>
        Ubicación del frente:
        <input type="text" ng-model="frente.ubicacion">
      </label>

      <label>
        Usuario asignado:
        <select class="" ng-model="frente.usuario" ng-options="u as u.nombres+' '+u.apellidos for u in lista_usuarios">
        </select>
      </label>

      <button type="button" class="btn-floating btn" ng-disabled=" frente.nombre == undefined || frente.nombre == '' "
        ng-click="addFrente( '<?= site_url("ot/add_frente/") ?>', ot.frentes, frente); frente = {nombre: 'frente'+(ot.frentes.length+1)}">
        +
      </button>

    </div>
  </div>

  <div class="center-align">
    <table class="mytabla" style="max-width:200ex;">
      <caption>Frente de trabajo</caption>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Ubicación</th>
          <th>Usuario</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="f in ot.frentes">
          <td>{{f.nombre}}</td>
          <td>{{f.ubicacion}}</td>
          <td ng-init="f.usuario = parseJSON(f.usuario)">{{f.usuario.nombres}}</td>
          <td>
            <button type="button" name="button"></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
