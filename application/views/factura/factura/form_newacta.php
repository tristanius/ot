<div class="col m12 s12 l12">
  <hr>
  <section class="regularForm noMaterialStyles">
    <label for="">Acta serv.:</label><input type="text" ng-model="myacta"><button type="button" ng-click="addActa(myacta)">Add</button>
  </section>
  <section class="regularForm noMaterialStyles">
    <label>Estado documento: </label>
    <select class="" ng-model="myestado" ng-disabled="fac.estado == 'FINALIZADO'">
      <option value="ELABORACION">ELABORACION</option>
      <option value="SEGUIMIENTO">SEGUIMIENTO</option>
      <option value="FINALIZADO">FINALIZADO</option>
    </select>
    <button type="button" ng-if="fac.estado != 'FINALIZADO'" ng-click="fac.estado = myestado">Cambiar</button>
  </section>

  {{fac.estado}}
  <hr>
</div>
