  <section>
    <table>
      <thead>
        <tr>
          <th>ELABORADOR POR:</th>
          <th>REPRESENTANTE CONTRATISTA</th>
          <th>REPRESENTANTE CLIENTE</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Nombre: <input type="text" ng-model="rd.info.elaborador_nombre" value="" ng-readonly="rd.info.estado == 'CERRADO' " > </td>
          <td>Nombre: <input type="text" ng-model="rd.info.contratista_nombre" value="" > </td>
          <td>Nombre: <input type="text" ng-model="rd.info.ecopetrol_nombre" value="" > </td>
        </tr>
        <tr>
          <td>Cargo: <input type="text" ng-model="rd.info.elaborador_cargo" value="" ng-readonly="rd.info.estado == 'CERRADO' " > </td>
          <td>Cargo: <input type="text" ng-model="rd.info.contratista_cargo" value="" > </td>
          <td>Cargo: <input type="text" ng-model="rd.info.ecopetrol_cargo" value="" > </td>
        </tr>
      </tbody>
    </table>
  </section>
