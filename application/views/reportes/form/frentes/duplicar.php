<section id="" ng-if="duplicar_frente" ng-init="duplicar_frente = false">

  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn modal-trigger" href="#duplicar">Modal</a>

  <!-- Modal Structure -->
  <div id="duplicar" class="modal">
    <table>
      <thead>
        <tr>
          <th>Orden</th>
          <th>Fecha reporte</th>
          <th>Frente</th>
          <th>selecionar</th>
        </tr>
        <tr>
          <th></th>
          <th> <input type="text" ng-model="filDuplicarFrente.fecha"> </th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>

</section>
